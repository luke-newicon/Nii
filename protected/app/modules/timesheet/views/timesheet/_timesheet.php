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
		<a class="btn primary addLog">Add Log</a>
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
	</tbody>
</table>
<a class="btn primary">Save Log</a>



<script type="text/template" id="time-log-row-template">
	<td>
		Project <%= project_id %>
	</td>
	<td>
		Task <%= task_id %>
	</td>
	<td class="hour_units mon-col"><input name="time[<%= row %>][]" value="<%= mon %>" type="text"  maxlength="4" /></td>
	<td class="hour_units tue-col"><input name="time[<%= row %>][]" value="<%= tue %>" type="text"  maxlength="4" /></td>
	<td class="hour_units wed-col"><input name="time[<%= row %>][]" value="<%= wed %>" type="text"  maxlength="4" /></td>
	<td class="hour_units thu-col"><input name="time[<%= row %>][]" value="<%= thu %>" type="text"  maxlength="4" /></td>
	<td class="hour_units fri-col"><input name="time[<%= row %>][]" value="<%= fri %>" type="text"  maxlength="4" /></td>
	<td class="hour_units sat-col"><input name="time[<%= row %>][]" value="<%= sat %>" type="text"  maxlength="4" /></td>
	<td class="hour_units sun-col"><input name="time[<%= row %>][]" value="<%= sun %>" type="text"  maxlength="4" /></td>
	<td class="hour_units total-col">0:00</td>
	<td class="delete-col">
		<a id="record-delete" href="#" class="icon fam-delete"></a>
	</td>
</script>


<script type="text/template" id="time-log-row-add-template">
	<td>
		Project <%= project_id %>
	</td>
	<td>
		<div class="field mbn">
			<label class="inFieldLabel" for="task_<%= row %>">Task</label>
			<div class="input">
				<input name="task[<%= row %>]" id="task_<%= row %>" type="text" />
			</div>
		</div>
	</td>
	<td class="hour_units mon-col"><input name="time[<%= row %>][]" value="<%= mon %>" type="text"  maxlength="4" /></td>
	<td class="hour_units tue-col"><input name="time[<%= row %>][]" value="<%= tue %>" type="text"  maxlength="4" /></td>
	<td class="hour_units wed-col"><input name="time[<%= row %>][]" value="<%= wed %>" type="text"  maxlength="4" /></td>
	<td class="hour_units thu-col"><input name="time[<%= row %>][]" value="<%= thu %>" type="text"  maxlength="4" /></td>
	<td class="hour_units fri-col"><input name="time[<%= row %>][]" value="<%= fri %>" type="text"  maxlength="4" /></td>
	<td class="hour_units sat-col"><input name="time[<%= row %>][]" value="<%= sat %>" type="text"  maxlength="4" /></td>
	<td class="hour_units sun-col"><input name="time[<%= row %>][]" value="<%= sun %>" type="text"  maxlength="4" /></td>
	<td class="hour_units total-col">0:00</td>
	<td class="delete-col">
		<a id="record-delete" href="#" class="icon fam-delete"></a>
	</td>
</script>

