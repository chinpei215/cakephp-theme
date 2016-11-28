<?php
$this->layout = 'dev_error';

$this->assign('title', __d('cake_dev', 'Database Error'));
?>
<?php $this->start('subheading') ?>
<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
<?php echo $message; ?>
<?php $this->end() ?>

<?php $this->start('file') ?>
<?php if (!empty($error->queryString)) : ?>
	<p class="notice">
		<strong><?php echo __d('cake_dev', 'SQL Query'); ?>: </strong>
		<pre><?php echo h($error->queryString); ?></pre>
	</p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
		<strong><?php echo __d('cake_dev', 'SQL Query Params'); ?>: </strong>
		<pre><?php echo Debugger::dump($error->params); ?></pre>
<?php endif; ?>
<?php $this->end() ?>
