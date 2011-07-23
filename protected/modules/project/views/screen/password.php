<style>
	body{background-color:#999;}
	html{background-color:#999;}
	#passform{
		width:500px;margin:0 auto;background:#fff;border:3px solid #ccc;padding:30px;box-shadow:0px 0px 5px #000;border-radius:5px;
	}
</style>

<div id="passform" style="">
	<form method="post" class="line">
		<h1>A project visualisation has been shared with you.</h1>
		<div class="field unit size4of5">
			<div class="inputBox">
				<input id="password" name="password" type="password" placeholder="Enter the password"/>
			</div>
		</div>
		<div class="field lastUnit">
			<input class="btn aristo primary" type="submit" value="Go" />
		</div>
	</form>
</div>


<script>
	$(function(){
		$('#passform').position({my:'center',at:'center',of:$(window),'offset':'0px -100px' });
	});
</script>