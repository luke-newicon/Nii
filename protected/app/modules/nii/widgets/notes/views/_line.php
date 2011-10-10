<div class="line note">
	<?php if($this->displayUserPic): ?>
		<div class="unit profilePic">
			<img width="50" src="<?php echo $profilePic ?>"/>
		</div>
	<?php endif; ?>
	<div class="unit userInformation">
		
	</div>
	<div class="unit note">
		<?php
		$markdown = new NMarkdown();
		echo $markdown->transform($line['note']); ?>
		<p class="userInformation"><?php echo $line['username'] ?> - <?php echo NTime::timeAgoInWordsShort($line['added']) ?></p>
	</div>
	<div class="unit lastUnit buttons">
		<p style="display:none">Edit</p>
		<p style="display:none">Delete</p>
	</div>
</div>