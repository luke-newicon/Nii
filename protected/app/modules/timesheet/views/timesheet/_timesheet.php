<style>
	.sdate{font-size:11px;font-weight:normal;white-space: nowrap;}
	#timesheet-grid .field .input {border-radius:0px; padding:3px;}
	#timesheet-totals th{text-align:right;}
	#timesheet-totals th.total{font-weight:bold;}
</style>
<div id="timesheet">
	<div id="timesheet-selector" class="line well">
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
	<form>
		<input type="hidden" name="log[date]" id="log_date" />
		<table id="timesheet-grid" class="condensed-table bordered-table zebra-striped table table-bordered table-striped">
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
					<th class=" total-col">Total</th>
					<th class=""></th>
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
					<th class="total">0:00</th>
					<th></th>
				</tr>
			</tfoot>
			<tbody>
			</tbody>
		</table>
	</form>
	<div class="txtR"><a class="saveLog btn primary large">Save Log</a></div>
</div>




<script type="text/template" id="time-log-row-template">
	<td>
		<% if (editable) { %>
		<div class="field mbn project" >
			<div class="input">
				<select name="log[<%= row %>][project]"  id="project_<%= row %>">
					<option value="">Select a project</option>
					<% window.timesheet.projects.forEach(function(p) { %> <option value="<%= p.get('id') %>" ><%= p.get('name') %></option><% }) %>
				</select>
			</div>
		</div>
		<% } %>
		<% if (!editable) { %>
			<% print(window.timesheet.projects.displayProject(project_id)); %>
		<% } %>
	</td>
	<td>
		<% if (editable) { %>
			<div class="field mbn task">
				<div class="input">
					<input name="log[<%= row %>][task]" id="task_<%= row %>" type="text" />
				</div>
			</div>
		<% } %>
		<% if (!editable) { %>
			<% print(window.timesheet.tasks.displayTask(task_id)); %>
		<% } %>
	</td>
	<td class="hour_units mon-col field">
		<% if (editable) { %>
			<div class="input">
				<input name="log[<%= row %>][time][]" value="<%= mon %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= mon %>
		<% } %>
	</td>
	<td class="hour_units tue-col field">
		<% if (editable) { %>
			<div class="input">
				<input name="log[<%= row %>][time][]" value="<%= tue %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= tue %>
		<% } %>
	</td>
	<td class="hour_units wed-col field">
		<% if (editable) { %>
			<div class="input">
				<input name="log[<%= row %>][time][]" value="<%= wed %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= wed %>
		<% } %>
	</td>
	<td class="hour_units thu-col field">
		<% if (editable) { %>
			<div class="input">
				<input name="log[<%= row %>][time][]" value="<%= thu %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= thu %>
		<% } %>
	</td>
	<td class="hour_units fri-col field">
		<% if (editable) { %>
			<div class="input">
				<input name="log[<%= row %>][time][]" value="<%= fri %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= fri %>
		<% } %>
	</td>
	<td class="hour_units sat-col field">
		<% if (editable) { %>
			<div class="input">
				<input name="log[<%= row %>][time][]" value="<%= sat %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= sat %>
		<% } %>
	</td>
	<td class="hour_units sun-col field">
		<% if (editable) { %>
			<div class="input">
				<input name="log[<%= row %>][time][]" value="<%= sun %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= sun %>
		<% } %>
	</td>
	<td class="hour_units total-col">0:00</td>
	<td class="delete-col">
		<% if (editable){ %>
			<a href="#" class="icon fam-delete record-delete"></a>
		<% } %>
	</td>
</script>


