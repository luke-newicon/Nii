<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h4><?php echo $email->subject; ?></h4>
<div id="from" class="line">
	<div class="unit">
		<span class="icon fam-bullet-arrow-down toggleHeaderInfo"></span>
	</div>
	<div class="lastUnit">
		<div id="emailHeaderSummary">
			<div class="line">
				<div class="unit"><span class="faded">From</span></div>
				<div class="lastUnit pls">
					<a class="contactLinkBtn" href="#"><?php echo $email->getFrom(); ?></a>
					<span class="faded"><?php echo NTime::timeAgoInWordsShort($email->date); ?></span>
				</div>
			</div>
		</div>
		<div id="emailHeaderDetail" class="data" style="display:none;">
			<div class="line">
				<div class="unit"><span class="faded">From</span></div>
				<div class="lastUnit pls">
					<ul class="token-input-list-nii">
						<li class="contactLinkBtn token-input-token-nii" href="#"><?php echo CHtml::encode($email->from); ?></li>
					</ul>
				</div>
			</div>
			<div class="line">
				<div class="unit"><span class="faded">Date</span></div>
				<div class="lastUnit pls"><?php echo NTime::nice($email->date); ?></div>
			</div>
			<div class="line">
				<div class="unit"><span class="faded">To</span></div>
				<div class="lastUnit pls">
					<ul class="token-input-list-nii">
					<?php foreach($email->to() as $recip): ?>
						<li class="token-input-token-nii"><?php echo $recip['name']; ?> &lt;<?php echo $recip['email']; ?>&gt;</li>
					<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<?php if($email->cc): ?>
					<div class="line">
						<div class="unit"><span class="faded">Cc</span></div>
						<div class="lastUnit pls">
							<ul class="token-input-list-nii">
							<?php foreach($email->cc() as $recip): ?>
								<li class="token-input-token-nii"><?php echo $recip['name']; ?> &lt;<?php echo $recip['email']; ?>&gt;</li>
							<?php endforeach; ?>
							</ul>
						</div>
					</div>
			<?php endif; ?>
		</div>
	</div>
</div>