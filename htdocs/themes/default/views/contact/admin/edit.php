<div class="page-header">
	<h1><?php echo $this->t('Edit Contact'); ?><?php echo ($c->id) ? ' - ' . $c->displayName : ''; ?></h1>
	<div class="action-buttons">
		<?php echo $c->id ? NHtml::trashButton($c, 'contact', '/contact/admin/', 'Successfully deleted ' . $c->name) : ''; ?>
	</div>
</div>
<?php
$this->renderPartial(
	'edit/_general', array(
		'c' => $c,
		'type' => $c->contact_type,
		'action' => array('admin/edit', 'id' => $c->id, 'type' => $c->contact_type),
		'event' => $event,
	)
);
?>