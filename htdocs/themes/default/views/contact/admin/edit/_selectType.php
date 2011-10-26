<?php 
$form=$this->beginWidget('NActiveForm', array(
	'id'=>'contactForm',
	'action'=>$action,
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true
	),
)); ?>
<div class="shadowBlockLarge paddedBlock">
	<h3>Please select a contact type</h3>
	<div class="line">
		<div class="unit size1of3">
			<div class="inputRow">
				<span class="inputLabel"><?=$this->t('Type')?></span>
				<span class="inputContainer">
					<?php echo $form->dropDownList($c,'contact_type',NHtml::enumItem($c, 'contact_type'),array('class'=>'inputInline', 'prompt' => 'select...')); ?>
				</span>
			</div>
		</div>
		<div class="lastUnit size2of3">
			<?php echo CHtml::link($this->t('Cancel'), array("contact/view","id"=>$c->id), array('class'=>'cancelLink'));?>
			<?php echo NHtml::btnLink($this->t('Continue'), '#', 'icon fam-arrow-right', array('class' => 'btn btnN contactContinue', 'id' => 'contactContinue', 'style' => 'padding: 3px 5px;')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>
<script>
$(function(){
	$('#contactForm').delegate('.contactContinue','click',function(){
		var url = '<?php echo Yii::app()->baseUrl ?>/contact/create/type/'+$('#Contact_contact_type').val();
		window.location = url;
		return;
	}); 
});
</script>