<?php $msgPreviewHeight=86; ?>
<?php $msgPreviewNumber=SupportModule::get()->msgPageLimit; ?>
<style>
	.mod.toolbar {border-top:1px solid #ccc;}
	.mod.toolbar .inner {border-bottom:1px solid #888;border-top:1px solid #fff;
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ebebeb', endColorstr='#d2d2d2');
		background: -webkit-gradient(linear, left top, left bottom, from(#ebebeb), to(#d2d2d2));
		background:-moz-linear-gradient(center top , #ebebeb, #d2d2d2) repeat scroll 0 0 transparent;
	}
	.mod.toolbar .inner .bd {height:30px;border-left:1px solid #eee}
	
	#mClient{overflow:hidden;}
	
	/** Folder column **/
	#messageFoldersBox{width:60px;background-color:#3b4446;}
	.leftMainPanel{background-color:#3b4446;}
	#messageFolders{border-right:1px solid #000;}
	
	/** Message List column **/
	#messageListBox{width:338px;}
	/** pulls the margin to pull the scroll bar accross */
	#messageList{margin-right:-10px;}
	.leftPanel{width:300px;}
	#messageScroll{border-right:1px solid #a7a7a7;}
	.listItem{border-bottom:1px solid #d6d6d6;padding:7px 12px 5px 10px;cursor:pointer;height:73px;
			 filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#f9f9f9');
			background: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#f9f9f9));
			background:-moz-linear-gradient(center top , #ffffff, #f9f9f9) repeat scroll 0 0 transparent;}
	.listItem .subject{overflow:hidden;height:1.4em;}
	.listItem .body{overflow:hidden;height:30px;font-size:12px;}
	.listItem .from{font-weight:bold;font-size:14px;height:1.4em;overflow:hidden;width:170px;}
	.flags{width:20px;}


	/** Message Read column **/
	#email{overflow:auto;}
	#summaryDetails{border-bottom:1px solid #ddd;padding:10px 15px;}
	.data txtR {padding-right:5px;}
	
	/** Misc **/
	.popSpinner{z-index:1000;display:none;border:1px solid #333;-moz-border-radius:5px;border-radius:5px;width:150px;height:55px;opacity:0.8;color:#fff;background-color:#666;position:absolute;top:400px;left:230px;background:-moz-linear-gradient(center top , #999, #333) repeat scroll 0 0 transparent;}

	.scroll{overflow:auto;height:250px;}
	
	.blue .faded, .blue .time {color:#6282c1;font-size:11px;}
	.popy{border:1px solid #000;background:#909090;box-shadow:0px 0px 10px #333;border-radius:5px;}
	.popy .inner{box-shadow:0px 0px 0px 1px #ccc inset;border-radius:5px;}
	.threadNumber{background: none repeat scroll 0 0 rgba(82, 82, 82, 0.5); -webkit-border-radius:3px;-moz-border-radius:3px;border-radius: 3px;color: white;font-size: 10px;padding: 1px 3px;text-shadow: 0 1px 0 #888;}
	
	.btn.btnImage{padding:0px;margin:2px 10px 0px 10px;}
	
</style>
<?php //$this->widget('nii.widgets.popSpinner'); ?>
<div class="popSpinner">
	<div class="line"><div class="unit size1of4 pam"><div class="spinner">&nbsp;</div></div><div class="lastUnit"><div class="h4 mln" style="color:#fff;padding-top:15px;text-shadow: 0 -1px 0 #000000;">Loading...</div></div></div>
</div>
<div style="display:none;">
<?php $this->widget('nii.widgets.tokeninput.NTokenInput',array('name'=>'dummy','data'=>'dummy'))->publishAssets(); ?>
</div>

<?php
$this->widget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'mydialog',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Dialog box 1',
		'autoOpen' => false,
		'modal'=>true,
		'width'=>'600',
		'buttons' => array(
			'send' => array(
				'text' => 'send',
				'click'=>'js:function(){
					for (instance in CKEDITOR.instances )
					  CKEDITOR.instances[instance].updateElement();
					$.post("'.NHtml::url('/support/index/send').'",$("#mydialog form").serialize(),function(){
						//$("#mydialog").dialog("close");
					});
				}'
			),
		),
		'open'=>'js:function(e,ui){
			$("#mydialog").load("'.NHtml::url('/support/index/compose').'");
		}',
		'resize'=>'js:function(e,ui){
			var newHeight = $("#mydialog").height() - $("#emailWysiwyg").position().top;
			var newWidth =  $("#mydialog").width();
			CKEDITOR.instances["SupportComposeMail_message_html"].resize(newWidth,newHeight);
		}'
	),
));

?>


<div class="line" id="mClient">
	<div id="messageFoldersBox" class="unit size1of8 leftMainPanel">
		<?php $this->beginWidget('nii.widgets.oocss.Mod', array('class'=>'mod toolbar man')); ?>
			<div class="bd pas">
				&nbsp; 
			</div>
		<?php $this->endWidget(); ?>
		<div id="messageFolders">
			<span style="color:white;text-shadow:1px 1px 0px #000;"><?php echo count(NEmailReader::unseen()); ?></span>
		</div>
	</div>
	
	<div id="messageListBox" class="unit size1of5 leftPanel ui-layout-west">
		<?php $this->beginWidget('nii.widgets.oocss.Mod', array('class'=>'mod toolbar man')); ?>
			<div class="bd pas txtR">
				<a href="#" data-tip="{'gravity':'s'}" title="Compose email" onclick="$('#mydialog').dialog('open'); return false;" id="compose" class="btn btnImage"><img src="<?php echo SupportModule::get()->getAssetsUrl() ?>/images/compose.png" /></a>
				<a href="#" data-tip="{'gravity':'s'}" title="Reply" onclick="$('#mydialog').dialog('open'); return false;" id="compose" class="btn btnImage"><img src="<?php echo SupportModule::get()->getAssetsUrl() ?>/images/reply.png" /></a>
				<a style="margin-right:30px;" href="#" data-tip="{'gravity':'s'}" title="Trash" onclick="$('#mydialog').dialog('open'); return false;" id="compose" class="btn btnImage"><img src="<?php echo SupportModule::get()->getAssetsUrl() ?>/images/trash.png" /></a>
			</div>
		<?php $this->endWidget(); ?>
		<div id="messageScroll" class="scroll">
			<?php //messageList will be as high as total number of messages  ?>
			<div id="messageList" style="height:<?php echo $total*$msgPreviewHeight; ?>px;position:relative;">
				<div id="newMessages"></div>
			<?php //$this->actionLoadMessageList(0); ?>
			</div>
		</div>
	</div>
	<div id="emailBox" class="lastUnit ui-layout-center">
		<?php $this->renderPartial('_message-toolbar'); ?>
		<div id="email">
			<div id="reply">
			</div>
			<div id="emailView">
				<div id="summaryDetails">
					<!-- Display the email summary information from, to, subject etc -->
				</div>
				<div id="message">
					<iframe style="width:100%;height:100%;border:0px none;margin:0px;padding:0px;" width="100%" frameborder="0" scrolling="no"
							src="<?php echo NHtml::url('/support/index/emptyIframe'); ?>">
					</iframe>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" language="javascript" src="<?php echo NHtml::url('/'); ?>/ape/JavaScript.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo NHtml::url('/'); ?>/ape/config.js"></script>
<script>

$(function(){

	$(window).stop().resize(function(){
		resizer();
	});
	
	$.ui.plugin.add("resizable", "iframeFix", { 
		start: function(event, ui) { 
			var o = $(this).data('resizable').options; 
			$(o.iframeFix === true ? "iframe" : o.iframeFix).each(function() { 
				$('<div class="ui-resizable-iframeFix" style="background: #fff;"></div>') 
				.css({ 
					width: this.offsetWidth+"px", height: this.offsetHeight+"px", 
					position: "absolute", opacity: "0.001", zIndex: 1000 
				}) 
				.css($(this).offset()) 
				.appendTo("body"); 
			}); 
		}, 
		stop: function(event, ui) { 
			$("div.ui-resizable-iframeFix").each(function() { this.parentNode.removeChild(this); }); //Remove frame helpers 
		} 
	}); 
				
	
	$('#messageListBox').resizable({
		handles:'e',
		minWidth: 240,
		iframeFix:true,
		alsoResize: '#messageScroll, #messageScroll .jspContainer, #messageScroll .jspPane',
		stop: function(event, ui) {
			resizer();
		}
	});

//	$('body').ajaxStart(function(){
//		$('.popSpinner').show();
//	});
//	$('body').ajaxStop(function(){
//		$('.popSpinner').hide();
//	});
//
	var timer;
	var scroll = $('#messageScroll')
		.bind('jsp-initialised',function(event, isScrollable){
//			console.log('Handle jsp-initialised', this,
//				'isScrollable=', isScrollable);
		})
		.bind('jsp-scroll-y',function(event, scrollPositionY, isAtTop, isAtBottom){
			//$('.jspDrag').stop(1,0).fadeTo(100,0.7);
			$('.jspDrag').stop(1,0).css('opacity','0.7').show();
			if (timer) {
				clearTimeout(timer);
			}

			timer = setTimeout( function(){
				timer = null;
				$('.jspDrag').stop(1,0).delay(400).fadeOut(500);
				scrollStop(scrollPositionY);
			}, 500);
				
		})
		.bind('jsp-arrow-change', function(event, isAtTop, isAtBottom, isAtLeft, isAtRight){
//			console.log('Handle jsp-arrow-change', this,
//						'isAtTop=', isAtTop,
//						'isAtBottom=', isAtBottom,
//						'isAtLeft=', isAtLeft,
//						'isAtRight=', isAtRight);
		})
		.jScrollPane({
			verticalDragMinHeight: 20,
			verticalGutter:0,
			hideFocus:1
		})
		.data('jsp');

	var resizer = function(){
		if (timer) {
			clearTimeout(timer);
		}
		timer = setTimeout( function(){
			var paddingBottom = $('.main').padding().bottom;
			var minHeight = 200;
			var winHeight = $(window).height();
			if(!((winHeight-$('#mClient').position().top-paddingBottom) <= minHeight)){
				$('#mClient').css('height',(winHeight - $('#mClient').position().top - paddingBottom) + 'px');
				$('#messageScroll').css('height',(winHeight-$('#messageScroll').position().top-paddingBottom)+'px');
				$('#email').css('height',(winHeight-$('#email').position().top-paddingBottom)+'px');
				$('#messageFolders').css('height',(winHeight-$('#messageFolders').position().top-paddingBottom)+'px');

				if($("#emailWysiwyg").length){
					var newHeight = $("#email").height() -  ($("#emailWysiwyg").position().top - $("#email").position().top);
					var newWidth =  $("#email").width()-5;
					CKEDITOR.instances['SupportComposeMail_message_html'].resize(newWidth,newHeight);
					$('#cke_SupportComposeMail_message_html').css('width','100%');
				}

			}
			scroll.reinitialise();
		}, 300);
	}
	
	
	resizer();
	// make scroll thumb hidden
	$('.jspDrag').hide();
	$('#messageScroll').delegate('.jspContainer','mouseenter',function(){
		$('.jspDrag').stop(1,0).fadeTo(100,0.7).delay(400).fadeOut();
	});
	
	$('#messageScroll').delegate('.jspContainer','mouseleave',function(){
		$('.jspDrag').stop(1,0).delay(300).fadeOut();
	})


	//$('#messageFolders').load('<?php echo NHtml::url('/support/index/loadMessageFolders') ?>');

	var $email = $('#email');

	var msgsLoaded = [];
	/**
	 * load selected email message
	 */
	$('#messageList').delegate('.listItem','click',function(){
		$('#messageList').find('.listItem').removeClass('sel').removeClass('selTop');
		$('#emailView').show();
		$('#reply').hide();
		$(this).addClass('sel');
		$(this).prev('.listItem').addClass('selTop');
		var id = $(this).data('id');
		// create string for array key to prevent javascript padding array to key index
		var key = 'ID'+id;
		
		if(key in msgsLoaded){
			// message has been cached into the msgsLoaded variable so lets just display that.
			inserMessage(msgsLoaded[key]);
		}else{
			$('.popSpinner').show().position({my:'center',at:'center',of:$email}).show();
			// html not in cache so ajax it in.
			$.getJSON('<?php echo SupportModule::getLoadMessageUrl(); ?>/id/'+id, function(json){
				msgsLoaded[key] = json;
				inserMessage(json);
				resizer();
			});
		}
	});
	
	/**
	 * inserts the html email content into the page
	 * @param object json contains summary=>html content, content=>html email message content
	 */
	var inserMessage = function(json){
		// mark list item as read
		$('#messageList .listItem.sel [data-role="flag-opened"]').removeClass('icon')
		// insert summary html
		$email.find('#summaryDetails').html(json.summary);
		
		// insert email message html
		var $iframe = $email.find('#message iframe');
		$('.popSpinner').hide();
		
		// set up the headers we always want in our email iframe
		var html = '<meta http-equiv="Content-type" content="text/html; charset=utf-8">\
			<meta http-equiv="X-UA-Compatible" content="IE=Edge">\
			<meta http-equiv="X-UA-Compatible" content="IE=Edge">\
			<base target="_blank">\
			<style>body {padding: 15px 15px 0px;font: 13px Helvetica, Arial, Verdana, sans-serif;margin: 0px;overflow: hidden;}blockquote[type=cite] {border-left: 2px solid #003399;margin:0;padding: 0 12px 8px 12px;font-size: 12px;color: #003399;}blockquote[type=cite] blockquote[type=cite] {border-left: 2px solid #006600;margin:0;padding: 0 12px 0 12px;font-size: 12px;color: #006600}blockquote[type=cite] blockquote[type=cite] blockquote[type=cite] {border-left : 2px solid #660000;margin:0;padding: 0 12px 0 12px;font-size: 12px;color: #660000}pre {white-space: pre-wrap; white-space: -moz-pre-wrap;white-space: -pre-wrap; white-space: -o-pre-wrap;word-wrap: break-word;white-space: pre-wrap !important;word-wrap: normal !important;font: 13px Helvetica, Arial, Verdana, sans-serif;}</style>';

		$iframe.contents().find('html head').html(html);
		// we create our own body tag in the iframe as it must be present
		// so we need to scrape any body styles from the email before adding it to the iframe
		var styles = '';
		var bodyAttrsMatch = /<body (.*?)>/.exec(json.content);
		if(bodyAttrsMatch != null){
			var bodyAttrs = bodyAttrsMatch[1];
			var bodyStyleMatch = /style="([^"]*)"/.exec(bodyAttrs);
			if(bodyStyleMatch != null){
				styles = bodyStyleMatch[1];
			}
		}
		//var attrArr = /([^=]*)="([^"]*)"|\'([^\']*)\'/.exec(bodyAttrs);
		// append appropriate html email body styles to the iframe body 
		$iframe.contents().find('body').attr('style', styles);
		$iframe.contents().find('body').html(json.content);
		// make height of iframe expand to its content size
		$iframe.height(0);
		//alert($iframe.contents().height());
		$iframe.height($iframe.contents().height());
	}


	var loadedBatches = [];
	var loadMessageBatch = function(batch){
		$('.popSpinner').show().position({my:'center',at:'center',of:'#messageScroll'}).show();
		$.ajax({
			url:'<?php echo SupportModule::getLoadMessageListUrl(); ?>/'+batch,
			success:function($msgs){
				$('#messageList').append($msgs);
				//now ajust position to take into account any new emails
				var $msgList = $('#messageList .mesageContainer:last');
				var newMsgHeight = $('#newMessages .listItem').length*<?php echo $msgPreviewHeight; ?>;
				var newTop = parseFloat($msgList.css('top'))+newMsgHeight;
				$msgList.css('top',newTop+'px');
				$('.popSpinner').hide();
			}
		});
		loadedBatches[batch] = 1;
	}


	loadMessageBatch(0);
	var scrollStop = function(scrollY){
		var msgHeight = <?php echo $msgPreviewHeight;?>;
		var msgNumber = <?php echo $msgPreviewNumber;?>;
		var allMsgsHeight = msgHeight*msgNumber;

		// the height of messages reminaing in the viewable portion of the scroll
		// before new messages are loaded
		var tollerance = 275;
		// calculate the batch (page) to load based on the current scroll position
		var batchToLoad = Math.floor(((scrollY + tollerance) / allMsgsHeight));

		// status debug reporting
		if (typeof(console) == 'object') {
			console.log((scrollY+tollerance));
			console.log('allmsgbath height: '+allMsgsHeight);
			console.log('LOAD BATCH: ' + batchToLoad);
		}

		// if the message batch has not already been loaded send ajax request to load them in
		if(!(batchToLoad in loadedBatches)){
			loadMessageBatch(batchToLoad);
		}
	};

	/**
	 * Toggle the email header details
	 */
	$('#email').delegate('.toggleHeaderInfo', 'click', function(){
		if($('#emailHeaderSummary').is(':visible')){
			$(this).removeClass('fam-bullet-arrow-down').addClass('fam-bullet-arrow-up');
			$('#emailHeaderSummary').hide();
			$('#emailHeaderDetail').show();
		}else{
			$(this).removeClass('fam-bullet-arrow-up').addClass('fam-bullet-arrow-down');
			$('#emailHeaderSummary').show();
			$('#emailHeaderDetail').hide();
		}
	});
	

	
	var addNewMessage = function(msg){
		var $ml = $('#messageList');
		var $nm = $ml.find('#newMessages');
		$(msg).prependTo($nm).css('top','-86px');
		$nm.find('.listItem').css('position','absolute').animate({top:'+=<?php echo $msgPreviewHeight; ?>'}, 500);
		$ml.find('.mesageContainer').animate({top:'+=<?php echo $msgPreviewHeight; ?>'}, 500, function() {
			$ml.height($ml.height()+<?php echo $msgPreviewHeight; ?>);
		});
	}
	
	/**
	 * buttons
	 */
	$('.reply').click(function(){
		$('#reply').show();
		var id = $('#messageList .sel').data('id');
		$('#emailView').hide();
		$('#reply').load('<?php echo NHtml::url('/support/index/reply/emailId') ?>/'+id, function(){
			$('#composeMail').removeAttr('style');
			//resizer();
		});
	});
	
	var checkMail = function(time){
		time = (time==undefined) ? 10000 : time;
		setTimeout( function(){
			doCheckMail(time)
		},time);
	}
	var doCheckMail = function(time){
		var id = $('#messageList .listItem:first').data('id');
		$.getJSON("<?php echo NHtml::url('/support/index/checkMail'); ?>/id/"+id, function(r){
			jQuery.each(r, function(index, itemData) {
				addNewMessage(itemData);
			});
			checkMail(time);
		});
	}
	checkMail(5000);
	
	
	
	
	
	
//    _     ___   __
//   / \   |   | |
//  /___\  |___| |--
// /     \ |     |__
// -------------------
	
var client = new APE.Client();
// 
//	//1) Load APE Core
client.load();
//
//	//2) Intercept 'load' event. This event is fired when the Core is loaded and ready to connect to APE Server
client.addEvent('load', function() {
	//3) Call core start function to connect to APE Server, and prompt the user for a nickname
	client.core.start({"name": prompt('Your name?')});
	//1) join 'testChannel'


});


//	//4) Listen to the ready event to know when your client is connected
client.addEvent('ready', function() {

	 console.log('Your client is now connected');
	//1) join 'testChannel'
	client.core.join(['sysmsg','emails']);

	//2) Intercept multiPipeCreate event
	client.addEvent('multiPipeCreate', function(pipe, options) {
	//3) Send the message on the pipe
	pipe.send('Hello world!');
		console.log('Sending Hello world');
	});

	//4) Intercept receipt of the new message.
	client.onRaw('data', function(raw, pipe) {
		
		console.log('Receiving : ' + unescape(raw));
	});
});



});




/*
 * Used to determine border pixel sizes for resizing panes
 * e.g. $('selector').border().bottom ( = integer size in pixels )
 * 
 * JSizes - JQuery plugin v0.33
 *
 * Licensed under the revised BSD License.
 * Copyright 2008-2010 Bram Stein
 * All rights reserved.
 */
(function(b){var a=function(c){return parseInt(c,10)||0};b.each(["min","max"],function(d,c){b.fn[c+"Size"]=function(g){var f,e;if(g){if(g.width!==undefined){this.css(c+"-width",g.width)}if(g.height!==undefined){this.css(c+"-height",g.height)}return this}else{f=this.css(c+"-width");e=this.css(c+"-height");return{width:(c==="max"&&(f===undefined||f==="none"||a(f)===-1)&&Number.MAX_VALUE)||a(f),height:(c==="max"&&(e===undefined||e==="none"||a(e)===-1)&&Number.MAX_VALUE)||a(e)}}}});b.fn.isVisible=function(){return this.is(":visible")};b.each(["border","margin","padding"],function(d,c){b.fn[c]=function(e){if(e){if(e.top!==undefined){this.css(c+"-top"+(c==="border"?"-width":""),e.top)}if(e.bottom!==undefined){this.css(c+"-bottom"+(c==="border"?"-width":""),e.bottom)}if(e.left!==undefined){this.css(c+"-left"+(c==="border"?"-width":""),e.left)}if(e.right!==undefined){this.css(c+"-right"+(c==="border"?"-width":""),e.right)}return this}else{return{top:a(this.css(c+"-top"+(c==="border"?"-width":""))),bottom:a(this.css(c+"-bottom"+(c==="border"?"-width":""))),left:a(this.css(c+"-left"+(c==="border"?"-width":""))),right:a(this.css(c+"-right"+(c==="border"?"-width":"")))}}}})})(jQuery);
</script>




<!--

</div>-->