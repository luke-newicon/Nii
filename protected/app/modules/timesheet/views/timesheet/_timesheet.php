<table id="timesheet-grid" class="condensed-table bordered-table zebra-striped">
	<thead>
		<tr>
			<th class="project-column">Project</th>
			<th class="task-column">Task</th>
			<th class="hour_units mon-column">Mon</th>
			<th class="hour_units tue-column">Tue</th>
			<th class="hour_units wed-column">Wed</th>
			<th class="hour_units thu-column">Thu</th>
			<th class="hour_units fri-column">Fri</th>
			<th class="hour_units sat-column">Sat</th>
			<th class="hour_units sun-column">Sun</th>
			<th class="delete-column"></th>
		</tr>
	</thead>
	<tfoot>
		<tr id="timesheet-totals">
			<th colspan="2"></th>
			<th class="hour_units mon-column">0</th>
			<th class="hour_units tue-column">0</th>
			<th class="hour_units wed-column">0</th>
			<th class="hour_units thu-column">0</th>
			<th class="hour_units fri-column">0</th>
			<th class="hour_units sat-column">0</th>
			<th class="hour_units sun-column">0</th>
			<th></th>
		</tr>
	</tfoot>
	<tbody>
		<?php if($timesheet->records): foreach($timesheet->records as $record): ?>
			<?php $this->renderPartial('_row',array('record' => $record)) ?>
		<?php endforeach;endif; ?>
		<tr id="record-add-row">
			<td>
				<div class="input">
					<select>
						<option>Select a Project</option>
					</select>
				</div>
			</td>
			<td>
				<div class="input">
					<select>
						<option>Select a Task</option>
					</select>
				</div>
			</td>
			<td class="hour_units mon-column"><input type="text" value="<?php echo $record->time_monday; ?>" maxlength="2" /></td>
			<td class="hour_units tue-column"><input type="text" value="<?php echo $record->time_tuesday; ?>" maxlength="2" /></td>
			<td class="hour_units wed-column"><input type="text" value="<?php echo $record->time_wednesday; ?>" maxlength="2" /></td>
			<td class="hour_units thu-column"><input type="text" value="<?php echo $record->time_thursday; ?>" maxlength="2" /></td>
			<td class="hour_units fri-column"><input type="text" value="<?php echo $record->time_friday; ?>" maxlength="2" /></td>
			<td class="hour_units sat-column"><input type="text" value="<?php echo $record->time_saturday; ?>" maxlength="2" /></td>
			<td class="hour_units sun-column"><input type="text" value="<?php echo $record->time_sunday; ?>" maxlength="2" /></td>
			<td class="add-column">
				<a id="record-add" href="#" class="icon fam-add"></a>
			</td>
		</tr>
	</tbody>
</table>
<script>
	jQuery(function($){
		$('#record-add').click(function(){
			$.ajax({
				url: '<?php echo NHtml::url(array('/timesheet/timesheet/add','timesheet'=>$timesheet->id)) ?>',
				success: function(msg){
					$('#record-add-row').before(msg);
				}
			});
			return false;
		});
	});
</script>