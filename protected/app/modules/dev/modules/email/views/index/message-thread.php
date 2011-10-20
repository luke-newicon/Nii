<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h4><?php echo $container->getSubject(); ?></h4>
<?php if($container->hasMessage()): ?>
<?php $email = $container->getEmail(); ?>
<div id="from" class="line">
	<div class="unit">
		<span class="icon fam-bullet-arrow-down toggleHeaderInfo"></span>
	</div>
	<div class="lastUnit">
		<div id="emailHeaderSummary">
			<div class="line">
				<div class="unit size1of20"><span class="faded">From</span></div>
				<div class="lastUnit">
					<a class="contactLinkBtn" href="#"><?php echo $email->getFrom(); ?></a>
					<span class="faded"><?php echo NTime::timeAgoInWordsShort($email->date); ?></span>
				</div>
			</div>
		</div>
		<div id="emailHeaderDetail" class="data" style="display:none;">
			<div class="line">
				<div class="unit size1of20"><span class="faded">From:</span></div>
				<div class="lastUnit"><a class="contactLinkBtn" href="#"><?php echo CHtml::encode($email->from); ?></a></div>
			</div>
			<div class="line">
				<div class="unit size1of20"><span class="faded">Date:</span></div>
				<div class="lastUnit"><?php echo NTime::nice( $email->date); ?></div>
			</div>
			<div class="line">
				<div class="unit size1of20"><span class="faded">To:</span></div>
				<div class="lastUnit">
					<?php foreach( $email->to() as $recip): ?>
						<?php echo $recip['name']; ?> &lt;<?php echo $recip['email']; ?>&gt;,
					<?php endforeach; ?>
				</div>
			</div>
			<?php if($email->cc): ?>
					<div class="line">
						<div class="unit size1of20"><span class="faded">Cc:</span></div>
						<div class="lastUnit">
							<?php foreach( $email->cc() as $recip): ?>
								<?php echo $recip['name']; ?> &lt;<?php echo $recip['email']; ?>&gt;,
							<?php endforeach; ?>
						</div>
					</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif;?>
<?php if($container->hasChildren()): ?>
<?php foreach($container->children as $c): ?>
	<?php $this->renderPartial('message-thread',array('container'=>$c)); ?>
<?php endforeach; ?>
<?php endif; ?>