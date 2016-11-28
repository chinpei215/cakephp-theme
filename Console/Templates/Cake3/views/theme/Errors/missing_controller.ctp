<?php
$this->layout = 'dev_error';

$pluginDot = empty($plugin) ? null : $plugin . '.';

$this->assign('title', __d('cake_dev', 'Missing Controller'));

$this->start('subheading');
?>
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', '%s could not be found.', '<em>' . h($pluginDot . $class) . '</em>'); ?>
<?php $this->end() ?>

<?php $this->start('file') ?>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Create the class %s below in file: %s', '<em>' . h($class) . '</em>', (empty($plugin) ? APP_DIR . DS : CakePlugin::path($plugin)) . 'Controller' . DS . h($class) . '.php'); ?>
</p>

<?php
$code = <<<PHP
<?php
class {$class} extends {$plugin}AppController {

}
PHP;
?>
<div class="code-dump"><?php highlight_string($code) ?></div>
<?php $this->end() ?>
