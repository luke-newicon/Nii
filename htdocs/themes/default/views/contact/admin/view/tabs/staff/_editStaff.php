<h3><?php echo ucfirst($action) ?> Staff Details</h3>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'staffForm',
		'enableAjaxValidation' => true,
	));

if ($action == 'create') { ?>
<p class="message">Please click 'Save' to create this relationship.</p>
<?php } else { ?>
<p class="message">There is no further information associated with this relationship.</p>
<?php } ?>
<div class="buttons submitButtons">
	<?php
	if ($action == 'create')
		echo CHtml::link($this->t('Cancel'), array("contact/view", "id" => $cid), array('class' => 'staffCancel cancelLink', 'id' => 'staffCancel'));
	else {
		echo THtml::trashButton($model, 'staff member', 'contact/'.$cid, 'Successfully deleted staff member details for '.$model->name);
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'staffCancelAjax cancelLink', 'id' => 'staffCancel'));
	}
	echo CHtml::link('<span class="icon fam-tick"></span>' . $this->t('Save'), '#', array('class' => 'staffSave btn btnN', 'id' => 'staffSave', 'style' => 'padding: 3px 5px;'));
	?>
</div>
<?php $model->contact_id = $cid;
echo $form->hiddenField($model,'contact_id'); ?>
<?php $this->endWidget(); ?>
<?php echo $this->tabAjaxFunctions('Contact','staff',$cid,$action); ?>