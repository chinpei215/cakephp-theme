<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?php echo __('Actions'); ?></li>
<?php if ($this->request->action !== 'add'): ?>
		<li><?php echo $this->Form->postLink(
			__d('cake', 'Delete'),
			array('action' => 'delete', $this->Form->value($modelClass . '.' . $primaryKey)),
			array(),
			__d('cake', 'Are you sure you want to delete # %s?', $this->Form->value($modelClass . '.' . $primaryKey)));
		?></li>
<?php endif; ?>
		<li><?php echo $this->Html->link(__d('cake', 'List') . ' ' . $pluralHumanName, array('action' => 'index')); ?></li>
<?php
		$done = array();
		foreach ($associations as $_type => $_data):
			foreach ($_data as $_alias => $_details):
				if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)):
					echo "\t\t<li>" . $this->Html->link(
						__d('cake', 'List %s', Inflector::humanize($_details['controller'])),
						array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'index')
					) . "</li>\n";
					echo "\t\t<li>" . $this->Html->link(
						__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))),
						array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'add')
					) . "</li>\n";
					$done[] = $_details['controller'];
				endif;
			endforeach;
		endforeach;
?>
	</ul>
</nav>

<div class="<?php echo $pluralVar; ?> form large-9 medium-8 columns content">
<?php
	echo $this->Form->create();
	echo $this->Form->inputs($scaffoldFields, array('created', 'modified', 'updated'));
	echo $this->Form->button(__d('cake', 'Submit'));
	echo $this->Form->end();
?>
</div>
