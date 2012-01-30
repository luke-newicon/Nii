<table id="timesheet-grid" class="condensed-table bordered-table zebra-striped">
	<thead>
		<tr>
			<th>Task Description</th>
			<th>Mon</th>
			<th>Tue</th>
			<th>Wed</th>
			<th>Thu</th>
			<th>Fri</th>
			<th>Sat</th>
			<th>Sun</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php if($timesheet->records): foreach($timesheet->records as $record): ?>
			<?php $this->renderPartial('_row',array('record' => $record)) ?>
		<?php endforeach;endif; ?>
		<tr id="record-add-row">
			<td colspan="9"><a id="record-add" href="#" class="icon fam-add">Add a record</a></td>
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