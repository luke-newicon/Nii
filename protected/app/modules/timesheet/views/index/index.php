<div class="page-header">
	<h2><?php echo $this->t('Timesheets') ?></h2>
	<div class="action-buttons">
		<a class="btn" href="#">Submit</a>
	</div>
</div>

<?php $this->renderPartial('_timesheet',array('weekLog'=>$weekLog)); ?>