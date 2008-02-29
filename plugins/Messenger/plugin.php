<?php
class Message extends Model {
	var $model = 'message';
	var $post_id = 0;

	function _init() {
		$this->table = get_table_name('message');
	}
	function find($id) {
		return find('message', $id);
	}
	function get_unread_messages_of($user) {
		return find_first('message', "`to`=$user->id AND NOT `read`");
	}
	function mark_all_read($user) {
		update_all('message', array('read' => 1), "`to`=$user->id");
	}
	function get_sender() {
		return User::find($this->from);
	}
	function get_post() {
		return Post::find($this->post_id);
	}
	function mark_as_read() {
		update_all('message', array('read' => 1), "id=$this->id");
	}
}

function print_unread_messages($messages) {
	$messages_count = count($messages);
?>
<div id="message-box">
<div class="message-actions">
<a href="<?=url_for('message', 'read')?>all" onclick="markAllRead(this.href); return false">Mark all read</a> /
<a href="#" onclick="$('message-box').hide()">Close</a>
</div>
<h1>You've got <span id="messages-count"><?=$messages_count?></span> message(s)</h1>
<ul>
<?php foreach ($messages as $n => $message) { ?>
	<li id="message-<?=$n+1?>"<? if ($n > 0) { ?> style="display: none"<? } ?>>
		<? if ($message->from) { ?><?=link_to_user($message->get_sender())?>, <? } ?><?=date("Y-m-d H:i:s", $message->sent_at)?> / <a href="<?=url_for($message, 'read')?>" onclick="return true; markAsRead(this.href, 'message-<?=$n+1?>'); return false">Mark as read</a>
		<div class="message-body">
		<?=format_plain($message->body)?>
		</div>
		<? if ($message->post_id) { ?>
		(from <?=link_to_post($post = $message->get_post())?><? if ($post->category_id) { ?> / Category: <? $category = $post->get_category(); echo htmlspecialchars($category->name); ?><? } ?>)
		<? } ?>
		<div class="message-nav">
		<? if ($n > 0) { ?><a href="#" onclick="showMessage(<?=$n?>); return false">&lsaquo; Previous</a><? } ?>
		<strong><?=$n+1?></strong> / <?=$messages_count?>
		<? if ($n != $messages_count-1) { ?><a href="#" onclick="showMessage(<?=$n+2?>); return false">Next &rsaquo;</a><? } ?>
		</div>
	</li>
<?php } ?>
</ul>
</div>

<script type="text/javascript">
var box = $('message-box');
box.setStyle({
	position: 'absolute',
	top: 0,
	right: 0,
	opacity: 0.9
});

function markAllRead(href) {
	if (window.confirm('<?=i('Are you sure?')?>')) {
		new Ajax.Request(href, {
			method: 'get',
			onSuccess: function () { $('message-box').hide(); }
		});
	}
}
function markAsRead(href, id) {
	new Ajax.Request(href, {
		method: 'get',
		onSuccess: function () {
			var count = $('messages-count');
			count.innerHTML = parseInt(count.innerHTML) - 1;
			if (count.innerHTML == '0') $('message-box').hide();
			else $(id).remove();
		}
	});
}

function showMessage(index) {
	$$('#message-box li').map(Element.hide);
	$('message-'+index).show();
}
</script>
<?php
}

class Messenger extends Plugin {
	var $plugin_name = '쪽지';
	var $description = '답글이 달리면 쪽지로 알립니다.';

	function on_init() {
		global $account, $layout;
		$messages = Message::get_unread_messages_of($account);
		if ($messages) {
			ob_start();
			print_unread_messages($messages);
			$content = ob_get_contents();
			ob_end_clean();
			$layout->footer .= $content;
			$layout->add_stylesheet(METABBS_BASE_PATH . 'plugins/Messenger/style.css');
		}
		add_handler('message', 'read', array(&$this, 'action_read'));
		add_handler('user', 'send-message', array(&$this, 'action_send_message'));
		add_filter('PostComment', array(&$this, 'notify_reply'), 1024);
		add_filter('UserInfo', array(&$this, 'add_message_link'), 200);
	}
	function notify_reply(&$comment) {
		global $account;
		$parent = $comment->get_parent();
		$post = $comment->get_post();

		if ($parent && $parent->user_id && $parent->user_id != $post->user_id) {
			$message = new Message;
			$message->from = $account->id;
			$message->to = $parent->user_id;
			$message->body = $comment->body;
			$message->post_id = $comment->post_id;
			$message->sent_at = time();
			$message->read = 0;
			$message->create();
		}

		if ($post->user_id && $post->user_id != $account->id) {
			$message = new Message;
			$message->from = $account->id;
			$message->to = $post->user_id;
			$message->body = $comment->body;
			$message->post_id = $comment->post_id;
			$message->sent_at = time();
			$message->read = 0;
			$message->create();
		}
	}
	function add_message_link(&$user) {
		if ($GLOBALS['account']->is_guest()) return;
		$user->additional_info .= "<p>".link_to('Send Message', $user, 'send-message')."</p>";
	}
	function action_read() {
		global $id, $account;
		if ($id == 'all') {
			Message::mark_all_read($account);
		} else {
			$message = Message::find($id);
			if ($message->to == $account->id) {
				$message->mark_as_read();
			}
			redirect_back();
		}
	}
	function action_send_message() {
		global $template, $id, $user, $account;
		if ($account->is_guest())
			access_denied();
		$user = User::find($id);
		if (is_post()) {
			$message = new Message;
			$message->from = $account->id;
			$message->to = $user->id;
			$message->body = $_POST['body'];
			$message->sent_at = time();
			$message->read = 0;
			$message->create();

			redirect_to(url_for($user));
		}
		ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));
	}
	function on_install() {
		$db = get_conn();
		$t = new Table('message');
		$t->column('from', 'integer');
		$t->column('to', 'integer');
		$t->column('body', 'text');
		$t->column('post_id', 'integer');
		$t->column('sent_at', 'timestamp');
		$t->column('read', 'boolean');
		$t->add_index('to');
		$db->add_table($t);
	}
}

register_plugin('Messenger');
?>
