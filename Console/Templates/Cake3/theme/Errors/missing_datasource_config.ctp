<?php
$this->layout = 'dev_error';

$this->assign('title', __d('cake_dev', 'Missing Datasource Configuration'));

$this->start('subheading');
?>
<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
<?php echo __d('cake_dev', 'The datasource configuration %1$s was not found in database.php.', '<em>' . h($config) . '</em>'); ?>
<?php $this->end() ?>
