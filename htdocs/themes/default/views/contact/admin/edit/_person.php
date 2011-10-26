<div class="line">
	<div class="unit size1of6"><?= $form->labelEx($c, 'name') ?></div>
	<div class="lastUnit">
		<div class="field nopad inputInline">
			<div class="inputBox w150">
				<?= $form->labelEx($c, 'lastname', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($c, 'lastname', array('class' => 'inputInline', 'data-tip' => '{gravity:\'s\', trigger:\'hover\', fade:true}', 'title'=>'Last name')); ?>
			</div>
		</div>
		<div class="field nopad inputInline">
			<div class="inputBox w150">
				<?= $form->labelEx($c, 'salutation', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($c, 'salutation', array('class' => 'inputInline', 'data-tip' => '{gravity:\'s\', trigger:\'hover\', fade:true}', 'title'=>'Salutation')); ?>
			</div>
		</div>
		<div class="field nopad inputInline">
			<div class="inputBox  w100">
				<?php echo $form->dropDownList($c, 'title', NHtml::enumItem($c, 'title'), array('class' => 'inputInline', 'prompt' => 'Title...')); ?>
			</div>
		</div>
		<?php echo $form->error($c, 'title'); ?>
		<?php echo $form->error($c, 'salutation'); ?>
		<?php echo $form->error($c, 'lastname'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6"><?= $form->labelEx($c, 'givennames') ?></div>
	<div class="lastUnit">
		<div class="inputBox w200">
				<?php echo $form->textField($c, 'givennames', array('class' => 'inputInline')); ?>
		</div>
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
		<div class="inputBox w80">
			<?php echo $form->dropDownList($c, 'gender', array('M' => 'Male', 'F' => 'Female'), array('prompt' => 'select...')); ?>
		</div>
	</div>
</div>