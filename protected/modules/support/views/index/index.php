<?php $this->breadcrumbs=array($this->module->id); ?>

<h1>Support</h1>
<style>
	.listItem{border-bottom:1px solid #ECECEC;padding:5px 10px;cursor:pointer;}
	.listItem .subject{overflow:hidden;height:18px;}
	.listItem .body{overflow:hidden;height:32px;}
	.listItem .from{font-weight:bold;font-size:15px;}
	.leftPanel{border-right:1px solid #ccc;width:300px;}
	.leftMainPanel{border-right:1px solid #ccc;background-color:#f9f9f9;}
	.flags{width:5%;}
	.time{font-weight:bold;color:#787878;}
	.sel, .sel .faded, .sel .time {background-color:#999;color:#fff;}
	.mod.toolbar {border-top:1px solid #ccc;}
	.mod.toolbar .inner {border-bottom:1px solid #bbb;border-top:1px solid #fff;background:-moz-linear-gradient(center top , #ebebeb, #d2d2d2) repeat scroll 0 0 transparent;}
	.mod.toolbar .inner .bd {height:30px;}
	.spinner-white{background:url('/images/white-spinner.gif');}
	.popSpinner{border:1px solid #333;-moz-border-radius:5px;width:150px;height:55px;opacity:0.8;color:#fff;background-color:#ccc;position:absolute;top:50px;left:200px;background:-moz-linear-gradient(center top , #999, #333) repeat scroll 0 0 transparent;}
</style>
<script type="text/javascript" src="http://localhost/newicon/projects/assets/jquery.layout.min.js"></script>
<div class="popSpinner">
	<div class="line"><div class="unit size1of4 pam"><div class="spinner">&nbsp;</div></div><div class="lastUnit"><div class="h4 mln" style="color:#fff;padding-top:15px;">Loading...</div></div></div>
</div>
<div class="line">
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
		<div id="messageList" >
			
		</div>
	</div>
	<div id="emailBox" class="lastUnit ui-layout-east">
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
		$('#messageList').load('<?php echo NHtml::url('/support/index/loadMessageList') ?>');
		$('#messageFolders').load('<?php echo NHtml::url('/support/index/loadMessageFolders') ?>');
		$('#messageList').delegate('.listItem','click',function(){
			$(this).parent().find('.listItem').removeClass('sel');
			$(this).addClass('sel');
			var id = $(this).attr('id');
			$('#email').load('<?php echo NHtml::url('/support/index/message') ?>/id/'+id);
		});
	});
</script>
