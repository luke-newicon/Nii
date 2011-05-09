<div class="line note">
	<?php if($this->displayUserPic): ?>
		<div class="unit profilePic">
			<img src="<?php echo $profilePic ?>"/>
		</div>
	<?php endif; ?>
	<div class="unit userInformation">
		<p><?php echo Ntime::timeAgoInWordsShort($line['added']) ?></p>
		<p><?php echo $line['username'] ?></p>
	</div>
	<div class="unit note">
		<?php
		$markdown = new NMarkdown();
		echo $markdown->transform($line['note']); ?>
	</div>
	<div class="unit lastUnit buttons">
		<p style="display:none">Edit</p>
		<p style="display:none">Delete</p>
	</div>
</div>