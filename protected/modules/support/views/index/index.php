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
	.flags{width:5%;}
	.time{font-weight:bold;color:#787878;}
	.sel, .sel .faded, .sel .time {background-color:#999;color:#fff;}
	.mod.toolbar {border-top:1px solid #ccc;}
	.mod.toolbar .inner {border-bottom:1px solid #bbb;border-top:1px solid #fff;background:-moz-linear-gradient(center top , #ebebeb, #d2d2d2) repeat scroll 0 0 transparent;}
	.mod.toolbar .inner .bd {height:30px;}
	.popSpinner{display:none;border:1px solid #333;-moz-border-radius:5px;width:150px;height:55px;opacity:0.8;color:#fff;background-color:#666;position:absolute;top:400px;left:230px;background:-moz-linear-gradient(center top , #999, #333) repeat scroll 0 0 transparent;}
	
	.scroll{overflow:auto;height:300px;}
	#messageList{background:url('http://localhost/newicon/projects/images/message-border.png') repeat top left;}

	#mClient{overflow:hidden;}
	#email{overflow:auto;}
</style>
<script type="text/javascript" src="http://localhost/newicon/projects/jquery.layout.min-1.2.0.js"></script>

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
				<?php //$this->actionLoadMessageList(0); ?>
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

	$(window).stop().resize(function(){
		resizer();
	});
	var resizer = function(){
		//console.log('height:'+$('#mClient').height());
		var paddingBottom = $('.main').padding().bottom;
		var minHeight = 200;
		if(!(($(window).height()-$('#mClient').position().top-paddingBottom) <= minHeight)){
			//console.log();
			$('#mClient').css('height',
				($(window).height()
					- $('#mClient').position().top
					- paddingBottom
				) +'px');
			$('#messageScroll').css('height',($(window).height()-$('#messageScroll').position().top-paddingBottom)+'px');
			$('#email').css('height',($(window).height()-$('#email').position().top-paddingBottom)+'px');
		}
	}
	resizer();

	
	$('#messageFolders').load('<?php echo NHtml::url('/support/index/loadMessageFolders') ?>');
	$('#messageList').delegate('.listItem','click',function(){
		$(this).parent().find('.listItem').removeClass('sel');
		$(this).addClass('sel');
		var id = $(this).attr('id');
		$('#email').load('<?php echo NHtml::url('/support/index/message') ?>/id/'+id);
	});

	$('.popSpinner').show();
	$('#messageList').load('<?php echo NHtml::url('/support/index/loadMessageList'); ?>',function(){
		$('.popSpinner').hide();
	});
	var loadedBatches = [];
	loadedBatches[0] = 1;
	$('#messageScroll').bind('scrollstop',function(){
		var msgHeight = <?php echo $msgPreviewHeight;?>;
		var msgNumber = <?php echo $msgPreviewNumber;?>;
		var allMsgsHeight = msgHeight*msgNumber;

		$lastMsg = $('#messageList').find('.listItem:last');
		if(!$lastMsg.length)
			return;
		var lastMsgPos = $lastMsg.position();

		// calculate the batch (page) to load based on the current scroll position
		//console.log($(this).scrollTop());
		//console.log('allmsgbath height: '+allMsgsHeight);
		var batchToLoad = Math.floor(($(this).scrollTop() / allMsgsHeight));
		//console.log('LOAD BATCH: ' + batchToLoad);
		if(batchToLoad in loadedBatches){
			//alert('LOAD BATCH: ' + batchToLoad);
			//console.log('DO NOT LOAD BATCH: ' + batchToLoad);
		}else{
			$('.popSpinner').show();
			$.ajax({
				url:'<?php echo NHtml::url('/support/index/loadMessageList/offset'); ?>/'+batchToLoad,
				success:function($msgs){
					$('#messageList').append($msgs);
					$('.popSpinner').hide();

				}
			});
			loadedBatches[batchToLoad] = 1;
		}
	});

});

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