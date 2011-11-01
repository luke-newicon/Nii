<div class="page-header">
	<h2>Permissions</h2>
	<div class="action-buttons">
		<a class="btn primary" data-controls-modal="modal-add-role" data-backdrop="static" >Add a Role</a>
	</div>
</div>
<?php
	$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
		'id' => 'permissions-tabs',
		'items' => $permissions['items'],
//		'heading' => 'Application Settings',
		'htmlOptions' => array('class' => 'tabs vertical'),
	));
?>
<div class="tab-content vertical">
	<?php foreach($permissions['pages'] as $page) : ?>
	<div<?php echo CHtml::renderAttributes($page['htmlOptions']) ?>>
		Loading...
	</div>
	<?php endforeach ?>
</div>
<script>
	jQuery(function($){
		var loadPage = function($page){
			$page.load($page.attr('data-ajax-url'));
		}
		
		$('#permissions-tabs a').click(function(){
			loadPage($($(this).attr('href')));
		});
		
		$('#permissions-tabs').tabs();
		
		loadPage($('.tab-content .active'));
	});
</script>
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
						$.fn.yiiGridView.update('roles-grid');
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
	});
</script>