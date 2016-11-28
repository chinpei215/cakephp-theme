<?php
$this->layout = 'dev_error';

$this->assign('title', __d('cake_dev', 'Missing Plugin'));

$this->start('subheading');
?>
<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
<?php echo __d('cake_dev', 'The application is trying to load a file from the %s plugin', '<em>' . h($plugin) . '</em>'); ?>
<br>
<br>
<?php echo __d('cake_dev', 'Make sure your plugin %s is in the %s directory and was loaded', $plugin, APP_DIR . DS . 'Plugin'); ?>
<?php $this->end() ?>

<?php $this->start('file') ?>
<?php
$code = <<<PHP
<?php
CakePlugin::load('{$plugin}');
PHP;
?>
<div class="code-dump"><?php highlight_string($code) ?></div>

<p class="notice">
	<strong><?php echo __d('cake_dev', 'Loading all plugins'); ?>: </strong>
	<?php echo __d('cake_dev', 'If you wish to load all plugins at once, use the following line in your %s file', APP_DIR . DS . 'Config' . DS . 'bootstrap.php'); ?>
</p>

<?php
$code = <<<PHP
<?php
CakePlugin::loadAll();
PHP;
?>
<div class="code-dump"><?php highlight_string($code) ?></div>
<?php $this->end() ?>
