<style>
	.sdate{font-size:11px;font-weight:normal;white-space: nowrap;}
</style>
<div id="timesheet-selector" class="line">
	<div class="unit size1of3 txtR">
		<a class="btn prev-month small">&lt;&lt;</a><a class="btn prev-week small">&lt;</a> 
	</div>
	<div class="unit size1of3 txtC">
		<span class="date-start">2 January</span> - <span class="date-end">9 January, 2012</span> 
	</div>
	<div class="lastUnit txtL">
		<a class="btn next-week small">&gt;</a><a class="btn next-month small">&gt;&gt;</a> 
	</div>
</div>

<table id="timesheet-grid" class="condensed-table bordered-table zebra-striped">
	<thead>
		<tr class="date-headings">
			<th class="project-col">Project</th>
			<th class="task-col">Task</th>
			<th class="hour_units mon-col">Mon<br/><span class="sdate">30 Jan</span></th>
			<th class="hour_units tue-col">Tue<br/><span class="sdate">30 Jan</span></th>
			<th class="hour_units wed-col">Wed<br/><span class="sdate">30 Jan</span></th>
			<th class="hour_units thu-col">Thu<br/><span class="sdate">30 Jan</span></th>
			<th class="hour_units fri-col">Fri<br/><span class="sdate">30 Jan</span></th>
			<th class="hour_units sat-col">Sat<br/><span class="sdate">30 Jan</span></th>
			<th class="hour_units sun-col">Sun<br/><span class="sdate">30 Jan</span></th>
			<th class="hour_units total-col">Total</th>
			<th class="delete-col"></th>
		</tr>
	</thead>
	<tfoot>
		<tr id="timesheet-totals">
			<th colspan="2"></th>
			<th class="hour_units mon-col">0:00</th>
			<th class="hour_units tue-col">0:00</th>
			<th class="hour_units wed-col">0:00</th>
			<th class="hour_units thu-col">0:00</th>
			<th class="hour_units fri-col">0:00</th>
			<th class="hour_units sat-col">0:00</th>
			<th class="hour_units sun-col">0:00</th>
			<th class="hour_units total-col">0:00</th>
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
			<td class="hour_units mon-col"><input type="text" value="<?php echo $record->time_monday; ?>" maxlength="4" /></td>
			<td class="hour_units tue-col"><input type="text" value="<?php echo $record->time_tuesday; ?>" maxlength="4" /></td>
			<td class="hour_units wed-col"><input type="text" value="<?php echo $record->time_wednesday; ?>" maxlength="4" /></td>
			<td class="hour_units thu-col"><input type="text" value="<?php echo $record->time_thursday; ?>" maxlength="4" /></td>
			<td class="hour_units fri-col"><input type="text" value="<?php echo $record->time_friday; ?>" maxlength="4" /></td>
			<td class="hour_units sat-col"><input type="text" value="<?php echo $record->time_saturday; ?>" maxlength="4" /></td>
			<td class="hour_units sun-col"><input type="text" value="<?php echo $record->time_sunday; ?>" maxlength="4" /></td>
			<td class="hour_units total-col">0:00</td>
			<td class="add-col">
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
		
		
		
		var doTotal = function(el, elTotal){
			var total=0;
			el.each(function(){
				var val = $(this).is('input') ? $(this).val() : $(this).text();
				var num = parseFloat(val);
				if(_.isNaN(num))num = 0;
				total = total + num;
			});
			elTotal.html(total.toFixed(2));
		}
		
		$(':input').bind('blur change',function(){
			// update totals
			// cols first
			doTotal($('.mon-col input'), $('#timesheet-totals .mon-col'));
			doTotal($('.tue-col input'), $('#timesheet-totals .tue-col'));
			doTotal($('.wed-col input'), $('#timesheet-totals .wed-col'));
			doTotal($('.thu-col input'), $('#timesheet-totals .thu-col'));
			doTotal($('.fri-col input'), $('#timesheet-totals .fri-col'));
			doTotal($('.sat-col input'), $('#timesheet-totals .sat-col'));
			doTotal($('.sun-col input'), $('#timesheet-totals .sun-col'));
			
			// update rows
			$('#timesheet-grid tbody tr').each(function(){
				doTotal($(this).find('input'), $(this).find('.total-col'))
			});
			
			// update main total
			doTotal($('#timesheet-grid tbody .total-col'), $('#timesheet-grid tfoot .total-col'));
			
		})
		
		var CTimesheet = Backbone.View.extend({
			el:$('#timesheet-selector'),
			startDate:null,
			endDate:null,
			months:null,
			msWeek:604800000, 
			msDay:86400000,
			events:{
				'click .prev-week':'prevWeek',
				'click .next-week':'nextWeek',
				'click .prev-month':'prevMonth',
				'click .next-month':'nextMonth'
			},
			initialize:function(){
				var d = new Date();
				d.setFullYear(2012,0,30);
				this.startDate = d;
				this.months = Array();
				this.months[this.months.length] = 'January';
				this.months[this.months.length] = 'Febuary';
				this.months[this.months.length] = 'March';
				this.months[this.months.length] = 'April';
				this.months[this.months.length] = 'May';
				this.months[this.months.length] = 'June';
				this.months[this.months.length] = 'July';
				this.months[this.months.length] = 'August';
				this.months[this.months.length] = 'September';
				this.months[this.months.length] = 'October';
				this.months[this.months.length] = 'November';
				this.months[this.months.length] = 'December';
				this.render();
			},
			render:function(){
				var time = this.startDate.getTime();
				var mon = this.startDate;
				var tue = new Date(time+this.msDay);
				var wed = new Date(time+this.msDay*2);
				var thu = new Date(time+this.msDay*3);
				var fri = new Date(time+this.msDay*4);
				var sat = new Date(time+this.msDay*5);
				var sun = new Date(time+(this.msDay*6));
				
				this.$('.date-start').html(mon.getDate()+' '+this.month(mon));
				this.$('.date-end').html(sun.getDate()+' '+this.month(sun) + ', ' + sun.getFullYear());
				
				// update displayed timesheet table dates
				$('.date-headings .mon-col .sdate').html(mon.getDate()+' '+this.monthShort(mon));
				$('.date-headings .tue-col .sdate').html(tue.getDate()+' '+this.monthShort(tue));
				$('.date-headings .wed-col .sdate').html(wed.getDate()+' '+this.monthShort(wed));
				$('.date-headings .thu-col .sdate').html(thu.getDate()+' '+this.monthShort(thu));
				$('.date-headings .fri-col .sdate').html(fri.getDate()+' '+this.monthShort(fri));
				$('.date-headings .sat-col .sdate').html(sat.getDate()+' '+this.monthShort(sat));
				$('.date-headings .sun-col .sdate').html(sun.getDate()+' '+this.monthShort(sun));
			},
			month:function(d){
				return this.months[d.getMonth()];
			},
			monthShort:function(d){
				return this.month(d).substring(0,3);
			},
			prevWeek:function(){
				this.startDate = new Date(this.startDate.getTime() - this.msWeek);
				this.render();
			},
			nextWeek:function(){
				this.startDate = new Date(this.startDate.getTime() + this.msWeek);
				this.render();
			},
			nextMonth:function(){
				this.startDate = new Date(this.startDate.getTime() + this.msWeek * 4);
				this.render();
			},
			prevMonth:function(){
				this.startDate = new Date(this.startDate.getTime() - this.msWeek * 4);
				this.render();
			}
		});
		
		window.timesheet = new CTimesheet();
		
		
	});


</script>

