<h1 id="board-title"><?=$board->title?></h1>

<div id="account-info">
<? foreach (get_account_control($account) as $account_link):?>
<?= $account_link ?> 
<? endforeach; ?>
</div>

<?=flash_message_box()?>

<? include '_list.php'; ?>
