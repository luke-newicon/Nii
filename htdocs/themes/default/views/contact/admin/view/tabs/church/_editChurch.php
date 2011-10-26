<h3><?php echo ucfirst($action) ?> Church Details</h3>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'churchForm',
		'enableAjaxValidation' => true,
	));

?>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'contact_officer'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w300">
			<?php echo $form->textField($model, 'contact_officer'); ?>
		</div>
		<?php echo $form->error($model,'contact_officer'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'vicar_pastor'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w300">
			<?php echo $form->textField($model, 'vicar_pastor'); ?>
		</div>
		<?php echo $form->error($model,'vicar_pastor'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'denomination'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w300">
			<?php echo $form->textField($model, 'denomination'); ?>
		</div>
		<?php echo $form->error($model,'denomination'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'diocese_id'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w200">
			<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'name'=>'dioceseName',
					'value'=>$model->dioceseName,
					'source'=>$this->createUrl('autocomplete/dioceseList/wildcard/right/'),
					// additional javascript options for the autocomplete plugin
					'options'=>array(
							'showAnim'=>'fold',
					'select'=>'js:function(event, ui) {
							$("#Church_diocese_id").val(ui.item.id);
					}'
					),
				));
				echo $form->hiddenField($model, 'diocese_id');
			?>
		</div>
		<?php echo $form->error($model,'diocese_id'); ?>
	</div>
</div>
<div class="buttons submitButtons">
	<?php
	if ($action == 'create')
		echo CHtml::link($this->t('Cancel'), array("contact/view", "id" => $cid), array('class' => 'churchCancel cancelLink', 'id' => 'churchCancel'));
	else {
		echo THtml::trashButton($model, 'church', 'contact/'.$cid, 'Successfully deleted church details for '.$model->name);
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'churchCancelAjax cancelLink', 'id' => 'churchCancel'));
	}
	echo CHtml::link('<span class="icon fam-tick"></span>' . $this->t('Save'), '#', array('class' => 'churchSave btn btnN', 'id' => 'churchSave', 'style' => 'padding: 3px 5px;'));
	?>
</div>
<?php $model->contact_id = $cid;
echo $form->hiddenField($model,'contact_id'); ?>
<?php $this->endWidget(); ?>
<?php echo $this->tabAjaxFunctions('Contact','church',$cid,$action); ?>