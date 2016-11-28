<?php
$this->layout = 'dev_error';

$this->assign('title', __d('cake_dev', 'Missing Layout'));
?>
<?php $this->start('subheading') ?>
<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
<?php echo __d('cake_dev', 'The layout file %s can not be found or does not exist.', '<em>' . h($file) . '</em>'); ?>
<?php $this->end() ?>

<?php $this->start('file') ?>
<p>
	<?php echo __d('cake_dev', 'Confirm you have created the file: %s', h($file)); ?>
	in one of the following paths:
</p>
<ul>
<?php
	$paths = $this->_paths($this->plugin);
	foreach ($paths as $path):
		if (strpos($path, CORE_PATH) !== false) {
			continue;
		}
		echo sprintf('<li>%s%s</li>', h($path), h($file));
	endforeach;
?>
</ul>
<?php $this->end() ?>
