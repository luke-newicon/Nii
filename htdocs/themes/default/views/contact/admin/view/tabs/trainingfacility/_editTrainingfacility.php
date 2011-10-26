<h3><?php echo ucfirst($action) ?> Training Facility Details</h3>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'trainingfacilityForm',
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
		echo CHtml::link($this->t('Cancel'), array("contact/view", "id" => $cid), array('class' => 'trainingfacilityCancel cancelLink', 'id' => 'trainingfacilityCancel'));
	else {
		echo THtml::trashButton($model, 'training facility', 'contact/'.$cid, 'Successfully deleted training facility details for '.$model->name);
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'trainingfacilityCancelAjax cancelLink', 'id' => 'trainingfacilityCancel'));
	}
	echo CHtml::link('<span class="icon fam-tick"></span>' . $this->t('Save'), '#', array('class' => 'trainingfacilitySave btn btnN', 'id' => 'trainingfacilitySave', 'style' => 'padding: 3px 5px;'));
	?>
</div>
<?php $model->contact_id = $cid;
echo $form->hiddenField($model,'contact_id'); ?>
<?php $this->endWidget(); ?>
<?php echo $this->tabAjaxFunctions('Contact','trainingfacility',$cid,$action); ?>