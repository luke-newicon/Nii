<h3><?php echo ucfirst($action) ?> Student Details</h3>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'studentForm',
		'enableAjaxValidation' => false,
		'enableClientValidation' => true,
	));
?>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'id'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo $s->id ?>
		</div>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'UOB_idcode'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w200">
			<?php echo $form->textField($s, 'UOB_idcode', array('size' => '40')); ?>
		</div>
		<?php echo $form->error($s, 'UOB_idcode'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'international'); ?></div>
	<div class="unit">
		<div class="inputBox w50">
			<?php echo $form->dropDownList($s, 'international', array('1' => 'Yes', '0' => 'No'), array('prompt' => '...')); ?>
		</div>
		<?php echo $form->error($s, 'international'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'nationality'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w250">
			<?php echo $form->textField($s, 'nationality', array('size' => '40')); ?>
		</div>
		<?php echo $form->error($s, 'nationality'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'learning_support'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w50">
			<?php echo $form->dropDownList($s, 'learning_support', array('Y' => 'Yes', 'N' => 'No'), array('prompt' => '...')); ?>
		</div>
		<?php echo $form->error($s, 'learning_support'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'learning_support_detail') ?></div>
	<div class="lastUnit">
		<div class="inputBox">
			<?php echo $form->textArea($s, 'learning_support_detail', array('data-tip' => '{gravity:\'e\', trigger: \'focus\'}', 'title' => 'Notes about learning support', 'rows' => '4')); ?>
		</div>
		<?php echo $form->error($s, 'learning_support_detail'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'academicquals'); ?></div>
	<div class="lastUnit">
		<div class="inputBox">
			<?php echo $form->textArea($s, 'academicquals', array('style' => 'width: 100%;', 'rows' => '4')); ?>
		</div>
		<?php echo $form->error($s, 'academicquals'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'otherquals'); ?></div>
	<div class="lastUnit">
		<div class="inputBox">
			<?php echo $form->textArea($s, 'otherquals', array('style' => 'width: 100%;', 'rows' => '4')); ?>
		</div>
		<?php echo $form->error($s, 'otherquals'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'wrkexperience'); ?></div>
	<div class="lastUnit">
		<div class="inputBox">
			<?php echo $form->textArea($s, 'wrkexperience', array('style' => 'width: 100%;', 'rows' => '4')); ?>
		</div>
		<?php echo $form->error($s, 'wrkexperience'); ?>
	</div>
</div>
<div class="line topLine field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'marital'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w90">
			<?php echo $form->dropDownList($s, 'marital', NHtml::enumItem($s, 'marital'), array('class' => 'inputInline', 'prompt' => 'select...')); ?>
		</div>
		<?php echo $form->error($s, 'marital'); ?>
	</div>
</div>
<div class="line">
	<div class="unit size1of5">
		<?php echo $this->t('Spouse'); ?>
	</div>
	<div class="lastUnit">
		<div class="unit size1of2">
			<div class="field">
				<div class="unit size2of5 inputLabel"><?php echo $form->labelEx($s, 'spousefirst'); ?></div>
				<div class="unit">
					<div class="inputBox w150">
						<?php echo $form->textField($s, 'spousefirst', array('class' => 'inputInline', 'size' => '16')); ?>
					</div>
					<?php echo $form->error($s, 'spousefirst'); ?>
				</div>
			</div>	
		</div>
		<div class="lastUnit">
			<div class="field">
				<div class="unit size2of5 inputLabel"><?php echo $form->labelEx($s, 'spouselast'); ?></div>
				<div class="unit">
					<div class="inputBox w150">
						<?php echo $form->textField($s, 'spouselast', array('class' => 'inputInline', 'size' => '16')); ?>
					</div>
					<?php echo $form->error($s, 'spouselast'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="line field">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($s, 'childrennote'); ?></div>
	<div class="lastUnit">
		<div class="inputBox">
			<?php echo $form->textArea($s, 'childrennote', array('style' => 'width: 100%;', 'rows' => '3')); ?>
		</div>
		<?php echo $form->error($s, 'childrennote'); ?>
	</div>
</div>
<div class="line topLine">
	<div class="unit size1of2">
		<div class="unit size2of5 inputLabel"><?php echo $form->labelEx($s, 'passport_expiry'); ?></div>
		<div class="lastUnit">
			<?php $this->widget('nii.widgets.forms.DateInput', array('model' => $s, 'attribute' => 'passport_expiry')) ?>
			<?php echo $form->error($s, 'passport_expiry'); ?>
		</div>
	</div>
	<div class="lastUnit">
		<div class="unit size2of5 inputLabel"><?php echo $form->labelEx($s, 'visa_expiry'); ?></div>
		<div class="lastUnit">
			<?php $this->widget('nii.widgets.forms.DateInput', array('model' => $s, 'attribute' => 'visa_expiry')) ?>
			<?php echo $form->error($s, 'visa_expiry'); ?>
		</div>
	</div>
</div>
<div class="buttons submitButtons">
	<?php
	if ($action == 'create')
		echo CHtml::link($this->t('Cancel'), array("contact/view", "id" => $cid), array('class' => 'studentCancel cancelLink', 'id' => 'studentCancel'));
	else {
		echo THtml::trashButton($s, 'student', 'contact/'.$cid, 'Successfully deleted student details for '.$s->name);
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'studentCancelAjax cancelLink', 'id' => 'studentCancel'));
	}
	echo NHtml::btnLink($this->t('Save'), '#', 'icon fam-tick', array('class' => 'btn btnN studentSave', 'id' => 'studentSave', 'style' => 'padding: 3px 5px;'));
	?>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->tabAjaxFunctions('Contact','student',$cid,$action); ?>