<?php
$this->layout = 'dev_error';
$this->assign('title', __d('cake_dev', 'Missing Database Connection'));

$this->start('subheading');
?>
<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
<?php echo __d('cake_dev', 'Scaffold requires a database connection'); ?>
<?php $this->end() ?>

<?php $this->start('file') ?>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Confirm you have created the file: %s', APP_DIR . DS . 'Config' . DS . 'database.php'); ?>
</p>
<?php $this->end() ?>
