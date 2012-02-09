<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'edit-user-form',
));
?>
<?php if(!Yii::app()->request->isAjaxRequest) : ?>
	<?php $this->pageTitle = Yii::app()->name . ' - Edit User: ' . $model->name; ?>
	<div class="page-header">
		<h1>Edit User: <?php echo $model->name ?></h1>
		<div class="action-buttons">
			<?php if(Yii::app()->user->record->superuser) : ?>
				<a href="<?php echo CHtml::normalizeUrl(array('impersonate','id'=>$model->id())) ?>" class="btn info">Impersonate</a>
			<?php endif; ?>
			<a href="<?php echo CHtml::normalizeUrl(array('deleteUser','id'=>$model->id())) ?>" class="btn danger" data-confirm="Are you sure you want to delete <?php echo $model->name; ?>?">Delete <?php echo $model->name; ?></a>
		</div>
	</div>

<?php endif; ?>
<fieldset>
	<?php if(!Yii::app()->request->isAjaxRequest) : ?>
		<div class="container pull-left">
	<?php endif; ?>
	<div class="line">
		<div class="unit size1of2">
			<?php echo $form->field($model, 'first_name'); ?>
		</div>
		<div class="lastUnit">
			<?php echo $form->field($model, 'last_name'); ?>
		</div>
	</div>
	<div class="line">
		<div class="unit size1of2">
			<?php echo $form->field($model, 'email'); ?>
		</div>
		<div class="lastUnit">
			<?php echo $form->field($model, 'username'); ?>
		</div>
	</div>
	<div class="line">
		<div class="unit size1of2">
			<?php echo $form->field($model, 'superuser', 'dropDownList', User::itemAlias('AdminStatus')); ?>
		</div>
		<div class="lastUnit">
			<?php echo $form->field($model, 'status', 'dropDownList', User::itemAlias('UserStatus')); ?>
		</div>
	</div>
	<div class="line">
		<div class="unit size1of2">
			<div class="field">
				<?php echo $form->labelEx($model,'contact_id') ?>
				<div class="input">
					<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>'contactName',
						'value'=>$model->contactName,
						'source'=>$this->createUrl('/contact/autocomplete/contactList/type/Person/'),
						// additional javascript options for the autocomplete plugin
						'options'=>array(
							'showAnim'=>'fold',
							'change'=>'js:function(event, ui) {
								if (ui.item)
									$("#UserEditForm_contact_id").val(ui.item.id);
								else
									$("#UserEditForm_contact_id").val(null);
							}'
							),
						));
						echo $form->hiddenField($model, 'contact_id');
					?>
				</div>
				<?php echo $form->error($model,'contact_id'); ?>
			</div>
		</div>
		<div class="lastUnit">
			<?php echo $form->field($model, 'roleName', 'dropDownList', CHtml::listData(Yii::app()->authManager->roles,'name','description')); ?>
		</div>
	</div>
	<div class="line">
		<a href="#" class="btn" data-controls-modal="modal-user-edit-password" data-backdrop="static">Change Password</a>
		<label>
			<?php echo $form->checkBox($model, 'update_password'); ?>
			<?php echo $form->label($model, 'update_password'); ?>
		</label>
	</div>
	<?php if(!Yii::app()->request->isAjaxRequest) : ?>
	</div>
		<div class="actions">
			<a href="<?php echo CHtml::normalizeUrl(array('users')) ?>" class="btn">Cancel</a>
			<input type="submit" class="btn primary" value="Save" />
		</div>
	<?php endif; ?>
</fieldset>
<?php $this->endWidget(); ?>
<div class="modal hide fade" id="modal-user-edit-password">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>Change Password</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="user-edit-password-save" class="btn primary" href="#">Update Password</a>
	</div>
</div>
<script>
	jQuery(function($){		
		$('#modal-user-edit-password').bind('show', function() {
			$('#modal-user-edit-password .modal-body').load('<?php echo CHtml::normalizeUrl(array('/user/admin/updatepassword','id'=>$model->id())) ?>');
		});
		
		$('#user-edit-password-save').click(function(){
			$('#user-password-form').submit();
			return false;
		});
		
		$('#modal-user-edit-password').delegate('#user-password-form','submit',function(){
			$.ajax({
				url: "<?php echo CHtml::normalizeUrl(array('/user/admin/updatepassword','id'=>$model->id())) ?>",
				data: jQuery('#user-password-form').serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						$('#modal-user-edit-password').modal('hide');
						nii.showMessage(response.success);
					} else {
						nii.showMessage(response.error,{'className':'error'});
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