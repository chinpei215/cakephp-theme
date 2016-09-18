<?php
$this->layout = 'dev_error';

$this->assign('title', __d('cake_dev', 'Missing Method in %s', h($controller))); 
$this->assign('subheading', __d('cake_dev', 'The action %1$s is not defined in controller %2$s', '<em>' . h($action) . '</em>', '<em>' . h($controller) . '</em>'));
?>
<?php $this->start('file') ?>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Create %1$s%2$s in file: %3$s.', '<em>' . h($controller) . '::</em>', '<em>' . h($action) . '()</em>', APP_DIR . DS . 'Controller' . DS . h($controller) . '.php'); ?>
</p>

<?php
$code = <<<PHP
<?php
class {$controller} extends AppController {

	public function {$action}() {

	}
}
PHP;
?>
<div class="code-dump"><?php highlight_string($code) ?></div>
<?php $this->end() ?>
