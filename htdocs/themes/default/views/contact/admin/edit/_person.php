<div class="line">
	<div class="unit size1of6"><?= $form->labelEx($c, 'name') ?></div>
	<div class="lastUnit">
		<div class="field nopad inputInline">
			<div class="input  w100">
				<?php echo $form->dropDownList($c, 'title', NHtml::enumItem($c, 'title'), array('class' => 'inputInline', 'prompt' => 'Title...')); ?>
			</div>
		</div>
		<div class="field nopad inputInline">
			<div class="input w150">
				<?= $form->labelEx($c, 'givennames', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($c, 'givennames', array('class' => 'inputInline', 'data-tip' => '{gravity:\'s\', trigger:\'hover\', fade:true}', 'title'=>'First Name(s)')); ?>
			</div>
		</div>
		<div class="field nopad inputInline">
			<div class="input w150">
				<?= $form->labelEx($c, 'lastname', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($c, 'lastname', array('class' => 'inputInline', 'data-tip' => '{gravity:\'s\', trigger:\'hover\', fade:true}', 'title'=>'Last name')); ?>
			</div>
		</div>
		<?php echo $form->error($c, 'title'); ?>
		<?php echo $form->error($c, 'givennames'); ?>
		<?php echo $form->error($c, 'lastname'); ?>
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