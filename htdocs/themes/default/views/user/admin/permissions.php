<?php //Yii::app()->bootstrap->registerScriptFile('bootstrap-tabs.js'); ?>
<div class="page-header">
	<h1>Permissions</h1>
	<div class="action-buttons">
		<a class="btn danger" href="<?php echo CHtml::normalizeUrl(array('/user/admin/flushPermissions')) ?>" data-confirm="Are you sure you want to reset all permissions?  This will also remove any user created roles.">Reset All Permissions</a>
		<a class="btn primary" data-controls-modal="modal-add-role" data-backdrop="true">Add a Role</a>
	</div>
</div>
<?php $this->widget('nii.widgets.NTabs', 
	array(
		'id' => 'PermissionTabs',
		'tabs' => $tabs,
//		'options' => array(
//			'cache' => true,
//		),
		'htmlOptions' => array(
			'class' => 'vertical',
		)
	)
); ?>
<div class="modal hide fade" id="modal-add-role">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>Add a Role</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="add-role-save" class="btn primary" href="#">Save</a>
	</div>
</div>
<div class="modal hide fade" id="modal-edit-role">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>Edit Role</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="edit-role-delete" class="btn danger pull-left" href="#">Delete this Role</a>
		<a id="edit-role-save" class="btn primary" href="#">Save</a>
	</div>
</div>
<script>
	jQuery(function($){
		
		$('#modal-add-role').bind('show',function(){
			$(this).find('.modal-body').load("<?php echo CHtml::normalizeUrl(array('/user/admin/addRole')) ?>");
		});
		
		$('#add-role-save').click(function(){
			$('#add-role-form').submit();
			return false;
		});
				
		$('#modal-add-role').delegate('#add-role-form','submit',function(){
			$.ajax({
				url: "<?php echo CHtml::normalizeUrl(array('/user/admin/addRole')) ?>",
				data: jQuery('#add-role-form').serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						$('.ui-tabs-panel:not(.ui-tabs-hide) .grid-view').each(function(){
							console.log($(this).attr('id'));
							$.fn.yiiGridView.update($(this).attr('id'));
						});
						$('#modal-add-role').modal('hide');
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
		
		$('#modal-edit-role').modal({backdrop:'static'});
		
	});
</script>