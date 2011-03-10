<?php $msgPreviewHeight=75; ?>
<?php $msgPreviewNumber=SupportModule::get()->msgPageLimit; ?>
<?php echo 'total messages ' . $total; ?>
<style>
	.listItem{border-bottom:1px solid #ECECEC;padding:5px 10px;cursor:pointer;height:75px;}
	.listItem .subject{overflow:hidden;height:1.4em;}
	.listItem .body{overflow:hidden;height:32px;}
	.listItem .from{font-weight:bold;font-size:15px;height:1.4em;overflow:hidden;}
	.leftPanel{border-right:1px solid #ccc;width:300px;}
	.leftMainPanel{border-right:1px solid #ccc;background-color:#f9f9f9;}
	.flags{width:8%;}
	.time{font-weight:bold;color:#787878;}
	.sel {background-color:#999;color:#fff;}
	.sel .faded,.sel .time{color:#ddd;}
	.mod.toolbar {border-top:1px solid #ccc;}
	.mod.toolbar .inner {border-bottom:1px solid #bbb;border-top:1px solid #fff;background:-moz-linear-gradient(center top , #ebebeb, #d2d2d2) repeat scroll 0 0 transparent;}
	.mod.toolbar .inner .bd {height:30px;}
	.popSpinner{z-index:1000;display:none;border:1px solid #333;-moz-border-radius:5px;border-radius:5px;width:150px;height:55px;opacity:0.8;color:#fff;background-color:#666;position:absolute;top:400px;left:230px;background:-moz-linear-gradient(center top , #999, #333) repeat scroll 0 0 transparent;}
	
	.scroll{overflow:auto;height:250px;}
	#messageList{background:url('http://localhost/newicon/projects/images/message-border.png') repeat top left;}

	#mClient{overflow:hidden;}
	#email{overflow:auto;}
	#messageFolders{overflow:auto;}
</style>
<script type="text/javascript" src="http://localhost/newicon/projects/jquery.layout.min-1.2.0.js"></script>
<?php //$this->widget('application.widgets.popSpinner'); ?>
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
			<div id="messageList" style="height:<?php echo $total*$msgPreviewHeight; ?>px;position:relative;">
				<?php //$this->actionLoadMessageList(0); ?>
			</div>
		</div>
	</div>
	<div id="emailBox" class="lastUnit ui-layout-center">
		<?php $this->renderPartial('_message-toolbar'); ?>
		<div id="email">
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

<script>
var msgsLoaded = [];
$(function(){

	$(window).stop().resize(function(){
		resizer();
	});

	$('body').ajaxStart(function(){
		$('.popSpinner').show();
	});
	$('body').ajaxStop(function(){
		$('.popSpinner').hide();
	});
	var resizer = function(){
		var paddingBottom = $('.main').padding().bottom;
		var minHeight = 200;
		var winHeight = $(window).height();
		if(!((winHeight-$('#mClient').position().top-paddingBottom) <= minHeight)){
			$('#mClient').css('height',(winHeight - $('#mClient').position().top - paddingBottom) + 'px');
			$('#messageScroll').css('height',(winHeight-$('#messageScroll').position().top-paddingBottom)+'px');
			$('#email').css('height',(winHeight-$('#email').position().top-paddingBottom)+'px');
			$('#messageFolders').css('height',(winHeight-$('#messageFolders').position().top-paddingBottom)+'px');
		}
	}
	resizer();

	$('#messageFolders').load('<?php echo NHtml::url('/support/index/loadMessageFolders') ?>');

	var $email = $('#email');

	/**
	 * load selected email message
	 */
	$('#messageList').delegate('.listItem','click',function(){
		$(this).parent().find('.listItem').removeClass('sel');
		$(this).addClass('sel');
		var id = $(this).attr('id');
		// create string for array key to prevent javascript padding array to key index
		var key = 'ID'+id;

		if(key in msgsLoaded){
			// message has been cached into the msgsLoaded variable so lets just display that.
			inserMessage(msgsLoaded[key]);
		}else{
			$('.popSpinner').position({my:'center',at:'center',of:$email}).show();
			// html not in cache so ajax it in.
			$.getJSON('<?php echo NHtml::url('/support/index/message') ?>/id/'+id, function(json){
				msgsLoaded[key] = json;
				inserMessage(json);
			});
		}
	});

	/**
	 * inserts the html email content into the page
	 * @param object json contains summary=>html content, content=>html email message content
	 */
	var inserMessage = function(json){
		// insert summary html
		$email.find('#summaryDetails').html(json.summary);
		// insert email message html
		var $iframe = $email.find('#message iframe');
		$('.popSpinner').hide();
		// make height of iframe expand to its content size
		var html = '<meta http-equiv="Content-type" content="text/html; charset=utf-8">\
			<meta http-equiv="X-UA-Compatible" content="IE=Edge">\
			<meta http-equiv="X-UA-Compatible" content="IE=Edge">\
			<base target="_blank">\
			<style>body {padding: 13px 20px 0px 20px;font: 13px Helvetica, Arial, Verdana, sans-serif;margin: 0px;overflow: hidden;}blockquote[type=cite] {border-left: 2px solid #003399;margin:0;padding: 0 12px 8px 12px;font-size: 12px;color: #003399;}blockquote[type=cite] blockquote[type=cite] {border-left: 2px solid #006600;margin:0;padding: 0 12px 0 12px;font-size: 12px;color: #006600}blockquote[type=cite] blockquote[type=cite] blockquote[type=cite] {border-left : 2px solid #660000;margin:0;padding: 0 12px 0 12px;font-size: 12px;color: #660000}pre {white-space: pre-wrap; white-space: -moz-pre-wrap;white-space: -pre-wrap; white-space: -o-pre-wrap;word-wrap: break-word;white-space: pre-wrap !important;word-wrap: normal !important;font: 13px Helvetica, Arial, Verdana, sans-serif;}</style>';
		//console.log(json.content);

		$iframe.contents().find('html head').html(html);

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
		
		
		$iframe.contents().find('body').attr('style', styles);
		$iframe.contents().find('body').html(json.content);
		//alert($(json.content).html());

		//$iframe.contents().html(json.content);
		$iframe.height($iframe.contents().height());
	}


	var loadedBatches = [];
	var loadMessageBatch = function(batch){
		$('.popSpinner').position({my:'center',at:'center',of:'#messageScroll'}).show();
		$.ajax({
			url:'<?php echo NHtml::url('/support/index/loadMessageList/offset'); ?>/'+batch,
			success:function($msgs){
				$('#messageList').append($msgs);
				$('.popSpinner').hide();
			}
		});
		loadedBatches[batch] = 1;
	}


	loadMessageBatch(0);
	$('#messageScroll').bind('scrollstop',function(){
		var msgHeight = <?php echo $msgPreviewHeight;?>;
		var msgNumber = <?php echo $msgPreviewNumber;?>;
		var allMsgsHeight = msgHeight*msgNumber;

		// the height of messages reminaing in the viewable portion of the scroll
		// before new messages are loaded
		var tollerance = 275;
		// calculate the batch (page) to load based on the current scroll position
		var batchToLoad = Math.floor((($(this).scrollTop() + tollerance) / allMsgsHeight));

		// status debug reporting
		if (typeof(console) == 'object') {
			console.log(($(this).scrollTop()+tollerance));
			console.log('allmsgbath height: '+allMsgsHeight);
			console.log('LOAD BATCH: ' + batchToLoad);
		}

		// if the message batch has not already been loaded send ajax request to load them in
		if(!(batchToLoad in loadedBatches)){
			loadMessageBatch(batchToLoad);
		}
	});

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
});













////////////////////////////////////////////////////////////
///////////// libraries to include /////////////////////////
////////////////////////////////////////////////////////////



(function(){

    var special = jQuery.event.special,
        uid1 = 'D' + (+new Date()),
        uid2 = 'D' + (+new Date() + 1);

    special.scrollstart = {
        setup: function() {

            var timer,
                handler =  function(evt) {

                    var _self = this,
                        _args = arguments;

                    if (timer) {
                        clearTimeout(timer);
                    } else {
                        evt.type = 'scrollstart';
                        jQuery.event.handle.apply(_self, _args);
                    }

                    timer = setTimeout( function(){
                        timer = null;
                    }, special.scrollstop.latency);

                };

            jQuery(this).bind('scroll', handler).data(uid1, handler);

        },
        teardown: function(){
            jQuery(this).unbind( 'scroll', jQuery(this).data(uid1) );
        }
    };

    special.scrollstop = {
        latency: 300,
        setup: function() {

            var timer,
                    handler = function(evt) {

                    var _self = this,
                        _args = arguments;

                    if (timer) {
                        clearTimeout(timer);
                    }

                    timer = setTimeout( function(){

                        timer = null;
                        evt.type = 'scrollstop';
                        jQuery.event.handle.apply(_self, _args);

                    }, special.scrollstop.latency);

                };

            jQuery(this).bind('scroll', handler).data(uid2, handler);

        },
        teardown: function() {
            jQuery(this).unbind( 'scroll', jQuery(this).data(uid2) );
        }
    };

})();

/*
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