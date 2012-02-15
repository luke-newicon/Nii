<style>
	.sdate{font-size:11px;font-weight:normal;white-space: nowrap;}
	#timesheet-grid .field .input {border-radius:0px; padding:3px;}
	#timesheet-totals {background-color: #eee;}
	#timesheet-totals th{text-align:right;}
	#timesheet-totals th.total{font-weight:bold;}
	.today .input{border: 1px solid #999;}
	.fc-agenda-slots td div{height:16px;}
	#calendar{line-height: 16px;}
	.fc-agenda-allday{display:none;}
</style>



<ul class="nav nav-tabs">
	<li class="active"><a href="#cal" data-toggle="tab">Calendar</a></li>
	<li><a href="#timesheet" data-toggle="tab">Week</a></li>
	<li>
		<a href="#day" data-toggle="tab">Day</a>
	</li>
</ul>



<div class="tab-content">
	<div class="tab-pane active" id="cal">
		<div id="calendar"></div>
	</div>
	<!-- timesheet day -->
	<div class="tab-pane " id="day">
		<form class="form-horizontal">
			<fieldset>
			<legend>Timesheet Day</legend>
			<div class="control-group">
				<label for="focusedInput" class="control-label">Project</label>
				<div class="controls" id="project-select">
				</div>
			</div>
			<div class="control-group">
				<label for="focusedInput" class="control-label">Task</label>
				<div class="controls">
					<input type="text" id="focusedInput" class="input-xlarge focused">
				</div>
			</div>
			<div class="control-group">
				<label for="focusedInput" class="control-label">Task</label>
				<div class="controls">
					<?php $this->widget('nii.widgets.forms.DateInput', array('name'=>'date', 'value'=>date('Y-m-d',time()))); ?>
				</div>
			</div>
			<div class="control-group">
				<label for="focusedInput" class="control-label">Time</label>
				<div class="controls">
					<input type="text" id="time" class="focused" style="width:40px;">
					<script>
						$(function(){
							$.mask.definitions['m']='[012345]';
							$('#time').mask('9:?m9',{placeholder:' '});
						});	
					</script>
				</div>
			</div>
			<div class="control-group">
				<label for="focusedInput" class="control-label">Notes</label>
				<div class="controls">
					<textarea class="input-xlarge"></textarea>
				</div>
			</div>

			<div class="form-actions">
				<button class="btn btn-primary" type="submit">Save changes</button>
				<button class="btn" type="reset">Cancel</button>
			</div>
			</fieldset>
		</form>
	</div>
	<!-- timesheet tab -->
	<div class="tab-pane" id="timesheet">
		<div id="timesheet-selector" class="line well">
			<div class="unit size1of3 txtR btn-group">
				<a class="btn prev-month"><i class="icon-backward"></i></a><a class="btn prev-week"><i class="icon-chevron-left"></i></a> 
			</div>
			<div class="unit size1of3 txtC">
				<span class="date-start">2 January</span> - <span class="date-end">9 January, 2012</span> 
			</div>
			<div class="lastUnit txtL">
				<div class="pull-right btn-group">
					<a class="btn next-week"><i class="icon-chevron-right"></i></a><a class="btn next-month"><i class="icon-forward"></i></a> 
				</div>
				<a class="btn btn-primary addLog">Add Log</a>
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
		<div class="txtR"><a class="saveLog btn btn-primary btn-large">Save Log</a></div>
	</div>
</div>

<!--<div id="addprojectDialog" class="" title="New Project" style="display:none;">
	<form>
		<div class="field stacked	">
			<label class="lbl" for="projectname" >Name your project <span class="hint">e.g &quot;Website Redesign&quot; or &quot;Product Ideas&quot;</span></label>
			<div class="inputContainer">
				<label for="projectname" class="inFieldLabel" style="font-size:16px;" >Enter a Name for this Project</label>
				<div class="input">
					<input style="font-size:16px;" type="text" id="projectname" name="projectname">
				</div>
			</div>
		</div>
	</form>
</div>-->
<script type="text/template" id="timelog-pop-template">
	<div style="position:absolute;bottom:-11px;overflow:hidden;left:190px;width:22px;height:11px;">
		<div style="position:absolute;left:0px;top:0px;border-color:#999999 transparent;border-width:11px;border-style:solid;"></div>
		<div style="position:absolute;left:1px;top:0px;border-color:#F5F5F5 transparent;border-width:10px;border-style:solid;"></div>
	</div>
	<div class="form-horizontal">
		<div class="control-group mbs pts">
			<label for="project" class="control-label"  style="width:60px;">When:</label>
			<div class="controls" style="margin-left:75px;">
				<p class="mts mbn"> <% print(log.startTime()); %> - <% print(log.endTime()); %> </p>
			</div>
		</div>
		<div class="control-group mbs">
			<label for="project" class="control-label"  style="width:60px;">Project</label>
			<div class="controls project" style="margin-left:75px;"></div>
		</div>
		<div class="control-group mbs">
			<label for="task" class="control-label" style="width:60px;">Task</label>
			<div class="controls" style="margin-left:75px;">
				<input type="text" class="input-xlarge">
			</div>
		</div>
		<div class="form-actions pas line">
			<div class="unit size1of2">
				<button class="delete btn btn-danger">Delete</button>
			</div>
			<div class="lastUnit" style="text-align:right;">
				<% if(_.isNull(log.id)) { %>
				<button class="save btn btn-primary">Save</button>
				<% } %>
				<button class="cancel btn" type="reset">Cancel</button>
			</div>
		</div>
	</div>
</script>
<?php $this->renderPartial('_templates'); ?>
<?php Yii::app()->clientScript->registerCoreScript('maskedinput'); ?>

<div id="timelog-pop" class="ptm" style="" ></div>

<script type="text/javascript">

		
	jQuery(function($){
		
		
		// page is now ready, initialize the calendar...
		
		window.project = {};
		window.timesheet = {
			// can be set to hours or minutes
			format:'time',
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
					
					var data = $('#timesheet form').serializeArray();
					data.push({name:'log[format]',value:'time'});
					$.post("<?php echo NHtml::url('/timesheet/timesheet/saveWeekLog') ?>", data, function(){
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
			/**
			 * converts a mysql date string to a javascript date object
			 * @param string date mysql date string YYYY-MM-DD
			 */
			mysqlToDate:function(date){
				var t = date.split(/[- :]/);
				// Apply each element to the Date function
				return new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
			},
			getStartDate:function(){
				return this.timesheet.get('startDate');
			},
			/**
			 * If the day integer matches the current day returns true
			 * @param int day number integer 0 = sunday, monday = 1
			 */
			isToday:function(day){
				var d = new Date();
				return (day == d.getDay());
			},
			printToday:function(day){
				return this.isToday(day) ? 'today' : '';
			},
			/**
			 * hours:minutes a time of 1:30 will return 90 minutes
			 * @param string time format 1:20 (H:MM)
			 */
			timeToMinutes:function(time){
				var hm = time.split(':');
				var h = parseInt(hm[0]);
				var m = parseInt(hm[1]);

				if(_.isNaN(h))h = 0;
				if(_.isNaN(m))m = 0;

				return (h*60) + m;
			},
			/**
			 * Takes a number of minutes and returns a time H:MM
			 * 
			 * @param int minutes total minutes
			 */
			minutesToTime:function(minutes){
				var mins = minutes % 60;
				var hours = Math.floor(minutes / 60);
				// add leading zero on minutes
				mins = '0'+mins;
				mins = mins.substr(mins.length-2);
				return hours + ':' + mins;
			}
		}
		
		// model to contain the current active week.
		// and data about the timesheet
		timesheet.models.Timesheet = Backbone.Model.extend({
			defaults:{
				startDate:null
			}
		});
		
		
		
		
		
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
				mon:'',tue:'',wed:'',thu:'',fri:'',sat:'',sun:''
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
				
				if(window.timesheet.format == 'time'){
					//mins = mins / 60;
					// mins = mins.toFixed(2);
					mins = timesheet.minutesToTime(mins);
				}
				
				return (mins=='0:00') ? '' : mins;
			}
		});
		
		timesheet.models.Project = Backbone.Model.extend({
			defaults:{
				name:''
			},
			/**
			 * gets the name and formats it to highlight the last search string
			 * @return string html
			 */
			getNameSearchHighlight:function(){
				return this.getNameHighlight(window.timesheet.projects.nameSearchFilter)
			},
			/**
			 * return a string with the filter text highlighted in a strong tag
			 * @param string filterName
			 * @return string html
			 */
			getNameHighlight:function(highlight){
				return this.get('name').replace(
					new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(highlight) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>"
				);
			}
		});
		
		/**
		 * Project Collection
		 */
		timesheet.models.Projects = Backbone.Collection.extend({
			model:timesheet.models.Project,
			displayProject:function(project_id){
				var p = this.get(project_id);
				return (_.isNull(p)||_.isUndefined(p)) ? 'unknown' :  p.get('link');
			},
			/**
			 * store the last name search filter string. as passed to this.filterByNameSearch
			 */
			nameSearchFilter:'',
			/**
			 * function to filter projects by a partial string name match
			 * @param string nameSearchFilter the search string to look up screens by name
			 * @return array
			 */
			filterByProjectName:function(nameSearchFilter){
				this.nameSearchFilter = nameSearchFilter;
				var matcher = new RegExp($.ui.autocomplete.escapeRegex(nameSearchFilter), "i");
				var filtered = this.filter(function(model) {
					return (model.get('id') && (!nameSearchFilter || matcher.test(model.get('name'))));
				});
				return filtered;
			}
		});
		
		timesheet.models.Task = Backbone.Model.extend({
			defaults:{name:''},
			/**
			 * gets the name and formats it to highlight the last search string
			 * @return string html
			 */
			getNameSearchHighlight:function(){
				return this.getNameHighlight(window.timesheet.tasks.nameSearchFilter)
			},
			/**
			 * return a string with the filter text highlighted in a strong tag
			 * @param string filterName
			 * @return string html
			 */
			getNameHighlight:function(highlight){
				return this.get('name').replace(
					new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(highlight) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>"
				);
			}
		});
		
		/**
		 * Task Collection
		 */
		timesheet.models.Tasks = Backbone.Collection.extend({
			model:timesheet.models.Task,
			url:"<?php echo NHtml::url('/timesheet/timesheet/tasks'); ?>",
			nameSearchFilter:null,
			displayTask:function(task_id){
				var t = this.get(task_id);
				return _.isEmpty(t) ? 'unknown' :  t.get('name');
			},
			filterTaskForProject:function(id, nameSearchFilter){
				this.nameSearchFilter = nameSearchFilter;
				var filtered = this.filter(function(model){
					return model.get('project_id') == id
				});
				return filtered;
				console.log(filtered)
				this.nameSearchFilter = nameSearchFilter;
				var matcher = new RegExp($.ui.autocomplete.escapeRegex(nameSearchFilter), "i");
				var filtered = _.each(filtered,function(model) {
					return (model.get('id') && (!nameSearchFilter || matcher.test(model.get('name'))));
				});
				return filtered;
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
				this.$el.html('');
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
					// get the total in minutes
					var num = timesheet.timeToMinutes(val);
					total = total + num;
				});
				
				elTotal.html(timesheet.minutesToTime(total));
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
				this.$el.append(row.render().el)
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
				this.model.bind('change:project_id', this.projectIdChange, this);
				window.timesheet.projects.bind('add', this.redrawProjects, this);
			},
			events:{
				'click .record-delete':'deleteRow',
				'click .project .down':'projectAutocompleteDropDown',
				'change input.time':'timeChange'
			},
			render:function(){
				this.$el.html(this.template(this.model.toJSON()));
				if(this.model.get('editable')){
					//add input mask to time fields
					$.mask.definitions['m']='[012345]';
					this.$('input.time').mask('9:?m9',{placeholder:' '});
					
					this.projectAutocomplete();
					// this.taskAutocomplete();
					this.$('.task .input').addClass('disabled');
					this.$('.task input').attr('disabled','disabled');
				}
				return this;
			},
			// update the time format after user input
			// mainly add trailing zeros if minutes have not been entered
			timeChange:function(e){
				if(timesheet.format == 'time'){
					var time = $(e.target).val()+'00';
					$(e.target).val(time.substr(0,4));
				}
			},
			focusProject:function(){
				this.$('.project .ui-autocomplete-input').focus();
			},
			projectAutocomplete:function(){
				this.$('.project input.select').autocomplete('destroy');
				this.$('.project input.select').autocomplete({
					minLength: 0,
					source: function(request, response) {
						response(window.timesheet.projects.filterByProjectName(request.term));
					},
					select:_.bind(function(event, ui) {
						this.model.set({'project_id':ui.item.get('id')});
						//this.model.save();
						return false;
					},this),
					change:_.bind(function(event, ui){
						if(_.isNull(ui.item)) {
							
							// remove invalid value, as it didn't match anything
							this.$('.project input.select').val("");
							this.$('.project input.project-id').val("");
							this.$('.project input.select').data("autocomplete").term = "";
							return false;
						}
					},this),
					position:{'my':'left top','at':'left bottom','of':this.$('.project input'),'collision':'flip'}
				})
				.data("autocomplete")._renderItem = _.bind(function(ul, item) {
					return $("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.getNameSearchHighlight() + "</a>")
						.appendTo(ul);
				},this);
			},
			// function called when the drop down button of the combo box is clicked
			projectAutocompleteDropDown:function(){
				// close if already visible
				if (this.$('.project input.select').autocomplete("widget").is(":visible")) {
					this.$('.project input.select').autocomplete("close");
					return false;
				}
				// work around a bug (likely same cause as #5265)
				$(this).blur();
				// pass empty string as value to search for, displaying all results
				this.$('.project input.select').autocomplete("search", "");
				this.$('.project input.select').focus();
				return false;
			},
			// update the view with new project id
			projectIdChange:function(){
				var p = window.timesheet.projects.get(this.model.get('project_id'));
				this.$('.project input.select').val(p.get('name'));
				this.$('.project input.project-id').val(p.get('id'));
				
				// trigger reload of task list
				//this.$('.task input').addClass('loading');
				this.taskAutocomplete();
				
			},
			taskAutocomplete:function(){
				this.$('.task input').removeAttr('disabled').focus();
				this.$('.task .input').removeClass('disabled');
				this.$('.task input').autocomplete('destroy');
				this.$('.task input').autocomplete({
					minLength: 0,
					source: _.bind(function(request, response) {
						response(window.timesheet.tasks.filterTaskForProject(this.model.get('project_id'), request.term));
					},this),
					select:_.bind(function(event, ui) {
						//this.model.set({'task_id':ui.item.get('id')});
						//alert(ui.item.get('name'))
						this.$('.task input').val(ui.item.get('name'));
					},this),
//					change:_.bind(function(event, ui){
//						if(_.isNull(ui.item)) {
//							// invalid value?
//						}
//					},this),
					position:{'my':'left top','at':'left bottom','of':this.$('.task input'),'collision':'flip'}
				})
				.data("autocomplete")._renderItem = _.bind(function(ul, item) {
					return $("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.getNameSearchHighlight() + "</a>")
						.appendTo(ul);
				},this);
			},
			deleteRow:function(){
				this.model.destroy();
			}
		})
		
		
		// timesheet 
		var CTimesheetCal = Backbone.View.extend({
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
				this.setElement($('#timesheet-selector'));
				this.months = Array();
				this.months[this.months.length] = 'January';
				this.months[this.months.length] = 'February';
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
		
		
		// represents the individual database records
		timesheet.models.TimeLog = Backbone.Model.extend({
			defaults:{
				id:null,
				date:null,
				row:0,
				project_id:0,
				task_id:0,
				minutes:0
			},
			url : function() {
				// Important! It's got to know where to send its REST calls.
				// In this case, POST to '/donuts' and PUT to '/donuts/:id'
				if(this.id)
					return '<?php echo NHtml::url("/timesheet/api/log") ?>/'+this.id;
				else
					return '<?php echo NHtml::url("/timesheet/api/log") ?>';
			},
			start:null,
			end:null,
			/**
			 * return the javascript date object for the date attribute
			 */
			date:function(){
				return window.timesheet.mysqlToDate(this.get('date'));
			},
			// set the start and end date for this time log
			setDate:function(start, end){
				this.start = new Date(start.getTime());
				this.end = new Date(end.getTime());
				var minutes = (end.getTime() - start.getTime()) / 60000;
				
				this.set({
					date:$.fullCalendar.formatDate(start, 'yyyy-MM-dd HH:mm:ss'),
					minutes:minutes
				})
			},
			startTime:function(){
				return $.fullCalendar.formatDate(this.start, 'ddd, d MMMM, HH:mm') ;
			},
			endTime:function(){
				return $.fullCalendar.formatDate(this.end, 'HH:mm')
			},
			getProject:function(){
				var p = window.timesheet.projects.get(this.get('project_id'));
				return (_.isNull(p)||_.isUndefined(p)) ? 'unknown' :  p.get('name');	
			},
			createCalEventObj:function(){
				var start = this.date();
				var end = new Date(start.getTime() + this.get('minutes')*60000);
				
				var event = {
					className:'event-'+this.cid,
					id:this.cid,
					title:this.getProject(),
					start:start,
					end:end,
					allDay: false
				};
				this.setDate(start, end);
				return event;
			}
		});
		
		
		timesheet.models.TimeLogCollection = Backbone.Collection.extend({
			url:'<?php echo NHtml::url("/timesheet/api/log") ?>',
			model:timesheet.models.TimeLog,
			getProjects:function(){
				return this.groupBy(function(m){
					return m.get('project_id') + m.get('task_id');
				})
			},
			fetchLogsFor:function(date){
				this.fetch({data: $.param({ date: window.timesheet.dateToMysql(date)}) });
			},
			fetchLogsForCal:function(startd, endd){
				this.fetch({data: $.param({ start: startd}) });
			},
			// refresh the log list, this will force a redraw of the timesheet table
			refresh:function(){
				var date = window.timesheet.timesheet.get('startDate');
				this.fetchLogsFor(date);
			}
		})
		
		
		// GO GO GO!
		window.timesheet.init(<?php echo $startDate; ?>);
		
		//window.timesheet.timeLogList = new timesheet.models.TimeLogCollection();
		// full calendar js:
		
		var CProjectView = Backbone.View.extend({
			className:'inputContainer input-xlarge',
			render:function(){
				var p = window.timesheet.projects.get(this.model.get('project_id'));
				var val = (_.isUndefined(p)||_.isNull(p)) ? '' : p.get('name');
				
				this.$el.append('<div class="input-xlarge" style="position:relative;">' 
					+ '<input class="select input-xlarge" type="text" value="'+val+'" />'
					+ '<span style="position:absolute;top:5px;right:0px;cursor:pointer;" class="down sprite fam-bullet-arrow-down"></span></div>');
				
				this.autocomplete();
				return this;
			},
			events:{
				'click .down':'dropDown'
			},
			autocomplete:function(){
				this.$('.select').autocomplete('destroy');
				this.$('.select').autocomplete({
					minLength: 0,
					source: function(request, response) {
						response(window.timesheet.projects.filterByProjectName(request.term));
					},
					select:_.bind(function(event, ui) {
						this.$('.select').val(ui.item.get('name'));
						this.$('.project-id').val(ui.item.get('id'));
						this.model.set({'project_id':ui.item.get('id')});
						//this.model.save();
						return false;
					},this),
					change:_.bind(function(event, ui){
						if(_.isNull(ui.item)) {
							// remove invalid value, as it didn't match anything
							this.$('.select').val("");
							this.$('.project-id').val("");
							this.$('.select').data("autocomplete").term = "";
							return false;
						}
					},this),
					position:{'my':'left top','at':'left bottom','of':this.$('.select'),'collision':'flip'}
				})
				.data("autocomplete")._renderItem = _.bind(function(ul, item) {
					return $("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.getNameSearchHighlight() + "</a>")
						.appendTo(ul);
				},this);
			},
			// function called when the drop down button of the combo box is clicked
			dropDown:function(){
				// close if already visible
				if (this.$('.select').autocomplete("widget").is(":visible")) {
					this.$('.select').autocomplete("close");
					return false;
				}
				// work around a bug (likely same cause as #5265)
				$(this).blur();
				// pass empty string as value to search for, displaying all results
				this.$('.select').autocomplete("search", "");
				this.$('.select').focus();
				return false;
			}
		});

		
		
		
		
		var CLogForm = Backbone.View.extend({
			template:_.template($('#timelog-pop-template').html()),
			initialize:function(){
				// this.setElement($('#timelog-pop'));
				//this.model.on('change', this.render, this);
				this.model.on('destroy', this.remove, this);
				this.render();
			},
			events:{
				'click .save':'save',
				'click .cancel':'cancel',
				'click .delete':'deleteLog'
			},
			render:function(){
				this.$el.css({
					display:'none',position:'relative',width:'400px',backgroundColor:'#fff',boxShadow:'0px 0px 5px #000',zIndex:3
				});
				
				$('#timelog-pop').html(this.$el.html(this.template({log:this.model})));
				var p = new CProjectView({model:this.model});
				p.setElement(this.$('.project'));
				p.render();
				var eventEl = $('.event-'+this.model.cid);
				if(eventEl.length==0)
					eventEl = $('.fc-select-helper');
				this.$el.show().position({my:'center bottom',at:'center top', of:eventEl, offset:'0px -15px', collision:'none'})
				return this;
			},
			save:function(e){
				this.model.save();
//				calendar.fullCalendar('refetchEvents');
				var ev = this.model.createCalEventObj();
				console.log(ev);
				window.calendar.fullCalendar('renderEvent');
			},
			cancel:function(e){
				calendar.fullCalendar('refetchEvents');
				this.close();
				return false;
			},
			deleteLog:function(e){
				window.calendar.fullCalendar('removeEvents', [this.model.cid]);
				this.model.destroy();
				return false;
			},
			close:function(){
				this.remove();
				this.model.off();
			}
		})

		var CCalView = Backbone.View.extend({
			initialize:function(){
				window.timesheet.timeLogList.on('remove', this.removeLog, this);
			},
			removeLog:function(log){
				window.calendar.fullCalendar('removeEvents', [log.cid]);
			}
		});
		window.calView = new CCalView();
		

		window.curForm = null;

		window.calendar = $('#calendar').fullCalendar({
			// put your options and callbacks here
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'agendaWeek,agendaDay'
			},
			defaultView:'agendaWeek',
			selectable: true,
			selectHelper: true,
			select: function(start, end, allDay, jsEvent) {
				// remove all timeLogs that are not saved to the database
				window.timesheet.timeLogList.remove(window.timesheet.timeLogList.filter(function(l){
					return _.isNull(l.id);
				}));
					
				var log = new timesheet.models.TimeLog;
				window.timesheet.timeLogList.add(log);
				log.setDate(start, end);
				
				window.curForm = new CLogForm({model:log});

				calendar.fullCalendar('renderEvent',{
					className:'event-'+log.cid,
					id:log.cid,
					title: '',
					start: start,
					end: end,
					allDay: false
//					editable:false
				});
				
				calendar.fullCalendar('unselect');
			},
			eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
				var log = window.timesheet.timeLogList.getByCid(event.id);
				
				log.setDate(event.start, event.end);
				if(!_.isNull(log.id))
					log.save();
				
				window.curForm = new CLogForm({model:log});
			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
				var log = window.timesheet.timeLogList.getByCid(event.id);
				log.setDate(event.start, event.end);
				
				window.curForm = new CLogForm({model:log});
				// only update do no create from a drag
				if(!_.isNull(log.id))
					log.save();
			},
			eventClick: function(calEvent, jsEvent, view) {
				var log = window.timesheet.timeLogList.getByCid(calEvent.id);
				window.curForm = new CLogForm({model:log});
			},
			editable: true,
			firstDay:1,
			slotMinutes:15,
			firstHour:9,
			minTime:8,
			maxTime:20,
			height:700,
			events:function(start, end, callback){
				start = start.getTime()/1000;
				end = end.getTime()/1000;
				$.getJSON("<?php echo NHtml::url('/timesheet/api/log'); ?>",{start:start,end:end},function(r){
					window.timesheet.timeLogList.reset(r);
					var events = Array();
					window.timesheet.timeLogList.forEach(function(log){
						var event = log.createCalEventObj();
						events.push(event);
					});
					callback(events);
				});
			}
		});
		
		//var p = new CProjectView;
		//$('#project-select').html(p.render().el);
		
	});

</script>
