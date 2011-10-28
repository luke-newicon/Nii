<div id="gridSettingsDialog"></div>
<div id="exportGridDialog"></div>
<div id="customScopeDialog"></div>

<div class="modal hide fade" id="modal-user-account">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>Account</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="user-account-save" class="btn primary" href="#">Save</a>
	</div>
</div>
<script>
	jQuery(function($){
		$('#modal-user-account').bind('show', function() {
			$('#modal-user-account .modal-body').load('<?php echo CHtml::normalizeUrl(array('/user/admin/account')) ?>');
		});
		
		$('#user-account-save').click(function(){
			$('#user-account-form').submit();
			return false;
		});
				
		$('#user-account-form').live("submit",function(){
			$.ajax({
				url: "<?php echo CHtml::normalizeUrl(array('/user/admin/account')) ?>",
				data: jQuery('#user-account-form').serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
//						$.fn.yiiGridView.update('user-grid');
						$('#modal-user-account').modal('hide');
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