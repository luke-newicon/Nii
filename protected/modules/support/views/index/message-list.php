<?php
/**
 * Displays the list of of messages
 */
?>
<?php foreach($emails as $i => $email): ?>
	<?php $dataPos = $i + ($offset*$limit); ?>
	<?php $bg = ($i == ($limit-1)) ? 'background-color:#ff0000;':''; ?>
	
	<div data-id="<?php echo $email->id(); ?>" data-position="<?php echo $dataPos; ?>" style="<?php echo $bg; ?>position:absolute;top:<?php echo ($dataPos*86); ?>px;" class="line listItem">
		<div class="unit flags">
			<?php $icon = ($email->opened) ?'':'icon fam-email'; ?>
			<span data-role="flag-opened" class="<?php echo $icon; ?>">&nbsp;</span>
		</div>
		<div class="lastUnit">
			<div class="line" style="height:21px;">
				<div class="unit size3of4 from">
					<?php echo $email->getFrom(); ?>
				</div>
				<div class="lastUnit txtR blue">
					<?php echo NTime::niceShorter($email->date, 'faded'); ?>
				</div>
			</div>
			<div class="subject">
				<?php echo $email->subject .'<br/>' ?>
			</div>
			<div class="body faded">
				<?php echo $email->getPreviewText(); ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>