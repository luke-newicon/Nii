<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$e = $ticket->emails[0];
?>
<style>
	#summaryDetails{border-bottom:1px solid #ddd;padding:0px 10px 5px 10px;}
	.data txtR {padding-right:5px;}
</style>
<h4><?php echo $ticket->subject; ?></h4>
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