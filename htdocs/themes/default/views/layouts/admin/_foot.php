<div id="gridSettingsDialog"></div>
<div id="exportGridDialog"></div>
<div id="customScopeDialog"></div>
<div class="modal hide fade" id="modal-user-account">
	<div class="modal-header">
		<a class="close" data-dismiss="modal" href="#">×</a>
		<h3>My Account</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="user-password" class="btn pull-left" data-toggle="modal" data-backdrop="static" href="#modal-user-password">Change Password</a>
		<a id="user-account-save" class="btn btn-primary" href="#">Save</a>
	</div>
</div>
<div class="modal hide fade" id="modal-user-password">
	<div class="modal-header">
		<a class="close" data-dismiss="modal" href="#">×</a>
		<h3>Change Password</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="user-account" class="btn pull-left" data-toggle="modal" data-backdrop="static" href="#modal-user-account">My Account</a>
		<a id="user-password-save" class="btn btn-primary" href="#">Update Password</a>
	</div>
</div>
<script>
	jQuery(function($){
		$('#modal-user-account').bind('show', function() {
			$('#modal-user-account .modal-body').load('<?php echo CHtml::normalizeUrl(array('/user/admin/account')) ?>');
		});
		
		$('#modal-user-password').bind('show', function() {
			$('#modal-user-password .modal-body').load('<?php echo CHtml::normalizeUrl(array('/user/admin/password')) ?>');
		});
		
		$('#user-password').click(function(){
			$('#modal-user-account').modal('hide');
		});
		
		$('#user-account').click(function(){
			$('#modal-user-password').modal('hide');
		});
		
		$('#user-account-save').click(function(){
			$('#user-account-form').submit();
			return false;
		});
		
		$('#user-password-save').click(function(){
			$('#user-password-form').submit();
			return false;
		});
		
		$('#modal-user-account').delegate('#user-account-form','submit',function(){
			$.ajax({
				url: "<?php echo CHtml::normalizeUrl(array('/user/admin/account')) ?>",
				data: jQuery('#user-account-form').serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
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
		
		$('#modal-user-password').delegate('#user-password-form','submit',function(){
			$.ajax({
				url: "<?php echo CHtml::normalizeUrl(array('/user/admin/password')) ?>",
				data: jQuery('#user-password-form').serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						$('#modal-user-account').modal('show');
						$('#modal-user-password').modal('hide');
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