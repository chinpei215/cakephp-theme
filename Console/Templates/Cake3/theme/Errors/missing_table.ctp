<?php
$this->layout = 'dev_error';

$this->assign('title', __d('cake_dev', 'Missing Database Table'));
?>
<?php $this->start('subheading') ?>
<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
<?php echo __d('cake_dev', 'Table %1$s for model %2$s was not found in datasource %3$s.', '<em>' . h($table) . '</em>', '<em>' . h($class) . '</em>', '<em>' . h($ds) . '</em>'); ?>
<?php $this->end() ?>
