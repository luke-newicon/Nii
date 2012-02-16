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
		<a class="add-project btn btn-primary">Add a Project</a>
	</div>
</div>
<?php if (ProjectTask::model()->projects()->count()) : ?>

<?php
	$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
		'dataProvider' => $search->search(),
		'filter' => $search,
		'id' => 'project-grid',
		'enableButtons' => false,
		'enableCustomScopes' => false,
		'scopes' => array('enableCustomScopes' => false),
		'columns' => array(
			'name' => array(
				'name' => 'name',
				'type' => 'raw',
				'value' => '"<a href=\"".$data->getLink()."\" >".$data->name."</a>"',
			),
		),
	));
?>
<?php else : ?>
	<div class="alert alert-info">
		<h3>Welcome to the Projects Screen</h3>
		<p>You currently have no projects.  To get started, create a new project.</p>
		<div class="alert-actions">
			<a class="add-project btn small btn-primary">Create a new Project</a>
		</div>
	</div>
<?php endif; ?>
<div id="addprojectDialog" class="" title="New Project" style="display:none;">
	<?php $project = new ProjectTask; ?>
	<?php $form = $this->beginWidget('nii.widgets.NActiveForm',array(
		'id'=>'create-project', 
		'action'=>NHtml::url('/project/index/createProject'),
		'clientOptions'=>array(
			'inputContainer'=>'.field'
		)
	)); ?>
	<div class="field stacked	">
		<label class="lbl" for="projectname" >Name your project <span class="hint">e.g &quot;Website Redesign&quot; or &quot;Product Ideas&quot;</span></label>
		<div class="inputContainer">
			<label for="ProjectTask_name" class="inFieldLabel" style="font-size:16px;" >Enter a Name for this Project</label>
			<div class="input">
				<?php echo $form->textField($project,'name'); ?>
			</div>
			<?php echo $form->error($project,'name'); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>
<script>
	jQuery(function($){
		$.fn.nii.form();
		$('.add-project').click(function(){
			$('#addprojectDialog').dialog({
				modal:true,
				width:'400',
				buttons:[
					{
						text:'Create Project',
						class:'btn btn-primary',
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