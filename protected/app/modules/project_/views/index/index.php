<?php

/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
?>

<div class="page-header">
	<h2>Projects</h2>
	<div class="action-buttons">
		<a id="add-project" class="btn primary">Add a Project</a>
	</div>
</div>
<?php if(ProjectProject::model()->count()) : ?>

<?php
//$model = new ProjectProject('search');
//$dataProvider = $model->search();
//$this->widget('ext.bootstrap.widgets.BootListView', array(
//     'dataProvider'=>$dataProvider,
//     'itemView'=>'_project',   // refers to the partial view named '_post'
//     'sortableAttributes'=>array(
//         'name',
//     ),
//));
	$model = new ProjectProject('search');
	$dataProvider = $model->search();
	$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
		'dataProvider' => $dataProvider,
		'filter' => $model,
		'id' => 'project-grid',
		'enableButtons' => false,
		'enableCustomScopes' => false,
		'scopes' => array('enableCustomScopes' => false),
		'columns' => array(
			'name' => array(
				'name' => 'name',
				'type' => 'raw',
				'value' => '$data->getLink()',
			),
		),
	));
?>
<?php else : ?>
	<div class="alert-message block-message">
		<h3>Welcome to the Projects Screen</h3>
		<p>You currently have no projects.  To get started, create a new project.</p>
		<div class="alert-actions">
			<a id="add-project-2" class="btn small primary">Create a new Project</a>
		</div>
	</div>
<?php endif; ?>
<div id="addprojectDialog" class="" title="New Project" style="display:none;">
	<?php $project = new ProjectProject; ?>
	<?php $form = $this->beginWidget('nii.widgets.NActiveForm',array(
		'id'=>'createproject', 
		'action'=>NHtml::url('/project/index/create'),
		'clientOptions'=>array(
			'inputContainer'=>'.field'
		)
	)); ?>
	
	
	<?php //echo $form->field($project, 'name'); ?>
	<div class="field stacked	">
		<label class="lbl" for="projectname" >Name your project <span class="hint">e.g &quot;Website Redesign&quot; or &quot;Product Ideas&quot;</span></label>
		<div class="inputContainer">
			<label for="ProjectProject_name" class="inFieldLabel" style="font-size:16px;" >Enter a Name for this Project</label>
			<div class="input">
				<?php echo $form->textField($model,'name'); ?>
			</div>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>
<script>
	jQuery(function($){
		$.fn.nii.form();
		$('#add-project,#add-project-2').click(function(){
			$('#addprojectDialog').dialog({
				modal:true,
				width:'400',
				buttons:[
					{
						text:'Create Project',
						class:'btn primary',
						click:function(){
							$.fn.yiiactiveform.doValidate('#addprojectDialog form', {success:function(){
								$('#addprojectDialog form').submit();
							}})
						}
					},
					{
						text:'Cancel',
						class:'btn',
						click:function(){
							$('#addprojectDialog').dialog('close');
						}
					}
				]
			});
		});
	});
</script>