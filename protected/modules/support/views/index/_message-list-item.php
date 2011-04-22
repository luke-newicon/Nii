<div data-id="<?php echo $email->id(); ?>" data-position="<?php echo $dataPos; ?>" style="" class="line listItem">
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