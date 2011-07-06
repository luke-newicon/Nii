<style>
	.projectBox{border:2px solid #ccc;width:200px;height:240px;padding:10px;border-radius:8px;box-shadow:0px 0px 3px #ccc;}
	.projectBox.details{box-shadow:none;border:2px dashed #ccc;}
	.projectBox:hover,.projectBox.details:hover{box-shadow:0px 0px 10px #aaa;}
	.projList li{display:inline-block;float:left;margin:15px;}
	.projImg{border:1px solid #ccc; height:158px;margin-bottom:20px;display:block;background-color:#f1f1f1;}
	.projName .name,a.addProject{font-size:120%;font-weight:bold;}
	
	.item{border:1px solid #ccc;}
</style>

<div class="toolbar line plm" style="margin-top:-1px;">
	<div class="line">
		<div class="unit mrm">
			<h1 class="man titleBarText">Projects</h1>
		</div>
		<div class="lastUnit">
<!--			<div style="margin:2px 5px 2px 5px;width:0px;height:44px;border-left:1px solid #ababab;border-right:1px solid #fff;"></div>-->
		</div>
	</div>
</div>

<br/>
<ul class="noBull projList">
	<li class="newProject">
		<div class="projectBox details">
			<div class="norm">
				<div class="projImg">
					<h2>Add A New Project</h2>
				</div>
				<a href="" class="addProject">Create new project</a>
			</div>
			<div class="create" style="display:none;">
				<div class="projImg" style="margin-bottom:5px;">
					<h2>New Project</h2>
				</div>
				<div class="field">
					<div class="inputBox">
						<input id="projectInput" name="project" type="text" placeholder="Project Name" />
					</div>
					<span class="hint">Enter the new project name</span>
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



<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.isotope.min.js" ></script>
<script>
$(function(){
	
//	$('.projList').isotope({
//		// options
//		itemSelector : 'li',
//		layoutMode : 'fitRows',
//		animationEngine:'best-available',
//		animationOptions: {
//		    duration: 750,
//		    easing: 'linear',
//		    queue: false
//	    }
//	});
	
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
			//$create = $('.projList .newProject').clone();
			$createBox = $('.projList .newProject');
			$new = $(r.project).appendTo('body').show()
				.position({my:'left top', at:'left top', of:$createBox}).hide().fadeIn('normal');
			$createBox.fadeOut('normal', function(){
				$('<li>'+r.project+'</li>').insertAfter('.projList .newProject');
				$new.remove();
				window.setTimeout(function(){
					$createBox.find('.norm').show();
					$createBox.find('.create').hide();
					$createBox.show('normal')
				}, 300);
			});
			
//			$('.projList .newProject').replaceWith('<li>'+r.project+'</li>');
//			window.setTimeout(function(){
//				$create.find('.norm').show();
//				$create.find('.create').hide();
//				$create.prependTo('.projList').hide().show('slow')
//			},1000);
//			$create.prependTo('.projList').hide().show('slow')
			//$('<li>'+r.project+'</li>').insertAfter('.projList .newProject').hide().show('noraml')
		},'json');
		
	});
	
});
</script>