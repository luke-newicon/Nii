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
	<h1>Projects</h1>
	<div class="action-buttons">
		<?php if(Yii::app()->user->checkAccess('task/admin/addTask')) : ?>
			<a id="add-project" class="btn primary">Add a Project</a>
		<?php endif; ?>
	</div>
</div>
<?php if(TaskProject::model()->count()) : ?>
<?php
	$model = new TaskProject('search');
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
				'value' => '$data->viewLink($data->name)',
			),
		),
	));
?>
<?php else : ?>
	<div class="alert-message block-message">
		<h3>Welcome to your Projects</h3>
		<p>You currently have no projects.  To get started, create a new project.</p>
		<div class="alert-actions">
		<?php if(Yii::app()->user->checkAccess('task/admin/addTask')) : ?>
			<a id="add-project-2" class="btn small primary">Create a new Project</a>
		<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
<div id="addprojectDialog" class="" title="New Project" style="display:none;">
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
							location.href='<?php echo NHtml::url('task/project/create'); ?>/project/'+$('#projectname').val();
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