<?php
$this->layout = 'dev_error';

$this->assign('title', __d('cake_dev', 'Missing Database Connection'));

$this->start('subheading');
?>
<?php echo __d('cake_dev', 'A Database connection using "%s" was missing or unable to connect.', h($class)); ?>
<br />
<?php
if (isset($message)):
	echo __d('cake_dev', 'The database server returned this error: %s', h($message));
endif;
$this->end();
?>

<?php $this->start('file') ?>
<?php if (!$enabled) : ?>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', '%s driver is NOT enabled', h($class)); ?>
</p>
<?php endif; ?>
<?php $this->end() ?>