<script type="text/javascript">
	
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						},
						position:{my:'left top',at:'left bottom',of:input,offset:'-4 5',collision:'flip'}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				this.button = $( '<span style="position:absolute;top:5px;right:5px;cursor:pointer;" class="down sprite fam-bullet-arrow-down"></span>' )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "");
						input.focus();
					});
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );
	

		
	jQuery(function($){
		
		window.timesheet = {
			// can be set to hours or minutes
			logTimeIn:'hours',
			// calendar view
			cal:{},
			// store our Model classes
			models:{},
			// store our view classes
			views:{},
			// model storing the start and end dates for timesheet week
			timesheet:null,
			timeLogList:{},
			timeLogRowList:{},
			// time log rows parent view
			timeLogRows:{},
			// stores the project collection
			projects:null,
			// task collection
			tasks:null,
			/**
			 * Init the timesheet app
			 * start time is the unix epoch time in seconds (equivelent to PHP's)
			 * note: javascripts unix time is in milliseconds so multiply by 1000
			 * this function is only called once, to set the date after init use the time model directly
			 */
			init:function(startTime){
				this.projects = new this.models.Projects;
				this.projects.reset(<?php echo $projects; ?>);
				this.tasks = new this.models.Tasks;
				this.tasks.reset(<?php echo $tasks; ?>);
				
				// javascript unix epoch is in milliseconds multiple by 1000
				var d = new Date(parseInt(startTime)*1000);
				this.timesheet = new this.models.Timesheet();
				this.cal = new CTimesheetCal({model:this.timesheet});
				// start the ball rolling
				this.timesheet.set({startDate:d});
				
				this.timeLogList = new this.models.TimeLogCollection;
				this.timeLogRowList = new this.models.TimeLogRowCollection;
				
				// var timeLogRowsView = new this.views.TimeLogRows({collection:this.timeLogList});
				
				this.timeLogRows = new this.views.TimeLogRows({collection:this.timeLogRowList});
				
				this.timeLogList.reset(<?php echo $logs; ?>);
				
				$('.saveLog').click(_.bind(function(){
					var date = window.timesheet.dateToMysql(window.timesheet.timesheet.get('startDate'));
					$('#log_date').val(date);
					var data = $('#timesheet form').serialize();
					$.post("<?php echo NHtml::url('/timesheet/timesheet/saveWeekLog') ?>",data, function(){
						// refresh the timesheet
						window.timesheet.tasks.fetch({success:function(){
							window.timesheet.timeLogList.refresh();
						}});
					});
				},this));
			},
			dateToMysql:function(date){
				return date.getFullYear() + '-' +
					(date.getMonth() < 9 ? '0' : '') + (date.getMonth()+1) + '-' +
					(date.getDate() < 10 ? '0' : '') + date.getDate();
			},
			getStartDate:function(){
				return this.timesheet.get('startDate');
			}
		}
		
		// model to contain the current active week.
		// and data about the timesheet
		timesheet.models.Timesheet = Backbone.Model.extend({
			defaults:{
				startDate:null
			}
		});
		
		
		// represents the individual database records
		timesheet.models.TimeLog = Backbone.Model.extend({
			defaults:{
				id:null,
				date:null,
				row:0,
				project_id:0,
				task_id:0,
				minutes:0
			}
		});
		
		
		timesheet.models.TimeLogCollection = Backbone.Collection.extend({
			url:function(){
				return '<?php echo NHtml::url("/timesheet/timesheet/weeklog/") ?>'
			},
			model:timesheet.models.TimeLog,
			getProjects:function(){
				return this.groupBy(function(m){
					return m.get('project_id') + m.get('task_id');
				})
			},
			fetchLogsFor:function(date){
				this.fetch({data: $.param({ date: window.timesheet.dateToMysql(date)}) });
			},
			// refresh the log list, this will force a redraw of the timesheet table
			refresh:function(){
				var date = window.timesheet.timesheet.get('startDate');
				this.fetch({data: $.param({ date: window.timesheet.dateToMysql(date)}) });
			}
		})
		
		
		// represents a custom condensed week log individual timeLogs are condensed into this.
		// grouped by project_id
		timesheet.models.TimeLogRow = Backbone.Model.extend({
			defaults:{
				// position within the table
				row:0,
				editable:false,
				id:null,
				date:null,
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
		
		// stores collection of time log row
		timesheet.models.TimeLogRowCollection = Backbone.Collection.extend({
			initialize:function(){
				// when the timeloglist collection changes we need to rebuild this collection
				window.timesheet.timeLogList.bind('reset', this.build, this);
			},
			model:timesheet.models.TimeLogRow,
			build:function(){
				// remove all from the collection
				var rows = Array();
				_.each(timesheet.timeLogList.getProjects(),function(row, i){
					// each project has one timeLogRow
					rows[rows.length] = new timesheet.models.TimeLogRow({
						project_id : row[0].get('project_id'),
						task_id    : row[0].get('task_id'),
						mon        : this.sumDayLogs(row, window.timesheet.cal.mon),
						tue        : this.sumDayLogs(row, window.timesheet.cal.tue),
						wed        : this.sumDayLogs(row, window.timesheet.cal.wed),
						thu        : this.sumDayLogs(row, window.timesheet.cal.thu),
						fri        : this.sumDayLogs(row, window.timesheet.cal.fri),
						sat        : this.sumDayLogs(row, window.timesheet.cal.sat),
						sun        : this.sumDayLogs(row, window.timesheet.cal.sun)
					});
				}, this);
				this.reset(rows);
			},
			/**
			 * @param collection an array of CTimeLogs for the week grouped by project_id
			 */
			sumDayLogs:function(rowCollection ,date){
				var logs = _.filter(rowCollection, function(log){
					return log.get('date').substring(0,10) == window.timesheet.dateToMysql(date).substring(0,10);
				}, this);
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
		});
		
		timesheet.models.Project = Backbone.Model.extend({
			defaults:{
				name:''
			}
		});
		
		/**
		 * Project Collection
		 */
		timesheet.models.Projects = Backbone.Collection.extend({
			model:timesheet.models.Project,
			displayProject:function(project_id){
				var p = this.get(project_id);
				return _.isNull(p) ? 'unknown' :  p.get('name');
			}
		});
		
		timesheet.models.Task = Backbone.Model.extend({
			defaults:{name:''}
		});
		
		/**
		 * Task Collection
		 */
		timesheet.models.Tasks = Backbone.Collection.extend({
			model:timesheet.models.Task,
			url:"<?php echo NHtml::url('/timesheet/timesheet/tasks'); ?>",
			displayTask:function(task_id){
				var t = this.get(task_id);
				return _.isEmpty(t) ? 'unknown' :  t.get('name');
			}
		});
			
		/**
		 * parent view to create table rows
		 * each row is a timesheet.models.TimeLogRow model
		 * (1 model per row and per project and task id combination)
		 */
		timesheet.views.TimeLogRows = Backbone.View.extend({
			el:$('#timesheet-grid tbody'),
			initialize:function(){
				this.collection.bind('reset', this.render, this);
				this.collection.bind('add', this.addOne, this);
				this.collection.bind('remove', this.doTotals, this);
			},
			events:{},
			render:function(){
				this.el.html('');
				this.collection.forEach(function(row){
					this.addOne(row)
				}, this)
				// update totals
				$(':input').unbind('timesheet_totals');
				$('#timesheet-grid').delegate(':input','blur change.timesheet_totals',_.bind(this.doTotals,this));
				this.doTotals();
			},
			doTotals:function(){
				// cols first
				this.doTotal($('#timesheet-grid tbody td.mon-col'), $('#timesheet-totals .mon-col'));
				this.doTotal($('#timesheet-grid tbody td.tue-col'), $('#timesheet-totals .tue-col'));
				this.doTotal($('#timesheet-grid tbody td.wed-col'), $('#timesheet-totals .wed-col'));
				this.doTotal($('#timesheet-grid tbody td.thu-col'), $('#timesheet-totals .thu-col'));
				this.doTotal($('#timesheet-grid tbody td.fri-col'), $('#timesheet-totals .fri-col'));
				this.doTotal($('#timesheet-grid tbody td.sat-col'), $('#timesheet-totals .sat-col'));
				this.doTotal($('#timesheet-grid tbody td.sun-col'), $('#timesheet-totals .sun-col'));

				// update rows
				_.each($('#timesheet-grid tbody tr'),function(e){
					this.doTotal($(e).find('td.field'), $(e).find('.total-col'));
				}, this);

				// update main total
				this.doTotal($('#timesheet-totals th.hour_units'), $('#timesheet-totals th.total'));
			},
			// count totals and update elements
			doTotal:function(el, elTotal){
				var total=0;
				el.each(function(){
					if($(this).is('input')){
						var val = $(this).val();
					}else{
						var val = $(this).text();

						$input =  $(this).find('input');
						if($input.length)
							val = $input.val();
					}
					var num = parseFloat(val);
					if(_.isNaN(num))num = 0;
					total = total + num;
				});
				elTotal.html(total.toFixed(2));
			},
			addRowForm:function(){
				var log = new window.timesheet.models.TimeLogRow({
					date:window.timesheet.dateToMysql(window.timesheet.getStartDate()),
					editable:true
				});
				this.collection.add(log);
				
			},
			addOne:function(model){
				// update the models row position
				model.set({row:$('#timesheet-grid tbody tr').length});
				
				var row = new window.timesheet.views.TimeLogRow({model:model});
				this.el.append(row.render().el)
				row.focusProject();
				this.doTotals();
			}
		});
		
		/**
		 * view for each unique row project_id and task_id 
		 */
		timesheet.views.TimeLogRow = Backbone.View.extend({
			tagName:'tr',
			template:_.template($('#time-log-row-template').html()),
			initialize:function(){
				this.model.bind('destroy', this.remove, this);
			},
			events:{
				'click .record-delete':'deleteRow'
			},
			render:function(){
				$(this.el).html(this.template(this.model.toJSON()));
				this.projectAutocomplete();
				this.taskAutocomplete();
				return this;
			},
			focusProject:function(){
				this.$('.project .ui-autocomplete-input').focus();
			},
			projectAutocomplete:function(){
				this.$('.project select').combobox('destroy');
				this.$('.project select').combobox();
			},
			taskAutocomplete:function(){
				this.$('.task input').autocomplete('destroy');
				this.$('.task input').autocomplete({
					
				});
			},
			deleteRow:function(){
				this.model.destroy();
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
