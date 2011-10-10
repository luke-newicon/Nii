<?php foreach (Yii::app()->user->getFlashes() as $key => $message): ?>
<?php if ($key == 'counters') continue; ?>
	<p class="alert-message <?php echo $key ?>"><?php echo $message; ?></p>
<?php endforeach; ?>