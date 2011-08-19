<style>
	.note p {margin:0px;}
</style>

<div class="line note note<?php echo $data->id; ?>" data-noteId="<?php echo $data->id; ?>">
	<?php if($displayUserPic):?>
		<div class="unit profilePic">
			<?php User::model()->getProfileImage($data->user_id);?>
		</div>
	<?php endif;?>
	<p class="userInformation">
			<?php if ($data->username) : ?>
				<?php echo $data->username; ?>
			<?php else : ?>
				Guest
			<?php endif; ?>
			, <?php echo NTime::timeAgoInWordsShort($data->added);?>
	</p>
	<div class="note" style="display: block;line-height: 1em;">
		<?php
		$markdown = new NMarkdown();
		echo $markdown->transform($data->note);?>
	</div>
	<div style="font-size: 10px; height: 15px;">
		<div class="nnote-controls" style="display:none;">
			<?php if($canEdit):?>
				<a href="#" class="nnote-edit">Edit<a/>
				<a href="#" class="nnote-cencel" style="display:none;">Cancel Edit<a/>
			<?php endif; ?>
			<?php if($canEdit && $canDelete):?>
				| 
			 <?php endif;?>
			 <?php if($canDelete):?>
				<a href="#" class="nnote-delete">Delete</a>
			<?php endif; ?>
		</div>
	</div>
</div>