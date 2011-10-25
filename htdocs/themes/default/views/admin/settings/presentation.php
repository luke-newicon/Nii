<h2>Presentation Settings</h2>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'studentForm',
		'enableAjaxValidation' => false,
		'enableClientValidation' => true,
	));
?>

<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'logo'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w200">
			<?php echo $form->textField($model, 'logo', array('size' => '40')); ?>
		</div>
		<?php echo $form->error($model, 'logo'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'color'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w200">
			<?php echo $form->textField($model, 'color', array('size' => '40')); ?>
		</div>
		<?php echo $form->error($model, 'color'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'background'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w200">
			<?php echo $form->textField($model, 'background', array('size' => '40')); ?>
		</div>
		<?php echo $form->error($model, 'background'); ?>
	</div>
</div>

<div class="buttons submitButtons">
	<?php
		echo NHtml::link('Save', '#', array('class' => 'icon fam-tick btn btnN studentSave', 'id' => 'studentSave', 'style' => 'padding: 3px 5px;'));
	?>
</div>
<?php $this->endWidget(); ?>