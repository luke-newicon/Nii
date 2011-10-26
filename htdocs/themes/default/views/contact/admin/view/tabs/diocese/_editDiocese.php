<h3><?php echo ucfirst($action) ?> Diocese Details</h3>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'dioceseForm',
		'enableAjaxValidation' => true,
	));
?>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'diocese_index'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w200">
			<?php echo $form->textField($model, 'diocese_index'); ?>
		</div>
		<?php echo $form->error($model,'diocese_index'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6 inputLabel"><?php echo $form->labelEx($model,'bishop_id'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w400">
			<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'name'=>'bishopName',
					'value'=>$model->bishopName,
					'source'=>$this->createUrl('autocomplete/contactList/type/Person/'),
					// additional javascript options for the autocomplete plugin
					'options'=>array(
							'showAnim'=>'fold',
					'select'=>'js:function(event, ui) {
							$("#Diocese_bishop_id").val(ui.item.id);
					}'
					),
				));
				echo $form->hiddenField($model, 'bishop_id');
			?>
		</div>
		<?php echo $form->error($model,'bishop_id'); ?>
	</div>
</div>
<div class="buttons submitButtons">
	<?php
	if ($action == 'create')
		echo CHtml::link($this->t('Cancel'), array("contact/view", "id" => $cid), array('class' => 'dioceseCancel cancelLink', 'id' => 'dioceseCancel'));
	else {
		echo THtml::trashButton($model, 'diocese', 'contact/'.$cid, 'Successfully deleted diocese details for '.$model->name);
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'dioceseCancelAjax cancelLink', 'id' => 'dioceseCancel'));
	}
	echo CHtml::link('<span class="icon fam-tick"></span>' . $this->t('Save'), '#', array('class' => 'dioceseSave btn btnN', 'id' => 'dioceseSave', 'style' => 'padding: 3px 5px;'));
	?>
</div>
<?php $this->endWidget(); ?>
<script>
	
	$(function(){

		pageUrl = '<?php echo Yii::app()->baseUrl ?>/contact/dioceseDetails/cid/<?php echo $cid; ?>';
		
		$('#dioceseForm').delegate('.dioceseSave','click',function(){
			$.ajax({
				url: pageUrl,
				data: jQuery("#dioceseForm").serialize(),
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
		
		$('#dioceseForm').delegate('.dioceseCancelAjax','click',function(){
			var selected = $( "#tabs" ).tabs( "option", "selected" ) +1;
			$("#ui-tabs-"+selected).load(pageUrl);
		});

	});

</script>