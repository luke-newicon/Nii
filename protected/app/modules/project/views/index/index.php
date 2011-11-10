<div class="toolbar">
	<div class="line plm">
		<div class="unit titleBarText">
			<span class="hotspot-logo"><a style="width:auto;padding-left:20px;" class="icon hotspot-logo" href="<?php echo NHtml::url('/project/index/index'); ?>"><strong>HOT</strong>SPOT</a></span>
		</div>
		<div class="unit">
			<?php $this->widget('account.widgets.TrialMessage'); ?>
		</div>
	</div>
	<div id="titleBarRightMenu" class="menu">
		<ul>
			<li><a id="userBox" href="#" class="btn aristo"><?php echo Yii::app()->user->getName(); ?><span class="icon fam-bullet-arrow-down mls mrn " style="padding-left:14px;"></span></a></li>
		</ul>
	</div>
</div>
<br />
<div id="overallStats"  class="pll">
	<?php $screenCount = ProjectScreen::model()->count(); ?>
	<?php $projectCount = Project::model()->count(); ?>
	<p style="color:white;text-shadow:0px 1px 0px #000;">You have <?php echo ($screenCount == 1) ? "$screenCount screen" : "$screenCount screens"; ?> across <?php echo ($projectCount==1)?"$projectCount Project":"$projectCount Projects"; ?>.</p>
</div>


<ul id="projectList" class="noBull projList">
	<?php $plan = Yii::app()->user->account->plan; ?>
	<?php $canCreateProject = !($projectCount == $plan['projects']); ?>
	<li id="upgradeProject" class="upgradeProject" style="display:<?php echo ($canCreateProject) ? 'none' : 'block'; ?>;">
		<?php $this->renderPartial('_project-upgrade',array('projectCount'=>$projectCount)); ?>
	</li>
	<li id="newProject" class="newProject" style="display:<?php echo ($canCreateProject) ? 'block' : 'none'; ?>;">
		<div id="createProject" class="projectBox details">
			<div class="norm txtC">
				<a href="#" class="projImg addNewProj addProject">
					<img src="<?php echo ProjectModule::get()->getAssetsUrl().'/images/add-project.png'; ?>"  />
				</a>
				<a href="" class="btn aristo primary large addProject addProjectStyle">Create new project</a>
			</div>
			<div class="create" style="display:none;">
				<div class="projImg" style="margin-bottom:15px;">
					<img src="<?php echo ProjectModule::get()->getAssetsUrl().'/images/add-project.png'; ?>"  />
				</div>
				<div class="field">
					<div class="inputBox" data-tip="{trigger:focus,gravity:'s'}" title="Type the new projects name">
						<input id="projectInput" name="project" type="text" />
					</div>
				</div>
				<div class="field">
					<div class="line">
						<div class="unit size2of3">
							<a class="btn aristo createProject">Create</a>
						</div>
						<div class="lastUnit txtR pts">
							<a class="cancelNewProject mll" href="#">Cancel</a>
						</div>
					</div>
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
	
	$('#projectList').delegate('.projectBox','mouseenter',function(){
		$(this).addClass('hover');
	});

	$('#projectList').delegate('.projectBox','mouseleave',function(){
		$(this).removeClass('hover');
	});

	$('#projectList').delegate('.projDelete','click',function(){
		$projectBox = $(this).closest('.projectBox');
		if(confirm('Are you sure you want to delete the "'+$projectBox.find('.projName .name').text()+'" project? \n\nThis will delete all screens, hotspots and comments, and users will no longer be able to view the project\'s preview experience.')){
			$projectBox.closest('li').hide('normal', function(){
				$(this).remove();
			});
			$.post("<?php echo NHtml::url('/project/index/delete') ?>",{id:$projectBox.data('id')}, function(r){
				window.projectLimit();
			});
		}
		
		return false;
	});
	$('#projectList').delegate('.projFuns','click',function(){
		var $pBox = $(this).closest('.projectBox');
		// could do ajax here to get info
		
		$pBox.addClass('noShadow').flip({
			direction:'rl',
			speed:150,
			color:'#fff',
			content:$pBox.find('.projFlip'),
			onEnd:function(){
				$pBox.removeClass('noShadow')
				$.fn.nii.tipsy();
			}
		});
		return false;
	});
	$('#projectList').delegate('.revertFlip','click',function(){
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
	$('#projectInput').keyup(function(e){
		if((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)){
			$('.createProject').click();
		}
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
		if(projName=='')
			return false;
		$('#projectInput').closest('.inputBox').tipsy("hide");
		$.post("<?php echo NHtml::url('/project/index/create'); ?>",{name:projName},function(r){
			// first lets check for errors.
			if(r.error){
				// now determine error.
				// can be, duplicate name, or project limit
			
				alert(r.error);
			} else {
				$createBox = $('.projList .newProject');
				$new = $(r.result.project).appendTo('body').show()
					.position({my:'left top', at:'left top', of:$createBox}).hide().fadeIn('normal');
				$createBox.fadeOut('normal', function(){
					$('<li>'+r.result.project+'</li>').insertAfter('.projList .newProject');
					$new.remove();
					window.setTimeout(function(){
						$createBox.find('.norm').show();
						$createBox.find('.create').hide();
						$createBox.show('normal');
						$('#createProject').removeClass('creating');
						window.projectLimit();
					}, 300);
				});
			}
		},'json');
	});
});
</script>

<?php $this->renderPartial('/index/account'); ?>

<script>
$(function(){
	<?php if(Yii::app()->user->account->trialExpired()): ?>
	window.userAccountView.upgradeTo('<?php echo Yii::app()->user->record->plan; ?>');
	<?php endif; ?>
});
</script>


<!-- // USER ACCOUNT STUFF! -->