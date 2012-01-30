<tr>
	<td class="project-column">Project</td>
	<td class="task-column">Task</td>
	<td class="hour_units mon-column"><input type="text" value="<?php echo $record->time_monday; ?>" maxlength="2" /></td>
	<td class="hour_units tue-column"><input type="text" value="<?php echo $record->time_tuesday; ?>" maxlength="2" /></td>
	<td class="hour_units wed-column"><input type="text" value="<?php echo $record->time_wednesday; ?>" maxlength="2" /></td>
	<td class="hour_units thu-column"><input type="text" value="<?php echo $record->time_thursday; ?>" maxlength="2" /></td>
	<td class="hour_units fri-column"><input type="text" value="<?php echo $record->time_friday; ?>" maxlength="2" /></td>
	<td class="hour_units sat-column"><input type="text" value="<?php echo $record->time_saturday; ?>" maxlength="2" /></td>
	<td class="hour_units sun-column"><input type="text" value="<?php echo $record->time_sunday; ?>" maxlength="2" /></td>
	<td class="delete-column">
		<a href="<?php echo NHtml::url(array('/timesheet/timesheet/delete','id'=>$record->id))?>" class="icon fam-delete" data-confirm="Are you sure you want to delete this task?"></a>
	</td>
</tr>