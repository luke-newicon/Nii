<h3><?php echo ucfirst($action) ?> Cleric Details</h3>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'clericForm',
		'enableAjaxValidation' => true,
	));
?>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'type'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w200">
			<?php echo $form->dropDownList($model,'type', NHtml::enumItem($model, 'type'),array('prompt'=>'select')); ?>
		</div>
	</div>
</div>
<div class="buttons submitButtons">
	<?php
	if ($action == 'create')
		echo CHtml::link($this->t('Cancel'), array("contact/view", "id" => $cid), array('class' => 'clericCancel cancelLink', 'id' => 'clericCancel'));
	else {
		echo THtml::trashButton($model, 'cleric', 'contact/'.$cid, 'Successfully deleted cleric details for '.$model->name);
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'clericCancelAjax cancelLink', 'id' => 'clericCancel'));
	}
	echo NHtml::btnLink($this->t('Save'), '#', 'icon fam-tick', array('class' => 'btn btnN clericSave', 'id' => 'clericSave', 'style' => 'padding: 3px 5px;'));
	?>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->tabAjaxFunctions('Contact','cleric',$cid,$action); ?>