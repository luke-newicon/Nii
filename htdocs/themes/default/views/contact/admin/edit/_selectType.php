<?php 
$form=$this->beginWidget('NActiveForm', array(
	'id'=>'contactForm',
	'action'=>$action,
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true
	),
)); ?>
<div class="line">
		<div class="inputRow field">
			<span class="inputLabel"><?=$this->t('Select a contact type:')?></span>
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