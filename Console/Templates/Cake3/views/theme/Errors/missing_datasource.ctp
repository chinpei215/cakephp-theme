<?php
$this->layout = 'dev_error';
$pluginDot = empty($plugin) ? null : $plugin . '.';

$this->assign('title', __d('cake_dev', 'Missing Datasource'));

$this->start('subheading');
?>
<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
<?php echo __d('cake_dev', 'Datasource class %s could not be found.', '<em>' . h($pluginDot . $class) . '</em>'); ?>
<?php if (isset($message)): ?>
	<?php echo h($message); ?>
<?php endif; ?>
<?php $this->end() ?>
