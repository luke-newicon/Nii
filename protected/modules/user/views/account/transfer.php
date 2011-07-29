<?php
/*
 * This view posts the login details to the correct subdomain
 */
?>
Please wait whilst we transfer you.
<form id="userloginform" method="post" action="<?php echo $action; ?>" onload="this.submit()" style="display:none;">
	<?php echo CHtml::hiddenField('UserLogin[username]',$userIdentity->username); ?>
	<?php echo CHtml::hiddenField('UserLogin[password]',$userIdentity->password); ?>
	<?php echo CHtml::hiddenField('UserLogin[rememberMe]',0); ?>
</form>
<script>
	document.getElementById('userloginform').submit();
</script>