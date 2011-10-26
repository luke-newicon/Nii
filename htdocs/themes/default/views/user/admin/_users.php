<h2>Users</h2>
<!--<a class="btn btnN" href="<?php echo NHtml::url('/user/admin/create'); ?>">Add User</a>-->
<a class="btn primary" data-controls-modal="modal-add-user" data-backdrop="static" >Add a User</a>
<?php $this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => 'user-grid',
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'columns' => array(
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username), array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
		),
		array(
			'name' => 'createtime',
			'value' => 'date("d.m.Y H:i:s",$data->createtime)',
		),
		array(
			'name' => 'lastvisit',
			'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
		),
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
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
<script>
	jQuery(function($){
		
		$('#modal-add-user').bind('show',function(){
			$(this).find('.modal-body').load("<?php echo CHtml::normalizeUrl(array('/user/admin/create')) ?>");
		});
		
		$('#add-user-save').click(function(){
			$('#add-user-form').submit();
			return false;
		});
				
		$('#add-user-form').live("submit",function(){
			$.ajax({
				url: "<?php echo CHtml::normalizeUrl(array('/user/admin/create')) ?>",
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
	});
</script>