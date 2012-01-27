<table class="condensed-table bordered-table zebra-striped">
	<thead>
		<tr>
			<th>Task</th>
			<th>Mon</th>
			<th>T</th>
			<th>W</th>
			<th>T</th>
			<th>F</th>
			<th>S</th>
			<th>S</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($weekLog as $log):?>
			<?php foreach($log->timesheetTimerecords as $record): ?>
			<tr>
				<td>Griggs Updates</td>
				<td><input type="text" value="<?php echo $record->time_monday; ?>"/></td>
				<td><input type="text" value="<?php echo $record->time_tuesday; ?>"/></td>
				<td><input type="text" value="<?php echo $record->time_wednesday; ?>"/></td>
				<td><input type="text" value="<?php echo $record->time_thursday; ?>"/></td>
				<td><input type="text" value="<?php echo $record->time_friday; ?>"/></td>
				<td><input type="text" value="<?php echo $record->time_saturday; ?>"/></td>
				<td><input type="text" value="<?php echo $record->time_sunday; ?>"/></td>
				<td><a href="#" class="icon fam-delete" data-confirm="Are you sure you want to delete this task?"></a></td>
			</tr>
			<?php endforeach;?>
		<?php endforeach;?>
		<tr>
			<td colspan="9"><a href="#" class="icon fam-add">Add a task</a></td>
		</tr>
	</tbody>
</table>