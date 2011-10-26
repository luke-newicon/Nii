<h3><?php echo ucfirst($action) ?> Academic Details</h3>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'academicForm',
		'enableAjaxValidation' => true,
	));
?>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model, 'examiner'); ?></div>
	<div class="unit">
		<div class="inputBox w50">
			<?php echo $form->dropDownList($model, 'examiner', array('Y' => 'Yes', 'N' => 'No'), array('prompt' => '...')); ?>
		</div>
		<?php echo $form->error($model, 'examiner'); ?>
	</div>
</div>

<div class="line">
	<div class="unit size1of2">
		<div class="field">
			<div class="unit size1of3 inputLabel"><?php echo $form->labelEx($model, 'internal'); ?></div>
			<div class="unit">
				<div class="inputBox w50">
					<?php echo $form->dropDownList($model, 'internal', array('Y' => 'Yes', 'N' => 'No'), array('prompt' => '...')); ?>
				</div>
				<?php echo $form->error($model, 'internal'); ?>
			</div>
		</div>	
	</div>
	<div class="unit size1of2">
		<div class="field">
			<div class="unit size1of3 inputLabel"><?php echo $form->labelEx($model, 'external'); ?></div>
			<div class="unit">
				<div class="inputBox w50">
					<?php echo $form->dropDownList($model, 'external', array('Y' => 'Yes', 'N' => 'No'), array('prompt' => '...')); ?>
				</div>
				<?php echo $form->error($model, 'external'); ?>
			</div>
		</div>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'unavailable'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w200">
			<?php echo $form->textField($model, 'unavailable'); ?>
		</div>
		<?php echo $form->error($model,'unavailable'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'institution'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w400">
			<?php echo $form->textField($model, 'institution'); ?>
		</div>
		<?php echo $form->error($model,'institution'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'department'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w400">
			<?php echo $form->textField($model, 'department'); ?>
		</div>
		<?php echo $form->error($model,'department'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'position'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w400">
			<?php echo $form->textField($model, 'position'); ?>
		</div>
		<?php echo $form->error($model,'position'); ?>
	</div>
</div>
<div class="buttons submitButtons">
	<?php
	if ($action == 'create')
		echo CHtml::link($this->t('Cancel'), array("contact/view", "id" => $cid), array('class' => 'academicCancel cancelLink', 'id' => 'academicCancel'));
	else {
		echo THtml::trashButton($model, 'academic', 'contact/'.$cid, 'Successfully deleted academic details for '.$model->name);
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'academicCancelAjax cancelLink', 'id' => 'academicCancel'));
	}
	echo NHtml::btnLink($this->t('Save'), '#', 'icon fam-tick', array('class' => 'btn btnN academicSave', 'id' => 'academicSave', 'style' => 'padding: 3px 5px;'));
	?>
</div>
<?php $this->endWidget(); ?>
<script>
	
	$(function(){

		pageUrl = '<?php echo Yii::app()->baseUrl ?>/contact/academicDetails/cid/<?php echo $cid; ?>';
		
		$.fn.nii.form();
		
		$('#academicForm').delegate('.academicSave','click',function(){
			$.ajax({
				url: pageUrl,
				data: jQuery("#academicForm").serialize(),
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
		
		$('#academicForm').delegate('.academicCancelAjax','click',function(){
			var selected = $( "#tabs" ).tabs( "option", "selected" ) +1;
			$("#ui-tabs-"+selected).load(pageUrl);
		});

	});

</script>