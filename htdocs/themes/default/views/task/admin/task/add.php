<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'add-task-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'focus' => array($model, 'name'),
));
?>
<fieldset>
	<?php if(!Yii::app()->request->isAjaxRequest) : ?>
		<div class="container pull-left">
	<?php endif; ?>
	<div class="field">
		<?php echo $form->labelEx($model, 'name'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->textField($model, 'name'); ?>
			</div>
			<?php echo $form->error($model, 'name'); ?>
		</div>
	</div>
	<div class="field">
		<?php echo $form->labelEx($model, 'description'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->textarea($model, 'description'); ?>
			</div>
			<?php echo $form->error($model, 'description'); ?>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo $form->labelEx($model, 'project_id'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->dropDownList($model, 'project_id', $model->projectList(), array('prompt' => 'Select a project')); ?>
				</div>
				<?php echo $form->error($model, 'project_id'); ?>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo $form->labelEx($model, 'customer_id'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->dropDownList($model, 'customer_id', $model->customerList(), array('prompt' => 'Select a customer')); ?>
				</div>
				<?php echo $form->error($model, 'customer_id'); ?>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo $form->labelEx($model, 'priority'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'priority'); ?>
				</div>
				<?php echo $form->error($model, 'priority'); ?>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo $form->labelEx($model, 'importance'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'importance'); ?>
				</div>
				<?php echo $form->error($model, 'importance'); ?>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo $form->labelEx($model, 'finish_date'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'finish_date'); ?>
				</div>
				<?php echo $form->error($model, 'finish_date'); ?>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo $form->labelEx($model, 'owner'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'owner'); ?>
				</div>
				<?php echo $form->error($model, 'owner'); ?>
			</div>
		</div>
	</div>
	<?php if(!Yii::app()->request->isAjaxRequest) : ?>
	</div>
	<div class="actions">
		<a href="<?php echo CHtml::normalizeUrl(array('viewTask','id'=>$model->id())) ?>" class="btn">Cancel</a>
		<input type="submit" class="btn primary" value="Save" />
	</div>
	<?php endif; ?>
</fieldset>
<?php $this->endWidget(); ?>