<?php foreach (Yii::app()->user->getFlashes() as $key => $message): ?>
<?php if ($key == 'counters') continue; ?>
	<div class="flash-<?php echo $key ?>"><?php echo $message; ?></div>
<?php endforeach; ?>