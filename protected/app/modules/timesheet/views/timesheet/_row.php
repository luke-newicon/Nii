<tr>
	<td class="project-col">Project</td>
	<td class="task-col">Task</td>
	<td class="hour_units mon-col"><input type="text" value="<?php echo $record->time_monday; ?>" maxlength="4" /></td>
	<td class="hour_units tue-col"><input type="text" value="<?php echo $record->time_tuesday; ?>" maxlength="4" /></td>
	<td class="hour_units wed-col"><input type="text" value="<?php echo $record->time_wednesday; ?>" maxlength="4" /></td>
	<td class="hour_units thu-col"><input type="text" value="<?php echo $record->time_thursday; ?>" maxlength="4" /></td>
	<td class="hour_units fri-col"><input type="text" value="<?php echo $record->time_friday; ?>" maxlength="4" /></td>
	<td class="hour_units sat-col"><input type="text" value="<?php echo $record->time_saturday; ?>" maxlength="4" /></td>
	<td class="hour_units sun-col"><input type="text" value="<?php echo $record->time_sunday; ?>" maxlength="4" /></td>
	<td class="hour_units total-col">0:00</td>
	<td class="delete-col">
		<a href="<?php echo NHtml::url(array('/timesheet/timesheet/delete','id'=>$record->id))?>" class="icon fam-delete" data-confirm="Are you sure you want to delete this task?"></a>
	</td>
</tr>