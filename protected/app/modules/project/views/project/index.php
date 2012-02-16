
<div class="page-header">
	<h1><?php echo $project->name; ?></h1>
	<div class="action-buttons"><a class="add-job btn btn-primary">Add Job</a></div>
</div>


<div id="create-job-dialog" title="Create Job" style="display:none;">
	<?php $form = $this->beginWidget('nii.widgets.NActiveForm',array(
		'id'=>'create-job'
	)); ?>
		<?php $job = new ProjectTask; ?>
		<?php echo $form->field($job, 'name'); ?>
		<?php echo $form->field($job, 'due'); ?>
	
		<?php  
		echo $this->widget('user.widgets.UserSelect', array('model'=>$job,'attribute'=>'assigned_id'), true);
		?>
<?php
	$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
      'name'=>'city',
		'source'=>array('ac1', 'ac2', 'ac3'),
      // additional javascript options for the autocomplete plugin
      'options'=>array(
          'minLength'=>'2',
      ),
      'htmlOptions'=>array(
          'style'=>'height:20px;'
      ),
  )); ?>
		<?php echo $form->field($job, 'assigned_id'); ?>
	<?php $this->endWidget(); ?>
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