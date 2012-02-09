<legend>General</legend>
<?php echo $form->field($c, 'title', 'dropDownList', NHtml::enumItem($c, 'title'), array('class' => 'input-small', 'prompt' => 'Select')); ?>
<?php echo $form->field($c, 'givennames'); ?>
<?php echo $form->field($c, 'lastname'); ?>
<?php echo $form->field($c, 'suffix'); ?>
<div class="control-group">
	<?php echo $form->labelEx($c, 'dob') ?>
	<div class="controls">
		<?php $this->widget('nii.widgets.forms.DateInput', array('model' => $c, 'attribute' => 'dob')) ?>
		<?php echo $form->error($c,'dob'); ?>
	</div>
</div>
<?php echo $form->field($c, 'gender', 'dropDownList', array('M' => 'Male', 'F' => 'Female'), array('class' => 'input-small', 'prompt' => 'Select')); ?>