<?php

/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
Yii::app()->getClientScript()->registerPackage('backbone');

?>
<style>
	.task-item{background: -moz-linear-gradient(center top , #EEEEEE, #DDDDDD) repeat scroll 0 0 transparent;border: 1px solid #CCCCCC;border-radius: 3px 3px 3px 3px;margin-bottom: 3px;padding: 6px;text-shadow: 0 1px 0 #FFFFFF;}
</style>

<div id="tasks" style="width:600px">
	<div id="task-form" class="field"></div>

	<div id="task-list"></div>
</div>





<script id="task-form-template" type="text/template">
	<div class="line input">
		<div class="unit size3of4  ">
			<label for="task" class="inFieldLabel">Add a task...</label>
			<div>
				<input class="task" name="task" id="task" type="text" value="" />
			</div>
		</div>
		<div class="unit size1of10" style="border-left:1px solid #ccc;padding-left:3px;">
			<div class="line">
				<div class="unit sprite project-clock" style="cursor:pointer"></div>
				<div class="lastUnit" style="padding-left:3px;">
					<input name="estimated_time" type="text" />
				</div>
			</div>
		</div>
		<div class="lastUnit" style="border-left:1px solid #ccc;padding-left:3px;">
			<div class="unit sprite project-user" style="cursor:pointer"></div>
			<div class="lastUnit" style="padding-left:3px;">
				<input name="asigned_id" type="text" />
			</div>
		</div>
	</div>
</script>

<script id="quick-select" type="template/text">
	<div style="width:100px;border-bottom:1px solid #eee;">
		<ul>

		</ul>
	</div>
</script>

<script id="task-list-template" type="text/template">
	
</script>

<script id="task-template" type="text/template">
	<div class="line">
		<div class="unit size3of4 task">
			<%= name %>
		</div>
		<div class="unit">
			<%= estimated_time_nice %>
		</div>
		<div class="lastUnit">
			
		</div>
	</div>
</script>

<script id="task-form-template" type="text/template">
	
</script>
<script>

$(function(){
	
	
	var CUser = Backbone.Model.extend({
		defaults:{
			name:'',
			image:''
		}
	});
	
	var CUserList = Backbone.Collection.extend({
		model:CUser
	});
	
	var CTask = Backbone.Model.extend({
		defaults:{
			name:'',
			description:'',
			estimated_time_nice:''
		}
	})
	
	var CTaskList = Backbone.Collection.extend({
		url:'<?php echo NHtml::url('/api/project/1/task'); ?>',
		model:CTask
	})
	
	
	var CTaskFormView = Backbone.View.extend({
		template:_.template($('#task-form-template').html()),
		initialize:function(){
			this.setElement($('#task-form'));
			this.render();
		},
		events:{
			'keyup #task':'keyupTask',
			'keyup':'keyup'
		},
		render:function(){
			this.$el.html(this.template({}));
			$.fn.nii.form();
			this.$('[name="task"]').focus();
		},
		keyup:function(e){
			if(e.which == 13){
				this.createTask();
				e.preventDefault();
				return false;
			}
		},
		createTask:function(){
			var task = new CTask({
				name:this.$('[name="task"]').val(),
				estimated_time_nice:this.$('[name="estimated_time"]').val(),
				asigned_id:this.$('[name="asigned_id"]').val()
			});
			window.niiTask.tasks.add(task);
			task.save();
			// redraw the form
			this.render();
		},
		keyupTask:function(e){
			var searchwrds = this.$('#task').val().split(" ");
			$.each(searchwrds,function(i,val){
			   //check if its an empty string 
				if($.trim(val) == ""){
					searchwrds.splice(i);
				} else {
					var userMatches = window.niiTask.users.filter(function(u){
						if(val.length>2)
							return u.get('name').toLowerCase().substring(0, val.length) == val;
					});
					if(userMatches.length > 0){
						searchwrds.splice(i); // remove this text from the box
						console.log(userMatches)
					}
				}
			});	
		}
	});
	
	/**
	 * view responsible for drawing the list of task views 
	 */
	var CTaskListView = Backbone.View.extend({
		template:_.template($('#task-list-template').html()),
		events:{},
		initialize:function(){
			this.setElement($('#task-list'));
			this.collection.bind('add',this.addOne, this);
			this.collection.bind('reset',this.render, this);
		},
		render:function(){
			this.addAll();
			this.$el.sortable();
		},
		addOne:function(task){
			// create a new task view and pass in the task model then append
			var taskView = new CTaskView({
				model:task
			});
			
			this.$el.append(taskView.render().el);
		},
		addAll:function(){
			this.collection.forEach(this.addOne, this);
		}
	})
	
	/**
	 * view responsible for drawing the list of task views 
	 */
	var CTaskView = Backbone.View.extend({
		className:'task-item',
		template:_.template($('#task-template').html()),
		events:{},
		initialize:function(){
		
		},
		render:function(){
			this.$el.html(this.template(this.model.toJSON()));
			return this;
		}
	})
	
	var CProjectTask = Backbone.Model.extend({
		run:function(){
			// configure it all biatch
			this.taskForm = new CTaskFormView()
			this.users = new CUserList();
			this.tasks = new CTaskList();
			
			this.tasksView = new CTaskListView({
				collection:this.tasks
			});
			
			this.users.reset([{name:'steve'},{name:'robin'},{name:'luke'},{name:'Dan'},{name:'Matthew'}]);
			this.tasks.reset(<?php echo $tasks; ?>);
		}
	});
	
	
	
	
	// start things up!
	window.niiTask = new CProjectTask();
	window.niiTask.run();
	
});
	
</script>