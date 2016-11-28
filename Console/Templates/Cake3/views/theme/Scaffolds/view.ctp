<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?php echo __('Actions'); ?></li>
<?php
	echo "\t\t<li>";
	echo $this->Html->link(__d('cake', 'Edit %s', $singularHumanName), array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]));
	echo " </li>\n";

	echo "\t\t<li>";
	echo $this->Form->postLink(__d('cake', 'Delete %s', $singularHumanName), array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]), array(), __d('cake', 'Are you sure you want to delete # %s?', ${$singularVar}[$modelClass][$primaryKey]));
	echo " </li>\n";

	echo "\t\t<li>";
	echo $this->Html->link(__d('cake', 'List %s', $pluralHumanName), array('action' => 'index'));
	echo " </li>\n";

	echo "\t\t<li>";
	echo $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('action' => 'add'));
	echo " </li>\n";

	$done = array();
	foreach ($associations as $_type => $_data) {
		foreach ($_data as $_alias => $_details) {
			if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
				echo "\t\t<li>";
				echo $this->Html->link(
					__d('cake', 'List %s', Inflector::humanize($_details['controller'])),
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'index')
				);
				echo "</li>\n";
				echo "\t\t<li>";
				echo $this->Html->link(
					__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))),
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'add')
				);
				echo "</li>\n";
				$done[] = $_details['controller'];
			}
		}
	}
?>
	</ul>
</nav>

<div class="<?php echo $pluralVar; ?> view large-9 medium-8 columns content">
<h3><?php echo __d('cake', 'View %s', $singularHumanName); ?></h3>
	<table class="vertical-table">
<?php
foreach ($scaffoldFields as $_field) {
	$isKey = false;
	echo "\t<tr>\n";
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $_alias => $_details) {
			if ($_field === $_details['foreignKey']) {
				$isKey = true;
				echo "\t\t<th>" . Inflector::humanize($_alias) . "</th>\n";
				echo "\t\t<td>\n\t\t\t";
				echo $this->Html->link(
					${$singularVar}[$_alias][$_details['displayField']],
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])
				);
				echo "\n\t\t&nbsp;</td>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t<th>" . Inflector::humanize($_field) . "</th>\n";
		echo "\t\t<td>" . h(${$singularVar}[$modelClass][$_field]) . "&nbsp;</td>\n";
	}
	echo "\t</tr>\n";
}
?>
	</table>

<?php
if (!empty($associations['hasOne'])) :
foreach ($associations['hasOne'] as $_alias => $_details): ?>
<div class="related">
	<h4><?php echo __d('cake', "Related %s", Inflector::humanize($_details['controller'])); ?></h4>
<?php if (!empty(${$singularVar}[$_alias])): ?>
	<table class="vertical-table">
<?php
		$otherFields = array_keys(${$singularVar}[$_alias]);
		foreach ($otherFields as $_field):
			echo "\t<tr>\n";
			echo "\t\t<th>" . Inflector::humanize($_field) . "</th>\n";
			echo "\t\t<td>\n\t" . ${$singularVar}[$_alias][$_field] . "\n&nbsp;</td>\n";
			echo "\t</tr>\n";
		endforeach;
?>
	</table>
<?php endif; ?>
</div>
<?php
endforeach;
endif;

if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $_alias => $_details):
$otherSingularVar = Inflector::variable($_alias);
?>
<div class="related">
	<h4><?php echo __d('cake', "Related %s", Inflector::humanize($_details['controller'])); ?></h4>
<?php if (!empty(${$singularVar}[$_alias])): ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
<?php
		$otherFields = array_keys(${$singularVar}[$_alias][0]);
		if (isset($_details['with'])) {
			$index = array_search($_details['with'], $otherFields);
			unset($otherFields[$index]);
		}
		foreach ($otherFields as $_field) {
			echo "\t\t<th>" . Inflector::humanize($_field) . "</th>\n";
		}
?>
		<th class="actions">Actions</th>
	</tr>
<?php
		$i = 0;
		foreach (${$singularVar}[$_alias] as ${$otherSingularVar}):
			echo "\t\t<tr>\n";

			foreach ($otherFields as $_field) {
				echo "\t\t\t<td>" . ${$otherSingularVar}[$_field] . "</td>\n";
			}

			echo "\t\t\t<td class=\"actions\">\n";
			echo "\t\t\t\t";
			echo $this->Html->link(
				__d('cake', 'View'),
				array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'view', ${$otherSingularVar}[$_details['primaryKey']])
			);
			echo "\n";
			echo "\t\t\t\t";
			echo $this->Html->link(
				__d('cake', 'Edit'),
				array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'edit', ${$otherSingularVar}[$_details['primaryKey']])
			);
			echo "\n";
			echo "\t\t\t\t";
			echo $this->Form->postLink(
				__d('cake', 'Delete'),
				array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'delete', ${$otherSingularVar}[$_details['primaryKey']]),
				array(),
				__d('cake', 'Are you sure you want to delete # %s?', ${$otherSingularVar}[$_details['primaryKey']])
			);
			echo "\n";
			echo "\t\t\t</td>\n";
		echo "\t\t</tr>\n";
		endforeach;
?>
	</table>
<?php endif; ?>
</div>
<?php endforeach; ?>
</div>
