<div class="page-header">
	<h2>Users</h2>
	<div class="action-buttons">
		<a class="btn primary" data-controls-modal="modal-add-user" data-backdrop="static">Add a User</a>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => 'user-grid',
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'columns' => array(
		array(
			'name' => 'name',
			'type' => 'raw',
			'value' => 'CHtml::link($data->name, Yii::app()->controller->createUrl("editUser",array("id"=>$data->primaryKey)))',
			'htmlOptions' => array('class' => 'edit-user'),
		),
		array(
			'name' => 'username',
			'type' => 'raw',
			'value' => 'CHtml::link($data->username, Yii::app()->controller->createUrl("editUser",array("id"=>$data->primaryKey)))',
			'htmlOptions' => array('class' => 'edit-user'),
		),
		array(
			'name' => 'email',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
		),
		array(
			'name' => 'roleName',
			'header' => 'Role',
			'filter' => CHtml::listData(Yii::app()->authManager->roles,'name','description'),
			'value' => '$data->roleDescription',
		),
		array(
			'name' => 'status',
			'filter' => User::itemAlias("UserStatus"),
			'value' => 'User::itemAlias("UserStatus",$data->status)',
		),
		array(
			'name' => 'lastvisit',
			'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
		),
	),
));
?>
<div class="modal hide fade" id="modal-add-user">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>Add a User</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="add-user-save" class="btn primary" href="#">Save</a>
	</div>
</div>
<div class="modal hide fade" id="modal-edit-user">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>Edit a User</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="edit-user-save" class="btn primary" href="#">Save</a>
	</div>
</div>
<script>
	jQuery(function($){
		
		$('#modal-add-user').bind('show',function(){
			$(this).find('.modal-body').load("<?php echo CHtml::normalizeUrl(array('/user/admin/addUser')) ?>");
		});
		
		$('#add-user-save').click(function(){
			$('#add-user-form').submit();
			return false;
		});
				
		$('#modal-add-user').delegate('#add-user-form','submit',function(){
			$.ajax({
				url: $(this).attr('action'),
				data: jQuery('#add-user-form').serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						$.fn.yiiGridView.update('user-grid');
						$('#modal-add-user').modal('hide');
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
		
		$('#modal-edit-user').modal({backdrop:'static'});
		
		$('#users').delegate('#user-grid .edit-user a','click',function(){
			$('#modal-edit-user').modal('show');
			$('#modal-edit-user .modal-body').load($(this).attr('href'));
			return false;
		});
		
		$('#edit-user-save').click(function(){
			$('#edit-user-form').submit();
			return false;
		});
				
		$('#modal-edit-user').delegate('#edit-user-form','submit',function(){
			$.ajax({
				url: $(this).attr('action'),
				data: jQuery('#edit-user-form').serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						$.fn.yiiGridView.update('user-grid');
						$('#modal-edit-user').modal('hide');
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