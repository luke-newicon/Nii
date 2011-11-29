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
<?php Yii::app()->getClientScript()->registerCoreScript('backbone'); ?>
<style>
	.card{border:1px solid #ccc;}
	.taskHead{font-size:14px;}
</style>

<div id="addTaskForm">
	<div class="field" style="font-size:24px;">
		<label class="inFieldLabel" for="addTask">What needs to be done?</label>
		<div class="input">
			<input id="addTask" name="task" class="large" type="text" />
		</div>
	</div>
</div>

<div class="card">
	<div class="media">
		<a href="#" class="img prs"><?php $this->widget('nii.widgets.Gravatar', array('email'=>'steve@newicon.net','size'=>'24')); ?></a>
		<div class="bd">
			<a href="#">Something that needs doing</a>
			<p>Details n things</p>
		</div>
	</div>
</div>

<div class="card">
	<div class="media">
		<a href="#" class="img prs"><?php $this->widget('nii.widgets.Gravatar', array('email'=>'steve@newicon.net','size'=>'24')); ?></a>
		<div class="bd">
			<a class="taskHead" href="#">Something that needs doing</a>
			<p>Details n things</p>
		</div>
	</div>
</div>

<script>
	
	window.niiTask = {
		init:function(){
			$('#addTask').keyup(function(e){
				if(e.keyCode == 13){
					// yey
					alert($(this).val());
				}
			})
		}
	};
	
	niiTask.CCardView = Backbone.View.extend({
		template:$('#task-card-template').html(),
		init:function(){

		},
		render:function(){

		}
	});
	
	
	
	
	niiTask.init();

</script>