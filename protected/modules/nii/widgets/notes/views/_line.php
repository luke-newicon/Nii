<style>
	.note p {margin:0px;}
</style>

<div class="line note">
	<?php if($displayUserPic):?>
		<div class="unit profilePic">
			<img width="50" src="<?php //echo $profilePic;?>"/>
		</div>
	<?php endif;?>
	<p class="userInformation">
			<?php if($data->username):?>
				<?php echo $data->username;?>
			<?php else:?>
				Guest
			<?php endif;?>
			, <?php echo NTime::timeAgoInWordsShort($data->added);?>
	</p>
	<div class="note" style="display: block;line-height: 1em;">
		<?php
		$markdown = new NMarkdown();
		echo $markdown->transform($data->note);?>
	</div>
	<div style="display: block; font-size: 10px; line-height: 1em; margin: 4px 0px;">
		<?php if($canEdit):?>
			<a href="#">Edit<a/>
		<?php endif; ?>
		<?php if($canEdit && $canDelete):?>
			| 
		 <?php endif;?>
		 <?php if($canDelete):?>
			<a href="#">Delete</a>
		<?php endif; ?>
	</div>
	<div class="unit lastUnit buttons">
		<p style="display:none">Edit</p>
		<p style="display:none">Delete</p>
	</div>
</div>