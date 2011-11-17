<?php
$formAction = $action=='edit' ? array($action, 'id'=>$model->id) : array($action);
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'eventForm',
	'action' => $formAction,
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
));

$modelName = get_class($model);
?>
<div class="container pull-left">
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'name') ?></div>
		<div class="lastUnit">
			<div class="input w300"><?php echo $form->textField($model, 'name', array('size' => 30)); ?></div>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'start_date') ?></div>
		<div class="lastUnit">
			<div class="w170"><?php $this->widget('nii.widgets.forms.DateInput', array('model' => $model, 'attribute' => 'start_date')); ?></div>
			<?php echo $form->error($model,'start_date'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'end_date') ?></div>
		<div class="lastUnit">
			<div class="w170"><?php $this->widget('nii.widgets.forms.DateInput', array('model' => $model, 'attribute' => 'end_date')); ?></div>
			<?php echo $form->error($model,'end_date'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'organiser_type_id') ?></div>
		<div class="lastUnit">
			<div class="input w170"><?php echo $form->dropDownList($model,'organiser_type_id', HftEventOrganiserType::getTypesArray(), array('prompt'=>'select...')); ?></div>
			<?php echo $form->error($model,'organiser_type_id'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'organiser_name') ?></div>
		<div class="lastUnit">
			<div class="input w200"><?php echo $form->textField($model, 'organiser_name', array('size' => 30)); ?></div>
			<?php echo $form->error($model,'organiser_name'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'description') ?></div>
		<div class="lastUnit">
			<div class="input w400"><?php echo $form->textArea($model, 'description',array('rows'=>4)); ?></div>
			<?php echo $form->error($model,'description'); ?>
		</div>
	</div>	
	
	<div class="actions">
		<?php
		$cancelUrl = ($model->id) ? array('event/view','id'=>$model->id) : array('event/index');
		echo NHtml::submitButton('Save', array('class'=>'btn primary')) . '&nbsp;';
		echo NHtml::btnLink('Cancel', $cancelUrl, null, array('class'=>'btn cancel cancelButton')) . '&nbsp;';
		if ($model->id)
			echo NHtml::trashButton($model, 'event', 'event/index', 'Successfully deleted event');

		?>		
	</div>
	
</div>


<?php $this->endWidget();