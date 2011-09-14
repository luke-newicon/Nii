<style>
	.note p {margin:0px;}
</style>

<div class="line note note<?php echo $data->id; ?>" data-noteId="<?php echo $data->id; ?>">
	<?php if($displayUserPic):?>
		<div class="unit profilePic prm">
			<?php User::model()->getProfileImage($data->user_id);?>
		</div>
	<?php endif;?>
	<div class="lastUnit">
		<div class="nnote-text">
		<?php
		$markdown = new NMarkdown();
		echo $markdown->transform($data->note);?>
		</div>
		
		<p class="hint">
			<?php echo User::model()->getName($data->user_id); ?>
			, <?php echo NTime::timeAgoInWordsShort($data->added);?>
		</p>
		<div style="height:10px;">
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
</div>