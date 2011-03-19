<?php
/**
 * Displays the list of of messages
 */
?>
<?php foreach($tickets as $i => $ticket): ?>
	<?php $dataPos = $i + ($offset*$limit); ?>
	<?php $bg = ($i == ($limit-1)) ? 'background-color:#ff0000;':''; ?>
	
	<div data-position="<?php echo $dataPos; ?>" style="<?php echo $bg; ?>position:absolute;top:<?php echo ($dataPos*86); ?>px;" class="line listItem " id="<?php echo $ticket->id(); ?>">
		<div class="unit flags">
			<?php //echo $i; ?>&nbsp;
			<?php //echo $i + ($offset*30); ?>
		</div>
		<div class="lastUnit">
			<div class="line" style="height:21px;">
				<div class="unit size3of4 from">
					<?php echo $ticket->getFrom(); ?>
				</div>
				<div class="lastUnit txtR blue">
					<?php if($ticket->getRecentEmail()!==null):?>
					<?php echo NTime::niceShorter($ticket->getRecentEmail()->date, 'faded'); ?>
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