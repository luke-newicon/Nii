<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<h1>Test Token Inputs!</h1>


<?php $this->widget('application.widgets.tokeninput.NTokenInput', array(
	'name'=>'tokeninput',
	'url'=>'http://shell.loopj.com/tokeninput/tvshows.php'
)); ?>

<h2 id="theme">Facebook Theme</h2>
<div>
	<input type="text" id="demo-input-facebook-theme" name="blah2" />
	<input type="button" value="Submit" />

	<script type="text/javascript">
	$(document).ready(function() {
		$("#demo-input-facebook-theme").tokenInput("http://shell.loopj.com/tokeninput/tvshows.php", {
			theme: "facebook"
		});
	});
	</script>
</div>