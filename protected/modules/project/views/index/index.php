<style>
	
	.projList li{display:inline-block;float:left;margin:15px;}
	
	
	.projectBox{position:relative;background-color:#fff;border:2px solid #ccc;width:200px;height:240px;padding:10px;border-radius:8px;box-shadow:0px 0px 3px #ccc;}
	.projectBox.details{box-shadow:none;border:2px dashed #ccc;background-color:#f9f9f9;}
	.projectBox:hover,.projectBox.details:hover{box-shadow:0px 0px 10px #aaa;}
	.projectBox.details.creating{background-color:#fff;}
	.projectBox.noShadow{box-shadow:none;}
	
	
	.projImg{border:1px solid #ccc; height:158px;margin-bottom:15px;display:block;background-color:#f1f1f1;}
	.projName .name,a.addProject{font-size:120%;font-weight:bold;}
	
	.projInfo{position:absolute;bottom:5px;right:10px;display:none;}
	.projectBox:hover .projInfo{position:absolute;bottom:5px;right:10px;display:block;}
	
	.revertFlip{position:absolute;bottom:5px;right:10px;}
	
	.item{border:1px solid #ccc;}
	.main{background-color:#f9f9f9;}
	
	
	
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
		<div id="createProject" class="projectBox details">
			<div class="norm">
				<a href="#" class="projImg addNewProj addProject">
					<img src="<?php echo ProjectModule::get()->getAssetsUrl().'/add-project.png'; ?>"  />
				</a>
				<a href="" class="addProject">Create new project</a>
			</div>
			<div class="create" style="display:none;">
				<div class="projImg" style="margin-bottom:5px;">
					<img src="<?php echo ProjectModule::get()->getAssetsUrl().'/add-project.png'; ?>"  />
				</div>
				<div class="field">
					<div class="inputBox" data-tip="{trigger:focus,gravity:'s'}" title="Type the new projects name">
						<input id="projectInput" name="project" type="text" />
					</div>
<!--					<label for="projectInput" class="hint" style="position:absolute;top:12px;left:11px;">Type the new project's name</label>-->
				</div>
				<div class="field">
					<button class="btn btnN createProject aristo">Create</button><a class="cancelNewProject mll" href="#">Cancel</a>
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


	$('.projList').delegate('.projDelete','click',function(){
		$projectBox = $(this).closest('.projectBox');
		//if(confirm('Are you sure you want to delete the "'+$projectBox.find('.projName .name').text()+'" project?')){
			$projectBox.closest('li').hide('normal', function(){
				$(this).remove();
			});
			$.post("<?php echo NHtml::url('/project/index/delete') ?>",{id:$projectBox.data('id')},function(){});
		//}
		return false;
	});
	$('.projList').delegate('.projInfo','click',function(){
		var $pBox = $(this).closest('.projectBox');
		$pBox.addClass('noShadow').flip({
			direction:'rl',
			speed:150,
			color:'#fff',
			content:$pBox.find('.projFlip'),
			onEnd:function(){
				$pBox.removeClass('noShadow')
			}
		});
		return false;
	});
	$('.projList').delegate('.revertFlip','click',function(){
		var $pBox = $(this).closest('.projectBox');
		$pBox.addClass('noShadow').revertFlip();
		return false;
	});
	
	
	$('.addProject').click(function(){
		$('.norm').hide();
		$('.create').show();
		$('#createProject').addClass('creating')
		$('#projectInput').val('').focus().closest('.inputBox').tipsy("show");
		return false;
	});
	$('.cancelNewProject').click(function(){
		$('.norm').show();
		$('.create').hide();
		$('#projectInput').closest('.inputBox').tipsy("hide");
		$('#createProject').removeClass('creating')
		return false;
	});
	$('.createProject').click(function(){
		var projName = $('#projectInput').val();
		//var $el = $('<li><div class="projectBox"><div class="projImg"></div><div class="projName"><span class="name">'+projName+'</span></div></div></li>')
		$('#projectInput').closest('.inputBox').tipsy("hide");
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