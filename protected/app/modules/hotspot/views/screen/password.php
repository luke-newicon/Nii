<style>
	#passform{width:600px;margin:0 auto;background:#fff;border:3px solid #ccc;padding:30px;box-shadow:0px 0px 5px #000;border-radius:5px;}
</style>

<div id="passform" style="">
	<form method="post" class="line">
		<h1>Visuals have been shared with you for review.</h1>
		<div class="field unit size4of6 man mrs">
			<label class="inFieldLabel" for="password" style="font-size:22px;">Enter the Password</label>
			<div class="input">
				<input style="font-size:22px;" id="password" name="password" type="password" />
			</div>
		</div>
		<div class="field lastUnit">
			<input style="font-size:22px;width:100%;" class="btn aristo primary" type="submit" value="Go" />
		</div>
	</form>
</div>


<script>
	$(function(){
		$('#passform').position({my:'center',at:'center',of:$(window),'offset':'0px -100px' });
	});
</script>