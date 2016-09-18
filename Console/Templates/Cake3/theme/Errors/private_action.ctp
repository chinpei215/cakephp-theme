<?php
$this->layout = 'dev_error';

$this->assign('title', __d('cake_dev', 'Private Method in %s', $controller));

$this->start('subheading');
?>
<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
<?php echo __d('cake_dev', '%s%s cannot be accessed directly.', '<em>' . h($controller) . '::</em>', '<em>' . h($action) . '()</em>'); ?>
<?php $this->end() ?>
