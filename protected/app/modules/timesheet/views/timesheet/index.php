<div class="page-header">
	<h2><?php echo $this->t('Timesheets') ?></h2>
</div>

<?php $this->renderPartial('_timesheet',array('startDate'=>$startDate, 'logs'=>$logs)); ?>