<?php
$formAction = $action=='edit' ? array($action, 'id'=>$model->id) : array($action);
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'donationForm',
	'action' => $formAction,
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
));

$modelName = get_class($model);
?>
<div class="pull-left">
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'donation_amount') ?></div>
		<div class="lastUnit">
			<div class="input w170"><?php echo $form->textField($model, 'donation_amount', array('size' => 30, 'value' => NHtml::formatNumber($model->donation_amount, 2, false, false))); ?></div>
			<span class="help-block">Enter amount in &pound;, no commas</span>
			<?php echo $form->error($model,'donation_amount'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'date_received') ?></div>
		<div class="lastUnit">
			<div class="w170"><?php $this->widget('nii.widgets.forms.DateInput', array('model' => $model, 'attribute' => 'date_received')); ?></div>
			<?php echo $form->error($model,'date_received'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'contact_id') ?></div>
		<div class="lastUnit">
			<div class="input w200">
				<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'name'=>'contactName',
					'value'=>$model->contactName,
					'source'=>$this->createUrl('/hft/autocomplete/donationContactList/'),
					// additional javascript options for the autocomplete plugin
					'options'=>array(
							'showAnim'=>'fold',
					'change'=>'js:function(event, ui) {
						if (ui.item)
							$("#'.$modelName.'_contact_id").val(ui.item.id);
						else
							$("#'.$modelName.'_contact_id").val(null);
					}'
					),
				));
				echo $form->hiddenField($model, 'contact_id');
			?>
			<?php echo $form->error($model,'contact_id'); ?>
		</div>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'giftaid') ?></div>
		<div class="lastUnit">
			<div class="input w80"><?php echo $form->dropDownList($model,'giftaid',array('1'=>'Yes','0'=>'No'), array('prompt'=>'...')); ?></div>
			<?php echo $form->error($model,'giftaid'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'type_id') ?></div>
		<div class="lastUnit">
			<div class="input w170"><?php echo $form->dropDownList($model,'type_id', HftDonationType::getTypesArray(), array('prompt'=>'select...')); ?></div>
			<?php echo $form->error($model,'type_id'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'event_id') ?></div>
		<div class="lastUnit">
			<div class="input w200">
				<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'name'=>'eventName',
					'value'=>$model->eventName,
					'source'=>$this->createUrl('/hft/autocomplete/eventList/type/Person/'),
					// additional javascript options for the autocomplete plugin
					'options'=>array(
							'showAnim'=>'fold',
					'change'=>'js:function(event, ui) {
						if (ui.item)
							$("#'.$modelName.'_event_id").val(ui.item.id);
						else
							$("#'.$modelName.'_event_id").val(null);
					}'
					),
				));
				echo $form->hiddenField($model, 'event_id');
			?>
			<?php echo $form->error($model,'event_id'); ?>
		</div>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'thankyou_sent') ?></div>
		<div class="lastUnit">
			<div><?php echo $form->checkBox($model,'thankyou_sent'); ?></div>
			<?php echo $form->error($model,'thankyou_sent'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'comment') ?></div>
		<div class="lastUnit">
			<div class="input w400"><?php echo $form->textArea($model, 'comment',array('rows'=>4)); ?></div>
			<?php echo $form->error($model,'comment'); ?>
		</div>
	</div>	
	<?php /*
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'statement_number') ?></div>
		<div class="lastUnit">
			<div class="input w120"><?php echo $form->textField($model, 'statement_number', array('size' => 30)); ?></div>
			<?php echo $form->error($model,'statement_number'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'statement_date') ?></div>
		<div class="lastUnit">
			<div class="w170"><?php $this->widget('nii.widgets.forms.DateInput', array('model' => $model, 'attribute' => 'statement_date')); ?></div>
			<?php echo $form->error($model,'statement_date'); ?>
		</div>
	</div>
	*/ ?>
	<div class="actions">
		<?php
		$cancelUrl = ($model->id) ? array('donation/view','id'=>$model->id) : array('donation/index');
		echo NHtml::submitButton('Save', array('class'=>'btn primary')) . '&nbsp;';
		echo NHtml::btnLink('Cancel', $cancelUrl, null, array('class'=>'btn cancel cancelButton')) . '&nbsp;';
//		if ($model->id)
//			echo NHtml::trashButton($model, 'donation', 'donation/index', 'Successfully deleted donation');

		?>		
	</div>
</div>

<?php $this->endWidget();