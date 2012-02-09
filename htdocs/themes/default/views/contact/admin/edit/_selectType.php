<?php 
$form=$this->beginWidget('NActiveForm', array(
	'id'=>'contactForm',
	'action'=>$action,
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true
	),
)); ?>
<?php if($c->hasErrors()) : ?>
	<div class="alert-message block-message error">
		<?php echo $form->errorSummary($c); ?>
	</div>
<?php else : ?>
	<div class="alert-message block-message">
		<p>This is where you can create a new contact.  Fill in all the required fields marked with a <span class="required">*</span>.</p>
		<p>Additional information can be added at any other time.</p>
	</div>
<?php endif; ?>
<div class="line">
		<div class="inputRow field">
			<span class="inputLabel"><?php echo$this->t('Select a contact type:')?></span>
			<span class="inputContainer">
				<?php echo $form->dropDownList($c,'contact_type',NHtml::enumItem($c, 'contact_type'),array('class'=>'inputInline input', 'prompt' => 'select...')); ?>
			</span>
		</div>
</div>
<?php $this->endWidget(); ?>
<script>
$(function(){
	$('#contactForm').delegate('.contactContinue','click',function(){
		var url = '<?php echo Yii::app()->baseUrl ?>/contact/admin/create/type/'+$('#Contact_contact_type').val();
		window.location = url;
		return;
	}); 
	
});
</script>