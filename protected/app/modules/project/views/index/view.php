<div class="page-header">
	<h2><?php echo $model->name ?></h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Back to Projects'), array("index"),array('class'=>'btn'));?>
	</div>
</div>


<?php 
	$this->widget('nii.widgets.NTabs', 
		array(
			'tabs' => array(
				'Tasks'=>array('ajax'=>array('tasks','id'=>$model->id), 'id'=>'tasks', 'count'=>$model->countProjectTasks()),
				'Milestones'=>array('ajax'=>array('milestones','id'=>$model->id), 'id'=>'milestones'),
				'Files'=>array('ajax'=>array('files','id'=>$model->id), 'id'=>'files', 'count'=>NAttachment::countAttachments(get_class($model), $model->id)),
			),
			'options' => array(
			),
			'htmlOptions' => array(
				'id' => 'tabs',
			)
		)
	); 
?>