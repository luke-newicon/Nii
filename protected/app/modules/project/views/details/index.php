<div class="page-header">
	<h2><?php echo $model->name ?></h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Back to Projects'), array("index"),array('class'=>'btn'));?>
	</div>
</div>


<h3>Time logs</h3>
<div class="timelogs">
	
	<?php $mins = Yii::app()->getModule('timesheet')->getTotalProjectMinutes($model->id); ?>
	<?php echo '<strong>Total time: ' . NTime::minutesToTime($mins) . '</strong>'; ?>
</div>