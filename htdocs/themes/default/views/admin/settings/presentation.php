<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'presentation-setting-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'htmlOptions' => array('class' => 'float'),
));
?>
<div class="page-header">
	<h3>Presentation Settings</h3>
	<div class="action-buttons"></div>
</div>
<fieldset>
	<div class="field">
		<?php echo $form->labelEx($model, 'logo'); ?>
		<div class="inputContainer">
			<div class="input large">
				<?php echo $form->textField($model, 'logo'); ?>
			</div>
			<?php echo $form->error($model, 'logo'); ?>
		</div>
	</div>
	<div class="field">
		<?php echo $form->checkBox($model, 'fixedHeader'); ?>
		<label>Fixed header</label>
		<?php echo $form->error($model, 'fixedHeader'); ?>
	</div>
</fieldset>
<fieldset>
	<legend>Menu Settings</legend>
	<div class="field">
		<?php echo $form->checkBox($model, 'menuAppname'); ?>
		<label>Show application name in menu bar.</label>
		<?php echo $form->error($model, 'menuAppname'); ?>
	</div>
	<div class="field">
		<?php echo $form->checkBox($model, 'menuSearch'); ?>
		<label>Show search box in menu bar.</label>
		<?php echo $form->error($model, 'menuSearch'); ?>
	</div>
	<div class="field line">
		<?php echo $form->labelEx($model, 'topbarColor'); ?>
		<div>
			<div>
				<?php
				$form->widget('nii.widgets.forms.JColorPicker', array(
                    'name'=>get_class($model).'[topbarColor]',
                    'mode'=>'selector',
					'selector'=>'topbarColorSelector',
                    'fade' => true,
                    'slide' => false,
                    'curtain' => false,
					'value' => $model->topbarColor,
					'model' => $model,
                   )
				); ?>
				<?php // echo $form->textField($model, 'topbarColor'); ?>
			</div>
			<?php echo $form->error($model, 'topbarColor'); ?>
		</div>
	</div>
	<div class="field line">
		<?php echo $form->labelEx($model, 'h2Color'); ?>
		<div>
			<div>
				<?php
				$form->widget('nii.widgets.forms.JColorPicker', array(
                    'name'=>get_class($model).'[h2Color]',
                    'mode'=>'selector',
					'selector'=>'h2ColorSelector',
                    'fade' => true,
                    'slide' => false,
                    'curtain' => false,
					'value' => $model->h2Color,
					'model' => $model,
                   )
				); ?>
			</div>
			<?php echo $form->error($model, 'h2Color'); ?>
		</div>
	</div>
		<div class="field line">
		<?php echo $form->labelEx($model, 'h3Color'); ?>
		<div>
			<div>
				<?php
				$form->widget('nii.widgets.forms.JColorPicker', array(
                    'name'=>get_class($model).'[h3Color]',
                    'mode'=>'selector',
					'selector'=>'h3ColorSelector',
                    'fade' => true,
                    'slide' => false,
                    'curtain' => false,
					'value' => $model->h3Color,
					'model' => $model,
                   )
				); ?>
			</div>
			<?php echo $form->error($model, 'h3Color'); ?>
		</div>
	</div>
	<div class="actions">
		<input id="settings-presentation-save-2" type="submit" class="btn primary" value="Save" />
	</div>
</fieldset>
<?php $this->endWidget(); ?>