hello :-)
<div id="flashArea" class="flashArea" style="height:100%;"><p align="center">This content requires the Adobe Flash Player.<br /><a href="http://www.adobe.com/go/getflashplayer">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /><br />
    <a href=http://www.macromedia.com/go/getflash/>Get Flash</a></p>
	</div></td>
  </tr>

  <script type="text/javascript">
	var mainswf = new SWFObject("<?php echo $url ?>/take_picture.swf", "main", "700", "400", "9", "#ffffff");
	mainswf.addParam("scale", "noscale");
	mainswf.addParam("wmode", "window");
	mainswf.addParam("allowFullScreen", "true");
	//mainswf.addVariable("requireLogin", "false");
	mainswf.write("flashArea");
	
  </script>