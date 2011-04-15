<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script type="text/javascript" language="javascript" src="../../Clients/JavaScript.js"></script>
<script type="text/javascript" language="javascript" src="../config.js"></script>
<div id="wrapper">

		Change Background Color:
	<select name="selectColor">
		<option value="white" selected="selected">White</option>
		<option value="yellow">Yellow</option>
		<option value="blue">Blue</option>
		<option value="green">Green</option>
		<option value="pink">Pink</option>
		<option value="purple">Purple</option>
		<option value="black">Black</option>
	</select>
	<p>Simple APE test of where users can change the background color of the page. We also use jQuery</p>
</div>

<div id="debug">
	<h2>Debug</h2>
</div>

<script type="text/javaScript">
   //Instantiate APE Client
	var client = new APE.Client();

	//1) Load APE Core
	client.load();

	//2) Intercept 'load' event. This event is fired when the Core is loaded and ready to connect to APE Server
	client.addEvent('load', function() {
		//3) Call core start function to connect to APE Server, and prompt the user for a nickname
		client.core.start({"name": prompt('Your name?')});
	});

	//4) Listen to the ready event to know when your client is connected
	client.addEvent('ready', function() {
		console.log('Your client is now connected');
	});

	
</script>