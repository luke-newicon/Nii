<h3>Computer User Details</h3>
<p class="notice-msg">No computer user exists for this student.<br />To add one, please fill in the form below:</p>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'computeruserForm',
		'enableAjaxValidation' => true,
	));
?>

<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->label($model, 'sn'); ?></div>
	<div class="unit">
		<div class="w50">
			<?php 
			if (!$model->sn) $model->sn = $student_id;
			echo $model->sn;
			echo $form->hiddenField($model, 'sn'); ?>
		</div>
		<?php echo $form->error($model, 'sn'); ?>
	</div>
</div>

<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model, 'cn'); ?></div>
	<div class="unit">
		<div class="inputBox w250">
			<?php 
			if (!$model->cn) $model->cn = $contact->givennames . ' ' . $contact->lastname;
			echo $form->textField($model, 'cn'); ?>
		</div>
		<?php echo $form->error($model, 'cn'); ?>
	</div>
</div>

<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model, 'uid'); ?></div>
	<div class="unit">
		<div class="inputBox w90">
			<?php
			if (!$model->uid) $model->uid = $contact->computerUserId;
			echo $form->textField($model, 'uid'); ?>
		</div>
		<?php echo $form->error($model, 'uid'); ?>
	</div>
</div>

<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model, 'userpassword'); ?></div>
	<div class="unit">
		<div class="inputBox w150 inlineInput">
			<?php echo $form->textField($model, 'userpassword'); ?>
		</div>
		<?php echo NHtml::btnLink('Suggest Password', '#', null, array('onclick'=>'suggestPassword("ComputerUser_userpassword");return false')); ?>
		<?php echo $form->error($model, 'userpassword'); ?>
	</div>
</div>

<div class="buttons submitButtons">
	<?php
//	echo CHtml::link($this->t('Cancel'), '#', array('class' => 'computeruserCancelAjax cancelLink', 'id' => 'computeruserCancel'));
	echo NHtml::btnLink($this->t('Create'), '#', 'icon fam-tick', array('class' => 'btn btnN computeruserSave', 'id' => 'computeruserSave', 'style' => 'padding: 3px 5px;'));
	?>
</div>
<?php $this->endWidget(); ?>
<script>
	
	$(function(){

		pageUrl = '<?php echo Yii::app()->baseUrl ?>/contact/computerUserDetails/cid/<?php echo $cid; ?>';
		
		$.fn.nii.form();
		
		$('#computeruserForm').delegate('.computeruserSave','click',function(){
			$.ajax({
				url: pageUrl,
				data: jQuery("#computeruserForm").serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						var selected = $( "#tabs" ).tabs( "option", "selected" ) +1;
						$("#ui-tabs-"+selected).load(pageUrl);
						showMessage(response.success);
					}
				},
				error: function() {
					alert ("JSON failed to return a valid response");
				}
			}); 
		}); 

	});

</script>