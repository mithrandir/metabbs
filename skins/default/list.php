<p>Total <?=$this->board->get_post_count()?> posts.</p>
<table id="list">
    <tr>
        <th class="name">Name</th>
        <th class="subject">Subject</th>
        <th class="date">Date</th>
    </tr>
<?php foreach ($this->posts as $_ => $post) { ?>
    <tr>
        <td class="name"><?=$post->name?></td>
        <td class="subject"><?=link_to_post($post)?> <?php if ($post->get_comment_count() > 0) { ?><span class="comment_count">[<?=$post->get_comment_count()?>]</span><?php } ?></td>
        <td class="date"><?=date("Y-m-d H:i", $post->created_at)?></td>
    </tr>
<?php } ?>
</table>
<?php
function pagenate($board, $page) {
    $page_count = ceil($board->get_post_count()/$board->posts_per_page);
    $page_group_start = $page - 2;
    $page_group_end = $page + 2;
    if ($page_group_start < 1) $page_group_start = 1;
    if ($page_group_end > $page_count) $page_group_end = $page_count;
    $str = "";
    $pages = range($page_group_start, $page_group_end);
    if ($page > 1) {
        $prev_page = $page - 1;
        $str .= "<a href='?bid=$bid&amp;page=$prev_page'>&laquo;</a> ";
    }
    if ($page_group_start != 1) {
        $str .= "<a href='?bid=$bid&amp;page=1'>1</a> ... ";
    }
    foreach ($pages as $p) {
        if ($p == $page) {
            $str .= "<span class='current_page'>$p</span> ";
        } else {
            $str .= "<a href='?bid=$bid&amp;page=$p'>$p</a> ";
        }
    }
    if ($page < $page_count) {
        $next_page = $page + 1;
        $str .= "<a href='?bid=$bid&amp;page=$next_page'>&raquo;</a>";
    }
    return $str;
}
?>
<p><?=pagenate($this->board, $this->page)?></p>
<?=link_to_board($this->board, "New Post", "new")?>
