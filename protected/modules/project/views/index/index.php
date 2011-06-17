<style>
	.projectBox{border:2px solid #ccc;width:200px;height:240px;padding:10px;border-radius:8px;box-shadow:0px 0px 3px #ccc;}
	.projectBox.details{box-shadow:none;border:2px dashed #ccc;}
	.projectBox:hover,.projectBox.details:hover{box-shadow:0px 0px 10px #aaa;}
	.projList li{display:inline-block;float:left;margin:15px;}
	.projImg{border:1px solid #ccc; height:158px;margin-bottom:20px;display:block;}
	.projName .name,a.addProject{font-size:120%;font-weight:bold;}
	
</style>

<ul class="noBull projList">
	<li>
		<div class="projectBox details">
			<div class="norm">
				<div class="projImg">
				<h2>Add A New Project</h2>
				</div>
				<a href="" class="addProject">Create new project</a>
			</div>
			<div class="create" style="display:none;">
				<h2>New Project</h2>
				<div class="field">
					<span class="formGuide">Enter the new project name</span>
					<div class="inputBox">
						<input id="projectInput" name="project" type="text" placeholder="Project Name" />
					</div>
				</div>
				<div class="field">
					<button class="btn btnN createProject">Create</button><a class="cancelNewProject mll" href="#">Cancel</a>
				</div>
			</div>
		</div>
	</li>
	<?php foreach($projects as $project): ?>
	<li>
		<?php $this->renderPartial('_project-stamp',array('project'=>$project)); ?>
	</li>
	<?php endforeach; ?>
</ul>


<script>
$(function(){
	$('.addProject').click(function(){
		$('.norm').hide();
		$('.create').show();
		$('#projectInput').val('').focus();
		return false;
	});
	$('.cancelNewProject').click(function(){
		$('.norm').show();
		$('.create').hide();
		return false;
	});
	
	$('.createProject').click(function(){
		var projName = $('#projectInput').val();
		//var $el = $('<li><div class="projectBox"><div class="projImg"></div><div class="projName"><span class="name">'+projName+'</span></div></div></li>')
		$.post("<?php echo NHtml::url('/project/index/create'); ?>",{name:projName},function(r){
			$('.projList').append('<li>'+r.project+'</li>');
		},'json');
		$('.norm').show();
		$('.create').hide();
	});
	
});
</script>