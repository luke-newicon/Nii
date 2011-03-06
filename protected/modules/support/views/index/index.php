<?php $msgPreviewHeight=75; ?>
<?php $msgPreviewNumber=30; ?>
<?php echo 'total messages ' . $total; ?>
<h1>Support</h1>
<style>
	.listItem{border-bottom:1px solid #ECECEC;padding:5px 10px;cursor:pointer;height:75px;}
	.listItem .subject{overflow:hidden;height:1.4em;}
	.listItem .body{overflow:hidden;height:32px;}
	.listItem .from{font-weight:bold;font-size:15px;height:1.4em;overflow:hidden;}
	.leftPanel{border-right:1px solid #ccc;width:300px;}
	.leftMainPanel{border-right:1px solid #ccc;background-color:#f9f9f9;}
	.flags{width:5%;}
	.time{font-weight:bold;color:#787878;}
	.sel, .sel .faded, .sel .time {background-color:#999;color:#fff;}
	.mod.toolbar {border-top:1px solid #ccc;}
	.mod.toolbar .inner {border-bottom:1px solid #bbb;border-top:1px solid #fff;background:-moz-linear-gradient(center top , #ebebeb, #d2d2d2) repeat scroll 0 0 transparent;}
	.mod.toolbar .inner .bd {height:30px;}
	.popSpinner{display:none;border:1px solid #333;-moz-border-radius:5px;width:150px;height:55px;opacity:0.8;color:#fff;background-color:#666;position:absolute;top:400px;left:230px;background:-moz-linear-gradient(center top , #999, #333) repeat scroll 0 0 transparent;}
	
	.scroll{overflow:auto;height:300px;}
	#messageList{background:url('http://localhost/newicon/projects/images/message-border.png') repeat top left;}
</style>
<script type="text/javascript" src="http://localhost/newicon/projects/jquery.layout.min-1.2.0.js"></script>
<div class="">Center</div>
<div class="popSpinner">
	<div class="line"><div class="unit size1of4 pam"><div class="spinner">&nbsp;</div></div><div class="lastUnit"><div class="h4 mln" style="color:#fff;padding-top:15px;">Loading...</div></div></div>
</div>
<div class="line" id="mClient">
	<div id="messageFoldersBox" class="unit size1of8 leftMainPanel">
		<?php $this->beginWidget('application.widgets.oocss.Mod', array('class'=>'mod toolbar man')); ?>
			<div class="bd pas">
				&nbsp;
			</div>
		<?php $this->endWidget(); ?>
		<div id="messageFolders">
			
		</div>
	</div>
	<div id="messageListBox" class="unit size1of5 leftPanel ui-layout-west">
		<?php $this->beginWidget('application.widgets.oocss.Mod', array('class'=>'mod toolbar man')); ?>
			<div class="bd pas">
				&nbsp;
			</div>
		<?php $this->endWidget(); ?>
		<div id="messageScroll" class="scroll">
			<?php //messageList will be as high as total number of messages  ?>
			<div id="messageList" style="height:<?php echo $total*$msgPreviewHeight; ?>px;">
				
			</div>
		</div>
	</div>
	<div id="emailBox" class="lastUnit ui-layout-center">
		<?php $this->beginWidget('application.widgets.oocss.Mod', array('class'=>'mod toolbar man')); ?>
			<div class="bd pas">
				<a href="#" class="btn btnN">Reply</a>
			</div>
		<?php $this->endWidget(); ?>
		<div id="email">

		</div>
	</div>
</div>


<script>
	$(function(){
		
		$('#messageFolders').load('<?php echo NHtml::url('/support/index/loadMessageFolders') ?>');
		$('#messageList').delegate('.listItem','click',function(){
			$(this).parent().find('.listItem').removeClass('sel');
			$(this).addClass('sel');
			var id = $(this).attr('id');
			$('#email').load('<?php echo NHtml::url('/support/index/message') ?>/id/'+id);
		});
		
		$('#messageList').load('<?php echo NHtml::url('/support/index/loadMessageList') ?>');
		var loadedPages = [];
		loadedPages[1] = 1;
		$('#messageScroll').scroll(function(){
			var msgHeight = <?php echo $msgPreviewHeight;?>;
			var msgNumber = <?php echo $msgPreviewNumber;?>;
			var allMsgsHeight = msgHeight*msgNumber;
			
			$lastMsg = $('#messageList').find('.listItem:last');
			if(!$lastMsg.length)
				return;
			var lastMsgPos = $lastMsg.position();
			
			// calculate the batch (page) to load based on the current scroll position
			var batchToLoad = Math.floor(($(this).scrollTop() / allMsgsHeight))

			if(batchToLoad in loadedPages){
				alert('LOAD BATCH: ' + batchToLoad);
			}
			// checks if there are visible messages in the scroll portion of the window
			if((lastMsgPos.top - $('#messageScroll').height()) < -30){
				// calculate which messages to load based on the scroll position.
				// allMsgsHeight: the height of one batch of loaded messages
				// divide the scroll pane up in batches and see which batch we have scrolled to. 
				// a batch of messages is equivelant to a page
				
				var loadMsgOffset = $(this).scrollTop() / allMsgsHeight;
				$('.popSpinner').show();
				
//				alert('load from message ' + (loadMsgOffset - 3));
//				// minus 2 tas tollerance so it does not leave a gap between new ones loaded and ones already loaded
//				alert(($('#messageList').height() / allMsgsHeight))
			}
		});
		
	});
</script>
