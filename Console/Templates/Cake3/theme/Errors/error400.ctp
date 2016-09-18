<?php
$this->assign('title', __d('cake', 'Error'));
?>
<h2><?php echo $message; ?></h2>
<p class="error">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php echo __d('cake', 'The requested address %s was not found on this server.', "<strong>'{$url}'</strong>") ?>
</p>
