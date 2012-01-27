<table class="condensed-table bordered-table zebra-striped">
	<thead>
		<tr>
			<th>Task</th>
			<th>Monday</th>
			<th>Tuesday</th>
			<th>Wednesday</th>
			<th>Thursday</th>
			<th>Friday</th>
			<th>Saturday</th>
			<th>Sunday</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($timesheet->records as $record): ?>
		<tr>
			<td>Project</td>
			<td><input type="text" value="<?php echo $record->time_monday; ?>"/></td>
			<td><input type="text" value="<?php echo $record->time_tuesday; ?>"/></td>
			<td><input type="text" value="<?php echo $record->time_wednesday; ?>"/></td>
			<td><input type="text" value="<?php echo $record->time_thursday; ?>"/></td>
			<td><input type="text" value="<?php echo $record->time_friday; ?>"/></td>
			<td><input type="text" value="<?php echo $record->time_saturday; ?>"/></td>
			<td><input type="text" value="<?php echo $record->time_sunday; ?>"/></td>
			<td>
				<a href="<?php echo NHtml::url(array('/timesheet/timesheet/delete','id'=>$record->id))?>" class="icon fam-delete" data-confirm="Are you sure you want to delete this task?"></a>
			</td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td colspan="9"><a href="#" class="icon fam-add">Add a task</a></td>
		</tr>
	</tbody>
</table>