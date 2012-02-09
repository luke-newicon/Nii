<?php $this->pageTitle = Yii::app()->name . ' - Edit User: ' . $model->name; ?>
<div class="page-header">
	<h1>Edit User: <?php echo $model->name ?></h1>
	<div class="action-buttons">
		<?php if(Yii::app()->user->record->superuser) : ?>
			<a href="<?php echo CHtml::normalizeUrl(array('impersonate','id'=>$model->id())) ?>" class="btn btn-info">Impersonate</a>
		<?php endif; ?>
		<a href="<?php echo CHtml::normalizeUrl(array('deleteUser','id'=>$model->id())) ?>" class="btn btn-danger" data-confirm="Are you sure you want to delete <?php echo $model->name; ?>?"><i class="icon-trash icon-white"></i> Delete <?php echo $model->name; ?></a>
	</div>
</div>
<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'edit-user-form',
));
?>
<fieldset>
	<?php echo $form->field($model, 'first_name'); ?>
	<?php echo $form->field($model, 'last_name'); ?>
	<?php echo $form->field($model, 'email'); ?>
	<?php echo $form->field($model, 'username'); ?>
	<?php echo $form->field($model, 'superuser', 'dropDownList', User::itemAlias('AdminStatus')); ?>
	<?php echo $form->field($model, 'status', 'dropDownList', User::itemAlias('UserStatus')); ?>
	<?php echo $form->beginField($model, 'contact_id'); ?>
		<?php echo $form->autoComplete($model, 'contact_id', $this->createUrl('/contact/autocomplete/contactList/type/Person/'), 'contactName'); ?>
	<?php echo $form->endField($model, 'contact_id'); ?>
	<?php echo $form->field($model, 'roleName', 'dropDownList', CHtml::listData(Yii::app()->authManager->roles,'name','description')); ?>
	<?php echo $form->beginField($model, 'password'); ?>
		<a href="#" class="btn" data-controls-modal="modal-user-edit-password" data-backdrop="static">Change Password</a>
		<?php //echo $form->checkBoxField($model, 'update_password'); ?>
	<?php echo $form->endField($model, 'update_password'); ?>
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="Save" />
		<a href="<?php echo CHtml::normalizeUrl(array('users')) ?>" class="btn">Cancel</a>
	</div>
</fieldset>
<?php $this->endWidget(); ?>
<div class="modal hide fade" id="modal-user-edit-password">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>Change Password</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="user-edit-password-save" class="btn btn-primary" href="#">Update Password</a>
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