<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
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
	//1) join 'testChannel'

	
});
 
//4) Listen to the ready event to know when your client is connected
client.addEvent('ready', function() {
	
	 console.log('Your client is now connected');
	//1) join 'testChannel'
	client.core.join('sysmsg');

	//2) Intercept multiPipeCreate event
	client.addEvent('multiPipeCreate', function(pipe, options) {
	//3) Send the message on the pipe
	pipe.send('Hello world!');
		console.log('Sending Hello world');
	});

	//4) Intercept receipt of the new message.
	client.onRaw('data', function(raw, pipe) {
		console.log('Receiving : ' + unescape(raw.data.msg));
	});
});



</script>
wqefqwef 