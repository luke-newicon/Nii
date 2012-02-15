<div class="page-header">
	<h2><?php echo $model->name ?></h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Back to Projects'), array("index"),array('class'=>'btn'));?>
	</div>
</div>

<div id="addJobDialog" class="" title="New Job" style="display:none;">
	<?php $task = new ProjectTask; ?>
	<?php $form = $this->beginWidget('nii.widgets.NActiveForm',array(
		'id'=>'createJob', 
		'action'=>NHtml::url(array('/project/index/createJob','projectId'=>$model->id))
	)); ?>
	<div class="control-group field">
		<div class="inputContainer">
			<label style="font-size:18px;top:8px;" class="inFieldLabel" for="ProjectTask_name" />Name</label>
			<div class="input">
				<?php echo $form->textField($task,'name',array('style'=>'font-size:18px;height:25px;')); ?>
			</div>
		</div>
		<?php echo $form->error($task,'name'); ?>
	</div>
		
		<?php echo $form->field($task,'priority'); ?>
		<?php echo $form->field($task,'estimated_time'); ?>
		<?php echo $form->field($task,'due'); ?>
	<?php $this->endWidget(); ?>
</div>
<script>
	jQuery(function($){
		$.fn.nii.form();
		$('.add-job').click(function(){
			$('#addJobDialog').dialog({
				modal:true,
				width:'500',
				buttons:[
					{
						text:'Cancel',
						class:'btn',
						click:function(){
							$('#addJobDialog').dialog('close');
						}
					},
					{
						text:'Create Project',
						class:'btn btn-primary',
						click:function(){
							$.fn.yiiactiveform.doValidate('#addJobDialog form', {success:function(){
								$('#addJobDialog form').submit();
							}})
						}
					}
				]
			});
		});
	});
</script>

<a class="btn btn-primary add-job">Add Job</a>

<h3>Time logs</h3>
<div class="timelogs">
	
	<?php $mins = Yii::app()->getModule('timesheet')->getTotalProjectMinutes($model->id); ?>
	<p><strong>Total time:<?php echo NTime::minutesToTime($mins); ?></strong></p>
	
	<p><strong><?php echo NTime::minutesToDaysNice($mins); ?></strong></p>
	
	
	<?php foreach(Yii::app()->getModule('timesheet')->getProjectTimeLogs($model->id) as $log): ?>
		<?php echo NTime::minutesToTime($log->minutes); ?>
	<?php endforeach; ?>
</div>