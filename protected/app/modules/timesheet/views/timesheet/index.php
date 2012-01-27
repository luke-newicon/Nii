<div class="page-header">
	<h2><?php echo $this->t('Timesheets') ?></h2>
	<div class="action-buttons">
		<a href="#" class="week-selector dropdown-toggle">
			<h3>Week 12</h3>
		</a>
<!--		<a class="btn" href="#">Submit</a>-->
	</div>
</div>
<?php $this->renderPartial('_timesheet',array('weekLog'=>$weekLog)); ?>