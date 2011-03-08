<?php
/**
 * Displays the list of of messages
 */
?>
<?php foreach($tickets as $i => $ticket): ?>
	<div data-position="<?php echo $i; ?>" style="position:absolute;top:<?php echo $i*86; ?>px" class="line listItem " id="<?php echo $ticket->id(); ?>">
		<div class="unit flags">
			<?php //echo $i + ($offset*30); ?>
		</div>
		<div class="lastUnit">
			<div class="line">
				<div class="unit size3of4 from">
					<?php echo $ticket->getFrom(); ?>
				</div>
				<div class="lastUnit txtR">
					<?php if($ticket->getRecentEmail()!==null):?>
					<?php echo NTime::niceShorter($ticket->getRecentEmail()->date); ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="subject">
				<?php echo $ticket->subject .'<br/>' ?>
			</div>
			<div class="body faded">
				<?php if($ticket->getRecentEmail()!==null):?>
					<?php echo $ticket->getRecentEmail()->getPreviewText(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>