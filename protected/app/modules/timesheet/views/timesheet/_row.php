<tr>
	<td>Project</td>
	<td class="hour_units"><input type="text" value="<?php echo $record->time_monday; ?>"/></td>
	<td class="hour_units"><input type="text" value="<?php echo $record->time_tuesday; ?>"/></td>
	<td class="hour_units"><input type="text" value="<?php echo $record->time_wednesday; ?>"/></td>
	<td class="hour_units"><input type="text" value="<?php echo $record->time_thursday; ?>"/></td>
	<td class="hour_units"><input type="text" value="<?php echo $record->time_friday; ?>"/></td>
	<td class="hour_units"><input type="text" value="<?php echo $record->time_saturday; ?>"/></td>
	<td class="hour_units"><input type="text" value="<?php echo $record->time_sunday; ?>"/></td>
	<td>
		<a href="<?php echo NHtml::url(array('/timesheet/timesheet/delete','id'=>$record->id))?>" class="icon fam-delete" data-confirm="Are you sure you want to delete this task?"></a>
	</td>
</tr>