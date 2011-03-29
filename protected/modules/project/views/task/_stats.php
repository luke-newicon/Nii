<?php if (count($taskTimeOverview) > 0): ?>

    <h2 style="text-align: center;">Total Recorded Time: <?php echo $task->getRecordedTime(); ?></h2>
    <div class="time_stats">
        <table>
	<?php foreach ($taskTimeOverview as $tests): ?>
	<?php if ($tests->recorded_time): ?>
	        <tr>
		    <td class="label"><?php echo $tests->name ?></td>
		    <td class="value"> <?php echo$tests->recorded_time ?></td>
	        </tr>	
	<?php endif; ?>
	<?php endforeach; ?>
	    </table>
	</div>
<?php else: ?>
    <h3 style="text-align: center; padding-top: 8px;">No time recorded against this task</h3>
<?php endif; ?>