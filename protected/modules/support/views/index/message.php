<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$e = $ticket->emails[0];
?>
<style>
	.summaryDetails{border-bottom:1px solid #ddd;padding:0px 10px 5px 10px;}
	.data txtR {padding-right:5px;}
</style>
<div class="summaryDetails">
	<h4><?php echo $ticket->subject; ?> what</h4>
	<div id="from" class="line">
		<div class="unit">
			<span class="icon fam-bullet-arrow-down toggleHeaderInfo"></span>
		</div>
		<div class="lastUnit">
			<div id="emailHeaderSummary">
				<div class="line">
					<div class="unit size1of20"><span class="faded">From</span></div>
					<div class="lastUnit">
						<a class="contactLinkBtn" href="#"><?php echo $ticket->getFrom(); ?></a> 
						<span class="faded"><?php echo NTime::timeAgoInWordsShort($e->date); ?></span>
					</div>
				</div>
			</div>
			<div id="emailHeaderDetail" class="data" style="display:none;">
				<div class="line">
					<div class="unit size1of20"><span class="faded">From:</span></div>
					<div class="lastUnit"><a class="contactLinkBtn" href="#"><?php echo CHtml::encode($ticket->from); ?></a></div>
				</div>
				<div class="line">
					<div class="unit size1of20"><span class="faded">Date:</span></div>
					<div class="lastUnit"><?php echo NTime::nice($e->date); ?></div>
				</div>
				<div class="line">
					<div class="unit size1of20"><span class="faded">To:</span></div>
					<div class="lastUnit"> 
						<?php foreach($e->to() as $recip): ?>
							<?php echo $recip['name']; ?> &lt;<?php echo $recip['email']; ?>&gt;,
						<?php endforeach; ?>
					</div>
				</div>
				<?php if($e->cc): ?>
						<div class="line">
							<div class="unit size1of20"><span class="faded">Cc:</span></div>
							<div class="lastUnit">
								<?php foreach($e->cc() as $recip): ?>
									<?php echo $recip['name']; ?> &lt;<?php echo $recip['email']; ?>&gt;,
								<?php endforeach; ?>
							</div>
						</div>
				<?php endif; ?>
			</div>
		</div>
		
	</div>
</div>
<div id="message">
	<script type="text/javascript">
		$(function(){
			$("#eframe<?php echo $e->id() ?>").load(function () {
				// make height of iframe expand to its content size
				$(this).height($(this).contents().height());
				//TODO: cache the iframe contents.
				//$(this).contents().find('html').html();
			});
			$('.toggleHeaderInfo').click(function(){
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
	</script>
	<iframe style="width:100%;height:1500px;border:0px none;margin:0px;padding:0px;" width="100%" frameborder="0" scrolling="no" 
			id="eframe<?php echo $e->id() ?>" src="<?php echo NHtml::url("/support/index/email/id/".$e->id()); ?>"></iframe>

</div>