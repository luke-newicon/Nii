<div class="line field mts mrs mbn mls" style="border:1px solid #ccc;background-color:#f9f9f9;"">
	<div class="unit prs"><?php $this->widget('nii.widgets.Gravatar',array('email'=>$comment->email)); ?></div>
	<div class="lastUnit">
		<div class="username"><?php echo $comment->username; ?></div>
		<?php echo $this->getMarkdown()->transform($comment->comment); ?>
		<div class="stats"><?php echo NTime::timeAgoInWordsShort($comment->time); ?></div>
	</div>
</div>