<div class="line">
	<div class="unit size1of6"><?= $form->labelEx($c, 'name') ?></div>
	<div class="lastUnit">
		<div class="field nopad inputInline">
			<div class="input  w100">
				<?php //echo $form->dropDownList($c, 'title', NHtml::enumItem($c, 'title'), array('class' => 'inputInline', 'prompt' => 'Title...')); ?>
				<?php echo $form->labelEx($c, 'title', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($c, 'title', array('class' => 'inputInline', 'data-tip' => '{gravity:\'s\', trigger:\'hover\', fade:true}', 'title'=>'Title')); ?>
			</div>
		</div>
		<div class="field nopad inputInline">
			<div class="input w150">
				<?php echo $form->labelEx($c, 'givennames', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($c, 'givennames', array('class' => 'inputInline', 'data-tip' => '{gravity:\'s\', trigger:\'hover\', fade:true}', 'title'=>'First Name(s)')); ?>
			</div>
		</div>
		<div class="field nopad inputInline">
			<div class="input w150">
				<?php echo $form->labelEx($c, 'lastname', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($c, 'lastname', array('class' => 'inputInline', 'data-tip' => '{gravity:\'s\', trigger:\'hover\', fade:true}', 'title'=>'Last name')); ?>
			</div>
		</div>
		<div class="field nopad inputInline">
			<div class="input w100">
				<?php echo $form->labelEx($c, 'suffix', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($c, 'suffix', array('class' => 'inputInline', 'data-tip' => '{gravity:\'s\', trigger:\'hover\', fade:true}', 'title'=>'Suffix')); ?>
			</div>
		</div>
		<?php echo $form->error($c, 'title'); ?>
		<?php echo $form->error($c, 'givennames'); ?>
		<?php echo $form->error($c, 'lastname'); ?>
		<?php echo $form->error($c, 'suffix'); ?>
	</div>
</div>
<div class="line">
	<div class="unit size1of6"><?= $form->labelEx($c, 'dob') ?></div>
	<div class="lastUnit">
		<?php $this->widget('nii.widgets.forms.DateInput', array('model' => $c, 'attribute' => 'dob')) ?>
		<?php echo $form->error($c,'dob'); ?>
	</div>

</div>
<div class="line field">
	<div class="unit size1of6"><?= $form->labelEx($c, 'gender') ?></div>
	<div class="lastUnit">
		<div class="input w80">
			<?php echo $form->dropDownList($c, 'gender', array('M' => 'Male', 'F' => 'Female'), array('prompt' => 'select...')); ?>
		</div>
	</div>
</div>