<script type="text/javascript">
	
	
	
	jQuery(function($){
		
		window.timesheet = {
			// can be set to hours or minutes
			logTimeIn:'hours',
			// calendar view
			cal:{},
			// model storing the start and end dates for timesheet week
			week:{},
			timeLogList:{},
			/**
			 * Init the timesheet app
			 * start time is the unix epoch time in seconds (equivelent to PHP's)
			 * note: javascripts unix time is in milliseconds so multiply by 1000
			 * this function is only called once, to set the date after init use the time model directly
			 */
			init:function(startTime){
				// javascript unix epoch is in milliseconds multiple by 1000
				var d = new Date(parseInt(startTime)*1000);
				this.week = new CTimesheetWeek();
				this.cal = new CTimesheetCal({model:this.week});
				// start the ball rolling
				this.week.set({startDate:d});
				
				this.timeLogList = new CTimeLogCollection;
				this.timeLogRows = new CTimeLogRows({collection:this.timeLogList});
				
				
				this.timeLogList.reset(<?php echo $logs; ?>)
				
			},
			dateToMysql:function(date){
				return date.getFullYear() + '-' +
					(date.getMonth() < 9 ? '0' : '') + (date.getMonth()+1) + '-' +
					(date.getDate() < 10 ? '0' : '') + date.getDate();
			}
		}
		
		
		var CTimeLog = Backbone.Model.extend({
			defaults:{
				row:0,
				project_id:0,
				task_id:0,
				mon:'',
				tue:'',
				wed:'',
				thu:'',
				fri:'',
				sat:'',
				sun:''
			}
		});
		
		var CTimeLogCollection = Backbone.Collection.extend({
			url:function(){
				return '<?php echo NHtml::url("/timesheet/timesheet/weeklog/") ?>'
			},
			model:CTimeLog,
			getProjects:function(){
				return this.groupBy(function(m){
					return m.get('project_id') + m.get('task_id');
				})
			},
			fetchLogsFor:function(date){
				this.fetch({data: $.param({ date: window.timesheet.dateToMysql(date)}) });
			}
		})
		
		var CTimesheetWeek = Backbone.Model.extend({
			defaults:{
				startDate:null
			}
		});
			
			
		/**
		 * parent view to create table rows
		 */
		var CTimeLogRows = Backbone.View.extend({
			el:$('#timesheet-grid tbody'),
			initialize:function(){
				this.collection.bind('reset', this.render, this);
			},
			render:function(){
				this.el.html('');
				_.each(this.collection.getProjects(),function(row){
					var row = new CTimeLogRow({collection:row});
					this.el.append(row.render().el)
				}, this)
				
				
				this.addRowForm();
				
				// update totals
				$(':input').bind('blur change',_.bind(this.doTotals,this));
				this.doTotals();
			},
			doTotals:function(){
				// cols first
				this.doTotal($('#timesheet-grid .mon-col input'), $('#timesheet-totals .mon-col'));
				this.doTotal($('#timesheet-grid .tue-col input'), $('#timesheet-totals .tue-col'));
				this.doTotal($('#timesheet-grid .wed-col input'), $('#timesheet-totals .wed-col'));
				this.doTotal($('#timesheet-grid .thu-col input'), $('#timesheet-totals .thu-col'));
				this.doTotal($('#timesheet-grid .fri-col input'), $('#timesheet-totals .fri-col'));
				this.doTotal($('#timesheet-grid .sat-col input'), $('#timesheet-totals .sat-col'));
				this.doTotal($('#timesheet-grid .sun-col input'), $('#timesheet-totals .sun-col'));

				// update rows
				$('#timesheet-grid tbody tr').each(function(){
					window.timesheet.timeLogRows.doTotal($(this).find('input'), $(this).find('.total-col'));
				});

				// update main total
				this.doTotal($('#timesheet-grid tbody .total-col'), $('#timesheet-grid tfoot .total-col'));
			},
			// count totals and update elements
			doTotal:function(el, elTotal){
				var total=0;
				el.each(function(){
					var val = $(this).is('input') ? $(this).val() : $(this).text();
					var num = parseFloat(val);
					if(_.isNaN(num))num = 0;
					total = total + num;
				});
				elTotal.html(total.toFixed(2));
			},
			addRowForm:function(){
				var form = new CTimeLogRowAdd();
				this.el.append(form.render().el);
			}
		});
		
		
		var CTimeLogRowAdd = Backbone.View.extend({
			tagName:'tr',
			template:_.template($('#time-log-row-add-template').html()),
			events:{
				'click .delete-col':'deleteRow'
			},
			initialize:function(){
				this.model = new CTimeLog;
			},
			render:function(){
				this.model.set({row:$('#timesheet-grid tbody tr').length});
				$(this.el).html(this.template(this.model.toJSON()));
				$.fn.nii.form();
				return this;
			},
			deleteRow:function(){
				this.remove();
			}
		});
		
		/**
		 * view for each unique row project_id and task_id 
		 */
		var CTimeLogRow = Backbone.View.extend({
			tagName:'tr',
			template:_.template($('#time-log-row-template').html()),
			render:function(){
				var model = {};
				model.project_id = this.collection[0].get('project_id');
				model.task_id = this.collection[0].get('task_id');
				model.row = $('#timesheet-grid tbody tr').length;
				model.mon = this.sumDayLogs(window.timesheet.cal.mon);
				model.tue = this.sumDayLogs(window.timesheet.cal.tue);
				model.wed = this.sumDayLogs(window.timesheet.cal.wed);
				model.thu = this.sumDayLogs(window.timesheet.cal.thu);
				model.fri = this.sumDayLogs(window.timesheet.cal.fri);
				model.sat = this.sumDayLogs(window.timesheet.cal.sat);
				model.sun = this.sumDayLogs(window.timesheet.cal.sun);
				$(this.el).html(this.template(model));
				return this;
			},
			// date as javascript unix epoch
			sumDayLogs:function(date){
				var logs = _.filter(this.collection, function(log){
					return log.get('date').substring(0,10) == window.timesheet.dateToMysql(date).substring(0,10);
				}, this)
				var mins = 0;
				if(logs.length > 0){
					_.each(logs, function(l){
						mins = mins + parseInt(l.get('minutes'));
					}, this);
				}
				
				if(window.timesheet.logTimeIn == 'hours'){
					mins = mins / 60;
					mins = mins.toFixed(2);
				}
				
				return (mins==0) ? '' : mins;
			}
		})
		
		// timesheet 
		var CTimesheetCal = Backbone.View.extend({
			el:$('#timesheet-selector'),
			months:null,
			msWeek:604800000, 
			msDay:86400000,
			mon:null,tue:null,wed:null,thu:null,fri:null,sat:null,sun:null,
			events:{
				'click .prev-week':'prevWeek',
				'click .next-week':'nextWeek',
				'click .prev-month':'prevMonth',
				'click .next-month':'nextMonth',
				'click .addLog':'addLog'
			},
			initialize:function(){
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
				this.model.bind('change:startDate', this.render, this);
			},
			render:function(){
				var time = this.model.get('startDate').getTime();
				this.mon = this.model.get('startDate');
				this.tue = new Date(time+this.msDay);
				this.wed = new Date(time+this.msDay*2);
				this.thu = new Date(time+this.msDay*3);
				this.fri = new Date(time+this.msDay*4);
				this.sat = new Date(time+this.msDay*5);
				this.sun = new Date(time+(this.msDay*6));
				
				this.$('.date-start').html(this.mon.getDate()+' '+this.month(this.mon));
				this.$('.date-end').html(this.sun.getDate()+' '+this.month(this.sun) + ', ' + this.sun.getFullYear());
				
				// update displayed timesheet table dates
				$('.date-headings .mon-col .sdate').html(this.mon.getDate()+' '+this.monthShort(this.mon));
				$('.date-headings .tue-col .sdate').html(this.tue.getDate()+' '+this.monthShort(this.tue));
				$('.date-headings .wed-col .sdate').html(this.wed.getDate()+' '+this.monthShort(this.wed));
				$('.date-headings .thu-col .sdate').html(this.thu.getDate()+' '+this.monthShort(this.thu));
				$('.date-headings .fri-col .sdate').html(this.fri.getDate()+' '+this.monthShort(this.fri));
				$('.date-headings .sat-col .sdate').html(this.sat.getDate()+' '+this.monthShort(this.sat));
				$('.date-headings .sun-col .sdate').html(this.sun.getDate()+' '+this.monthShort(this.sun));
			},
			month:function(d){
				return this.months[d.getMonth()];
			},
			monthShort:function(d){
				return this.month(d).substring(0,3);
			},
			getStartTime:function(){
				return this.model.get('startDate').getTime();
			},
			setStartTime:function(miliseconds, operator){
				if(operator=='-')
					var start = new Date(this.getStartTime()  - miliseconds);
				else
					var start = new Date(this.getStartTime() + miliseconds); 
				this.model.set({startDate:start});
				window.timesheet.timeLogList.fetchLogsFor(start);
			},
			prevWeek:function(){
				this.setStartTime(this.msWeek, '-');
			},
			nextWeek:function(){
				this.setStartTime(this.msWeek, '+');
			},
			nextMonth:function(){
				this.setStartTime(this.msWeek * 4, '+');
			},
			prevMonth:function(){
				this.setStartTime(this.msWeek * 4, '-');
			},
			addLog:function(){
				window.timesheet.timeLogRows.addRowForm();
			}
		});
		
		
		// GO GO GO!
		window.timesheet.init(<?php echo $startDate; ?>);

		
	});
	
	
	


</script>
