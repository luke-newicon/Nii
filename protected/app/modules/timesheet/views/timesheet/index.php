<div class="page-header">
	<h2><?php echo $this->t('Timesheets') ?></h2>
	<div class="action-buttons">
		<div class="input" style="font-size:15px">
			<select>
				<option>Week 12</option>
			</select>
		</div>
	</div>
</div>
<?php $this->renderPartial('_timesheet',array('timesheet'=>$timesheet)); ?>