<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('action' => 'add')); ?></li>
<?php
		$done = array();
		foreach ($associations as $_type => $_data) {
			foreach ($_data as $_alias => $_details) {
				if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
					echo '<li>';
					echo $this->Html->link(
						__d('cake', 'List %s', Inflector::humanize($_details['controller'])),
						array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'index')
					);
					echo '</li>';

					echo '<li>';
					echo $this->Html->link(
						__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))),
						array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'add')
					);
					echo '</li>';
					$done[] = $_details['controller'];
				}
			}
		}
?>
	</ul>
</nav>

<div class="<?php echo $pluralVar; ?> index large-9 medium-8 columns content">
<h3><?php echo $pluralHumanName; ?></h3>
<table cellpadding="0" cellspacing="0">
<tr>
<?php foreach ($scaffoldFields as $_field): ?>
	<th scope="col"><?php echo $this->Paginator->sort($_field); ?></th>
<?php endforeach; ?>
	<th scope="col"><?php echo __d('cake', 'Actions'); ?></th>
</tr>
<?php
foreach (${$pluralVar} as ${$singularVar}):
	echo '<tr>';
		foreach ($scaffoldFields as $_field):
			$isKey = false;
			if (!empty($associations['belongsTo'])):
				foreach ($associations['belongsTo'] as $_alias => $_details):
					if ($_field === $_details['foreignKey']):
						$isKey = true;
						echo '<td>' . $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . '</td>';
						break;
					endif;
				endforeach;
			endif;
			if ($isKey !== true):
				echo '<td>' . h(${$singularVar}[$modelClass][$_field]) . '</td>';
			endif;
		endforeach;

		echo '<td class="actions">';
		echo $this->Html->link(__d('cake', 'View'), array('action' => 'view', ${$singularVar}[$modelClass][$primaryKey]));
		echo ' ' . $this->Html->link(__d('cake', 'Edit'), array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]));
		echo ' ' . $this->Form->postLink(
			__d('cake', 'Delete'),
			array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]),
			array(),
			__d('cake', 'Are you sure you want to delete # %s?', ${$singularVar}[$modelClass][$primaryKey])
		);
		echo '</td>';
	echo '</tr>';

endforeach;

?>
</table>

<div class="paginator">
	<ul class="pagination">
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __d('cake', 'previous'), array('tag' => 'li'), null, array('class' => 'prev disabled', 'disabledTag' => 'a'));
		echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a'));
		echo $this->Paginator->next(__d('cake', 'next') . ' >', array('tag' => 'li'), null, array('class' => 'next disabled', 'disabledTag' => 'a'));
	?>
	</div>
	<p><?php echo $this->Paginator->counter(array('format' => __d('cake', '{:page} of {:pages}'))); ?></p>
</div>
