<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'settings-general-form',
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'focus' => array($model, 'appname'),
	'htmlOptions' => array('class' => 'float'),
));
?>
<div class="page-header">
	<h3>General Settings</h3>
	<div class="action-buttons">
		<input id="settings-general-save" type="submit" class="btn primary" value="Save" />
	</div>
</div>
<fieldset>
	<div class="field">
		<?php echo $form->labelEx($model, 'appname'); ?>
		<div class="inputContainer">
			<div class="input xlarge">
				<?php echo $form->textField($model, 'appname'); ?>
			</div>
			<?php echo $form->error($model, 'appname'); ?>
		</div>
	</div>
	<div class="actions">
		<input id="settings-general-save-2" type="submit" class="btn primary" value="Save" />
	</div>
</fieldset>
<?php $this->endWidget(); ?>
<script>
	jQuery(function($){
		
		$('#settings-general-save,#settings-general-save-2').click(function(){
			return false;
		})
		
		$('#settings-general-form').submit(function(){
			$.ajax({
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						alert(response.success);
					} else {
						alert(response.error);
					}
				},
				error: function() {
					alert("JSON failed to return a valid response");
				}
			});
			return false;
		});
	});
</script>