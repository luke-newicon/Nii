<div class="jobcard">
	<h1><?php echo $task->name; ?></h1>
	<div class="line">
		<div class="unit size1of2">
			<p>billable time: <strong><?php echo NTime::minutesToDaysNice($task->billable_time); ?></strong></p>
			<p>Current time:</p>
			<p>% Complete:</p>
		</div>
		<div class="lastUnit">
			<div class="progress">
			<div class="bar"
				style="width: 60%;"></div>
			</div>
		</div>
	</div>
</div>

<a class="btn btn-primary add-task">Add Task</a>
<div id="create-task-dialog" title="Create Task" style="display:none;">
	<?php $form = $this->beginWidget('nii.widgets.NActiveForm',array(
		'id'=>'create-job',
		'action'=>$this->createUrl('/project/task/create', array('parent'=>$task->id)),
	)); ?>
		<?php $task = new ProjectTask; ?>
		<div class="field stacked	">
			<div class="inputContainer">
				<label for="ProjectTask_name" class="inFieldLabel" style="font-size:16px;" >Task Name</label>
				<div class="input">
					<?php echo $form->textField($task,'name', array('style'=>'font-size:16px;')); ?>
				</div>
				<?php echo $form->error($task,'name'); ?>
			</div>
		</div>
		<div class="field stacked	">
			<div class="inputContainer">
				<label for="ProjectTask_name" class="inFieldLabel" >Description</label>
				<div class="input">
					<?php echo $form->textArea($task,'description'); ?>
				</div>
				<?php echo $form->error($task,'description'); ?>
			</div>
		</div>
		<?php echo $form->field($task, 'due'); ?>
		<?php echo $form->beginField($task, 'assigned_id'); ?>
		<?php echo $this->widget('user.widgets.UserSelect', array('model'=>$task,'attribute'=>'assigned_id'), true); ?>
		<?php echo $form->endField($task, 'assigned_id'); ?>
		<?php echo $form->beginField($task, 'estimated_time'); ?>
			<?php echo $this->widget('project.widgets.ProjectTime', array('model'=>$task,'attribute'=>'estimated_time'), true); ?>
		<?php echo $form->endField($task, 'estimated_time'); ?>
		<div class="control-group">
			<?php echo $form->labelEx($task, 'billable_time'); ?>
			<div class="controls">
				<?php echo $form->textField($task, 'billable_time'); ?>
				<p class="help-block">(in minutes)</p>
			</div>
		</div>
		
	<?php $this->endWidget(); ?>
</div>

<script>
	jQuery(function($){
		$.fn.nii.form();
		$('.add-task').click(function(){
			$('#create-task-dialog').dialog({
				modal:true,
				width:'600',
				buttons:[
					{
						text:'Create Task',
						class:'btn btn-primary',
						click:function(){
							$.fn.yiiactiveform.doValidate('#create-task-dialog form', {success:function(){
								$('#create-task-dialog form').submit();
							}})
						}
					},
					{
						text:'Cancel',
						class:'btn',
						click:function(){
							$('#create-task-dialog').dialog('close');
						}
					}
				]
			});
		});
	});
</script>
