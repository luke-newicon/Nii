<?php
/**
 * Displays the list of of messages
 */
?>

<?php for($i=$offset; $i < ($offset+$limit); $i++): ?>
	<?php $dataPos = $i; ?>
	<?php $container = $threads[$i]; ?>
	<?php $email = $container->getEmail(); ?>
	<?php $bg = ($i == ($limit-1)) ? 'background-color:#ff0000;':''; ?>
	<?php $email = $container->getEmail(); ?>
	<div data-id="<?php echo $container->getLookupId(); ?>" data-position="<?php echo $dataPos; ?>" style="<?php echo $bg; ?>position:absolute;top:<?php echo ($dataPos*86); ?>px;" class="line listItem ">
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
			<div class="line">
				<div class="unit size11of12">
					<div class="subject">
						<?php echo $email->subject .'<br/>' ?>
					</div>
					<div class="body faded">
						<?php echo $email->getPreviewText(); ?>
					</div>
				</div>
				<div class="lastUnit txtC">
					<?php if($container->msgCount() > 1): ?>
					<span class="threadNumber"><?php echo $container->msgCount(); ?></span>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endfor; ?>