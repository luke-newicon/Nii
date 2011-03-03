<?php $this->breadcrumbs=array($this->module->id); ?>

<h1>Support</h1>
<style>
	.listItem{border-bottom:1px solid #ECECEC;padding:5px 10px;cursor:pointer;}
	.listItem .subject{overflow:hidden;height:18px;}
	.listItem .body{overflow:hidden;height:32px;}
	.listItem .from{font-weight:bold;font-size:15px;}
	.leftPanel{border-right:1px solid #ccc;}
	.flags{width:5%;}
	.time{font-weight:bold;color:#787878;}
	.sel, .sel .faded{background-color:#999;color:#fff;}
</style>
<div class="line">
	<div class="unit size1of5 leftPanel">
		<?php foreach($tickets as $i=>$ticket): ?>
			<div class="line listItem " id="<?php echo $ticket->id(); ?>">
				<div class="unit flags">
					&nbsp;
				</div>
				<div class="lastUnit">
					<div class="line">
						<div class="unit size3of4 from">
							<?php echo $ticket->getFrom(); ?>
						</div>
						<div class="lastUnit txtR">
							<?php echo NTime::niceShorter($ticket->getRecentEmail()->date); ?>
						</div>
					</div>
					<div class="subject">
						<?php echo $ticket->subject .'<br/>' ?>
					</div>
					<div class="body faded">
						<?php echo $ticket->getRecentEmail()->getPreviewText(); ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div id="email" class="lastUnit"></div>
</div>


<script>
	$('.listItem').click(function(){
		$(this).parent().find('.listItem').removeClass('sel');
		$(this).addClass('sel');
		var id = $(this).attr('id');
		$('#email').load('<?php echo NHtml::url('/support/index/message') ?>/id/'+id);
	});
</script>
