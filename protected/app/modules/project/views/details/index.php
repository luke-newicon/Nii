<div class="page-header">
	<h2><?php echo $model->name ?></h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Back to Projects'), array("index"),array('class'=>'btn'));?>
	</div>
</div>


<h3>Time logs</h3>
<div class="timelogs">
	
	<?php $mins = Yii::app()->getModule('timesheet')->getTotalProjectMinutes($model->id); ?>
	<p><strong>Total time:<?php echo NTime::minutesToTime($mins); ?></strong></p>
	
	<p><strong><?php echo NTime::minutesToDaysNice($mins); ?></strong></p>
	
	
	<?php foreach(Yii::app()->getModule('timesheet')->getProjectTimeLogs($model->id) as $log): ?>
		<?php echo NTime::minutesToTime($log->minutes); ?>
	<?php endforeach; ?>
</div>