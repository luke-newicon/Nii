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
		<?php if(Yii::app()->user->checkAccess('task/admin/addTask')) : ?>
			<a id="addproject" class="btn primary">Add a Project</a>
		<?php endif; ?>
	</div>
</div>


Hello... a boring ass grid of projects I guess? Or maybe borrow the cards stack idea from hotspot? With a grid view option?

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

<ul>
<?php foreach(TaskProject::model()->findAll() as $p): ?>
	<li><a href="<?php echo NHtml::url(array('/task/project/index','projectId'=>$p->id)); ?>" ><?php echo $p->name; ?></a></li>
<?php endforeach; ?>
</ul>

<script>
	
	$(function(){
		$.fn.nii.form();
		$('#addproject').click(function(){
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