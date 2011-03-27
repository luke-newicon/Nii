<h3 style="text-align: center; padding-top: 8px;">Total Recorded Time: <?php echo $project->getRecordedTime() ?></h3>
<div class="line time_stats">
    <div class="unit size1of2">
	<h5>Task Types</h5>
	<table>
	    <?php foreach ($project->timeOverviewTimeType() as $overviewTimeType): ?>
    	    <tr>
    		<td class="label"><?php echo $overviewTimeType->name ?></td>
    		<td class="value"><?php echo $overviewTimeType->recorded_time ?></td>
    	    </tr>
	    <?php endforeach; ?>
    	</table>
        </div>
        <div class="unit size1of2 lastUnit">
    	<h5>Time Types</h5>
    	<table>
	    <?php foreach ($project->timeOverviewTaskType() as $overviewTaskType): ?>
		    <tr>
			<td class="label"><?php echo $task->getType($overviewTaskType->type) ?></td>
			<td class="value"><?php echo $overviewTaskType->recorded_time ?></td>
		    </tr>
	    <?php endforeach; ?>
	</table>
    </div>
</div>

