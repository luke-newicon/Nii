
<div class="page-header">
	<h1><?php echo $project->name; ?></h1>
	<div class="action-buttons"><a class="add-job btn btn-primary">Add Job</a></div>
</div>


<div id="create-job-dialog" title="Create Job" style="display:none;">
	<?php $form = $this->beginWidget('nii.widgets.NActiveForm',array(
		'id'=>'create-job',
		'action'=>$this->createUrl('/project/project/createJob', array('project'=>$project->id)),
	)); ?>
		<?php $job = new ProjectTask; ?>
		<?php echo $form->field($job, 'name'); ?>
		<?php echo $form->field($job, 'due'); ?>
		<?php echo $form->beginField($job, 'assigned_id'); ?>
		<?php echo $this->widget('user.widgets.UserSelect', array('model'=>$job,'attribute'=>'assigned_id'), true);	?>
		<?php echo $form->endField($job, 'assigned_id'); ?>
		<div class="control-group">
			<?php echo $form->labelEx($job, 'billable_time'); ?>
			<div class="controls">
				<?php echo $form->textField($job, 'billable_time'); ?>
				<p class="help-block">(in minutes)</p>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($job, 'estimated_time'); ?>
			<div class="controls">
				<?php echo $form->textField($job, 'estimated_time'); ?>
				<p class="help-block">(in minutes)</p>
			</div>
		</div>
		
	<?php $this->endWidget(); ?>
</div>

<div class="jobcard-list">
<?php foreach($project->getChildren() as $job): ?>
	<div class="jobcard"><a href="<?php echo $job->link; ?>"><?php echo $job->name; ?></a></div>
<?php endforeach; ?>
</div>

<script>
	jQuery(function($){
		$.fn.nii.form();
		$('.add-job').click(function(){
			$('#create-job-dialog').dialog({
				modal:true,
				width:'500',
				buttons:[
					{
						text:'Create Job',
						class:'btn btn-primary',
						click:function(){
							$.fn.yiiactiveform.doValidate('#create-job-dialog form', {success:function(){
								$('#create-job-dialog form').submit();
							}})
						}
					},
					{
						text:'Cancel',
						class:'btn',
						click:function(){
							$('#create-job-dialog').dialog('close');
						}
					}
				]
			});
		});
	});
</script>