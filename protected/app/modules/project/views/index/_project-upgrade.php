<?php $plan = Yii::app()->user->account->plan; ?>
<div class="projectBox details">
	<div class="norm txtC ">
		<h3>Need More Projects?</h3>

		<div class="ptl">
			Your current <strong><?php echo $plan['title']; ?></strong> plan
			only allows <strong><?php echo $plan['projects']; ?> <?php echo ($plan['projects']==1) ? "Project" : "Projects"; ?></strong>
		</div>

		<div class="ui-state-highlight" style="padding:15px 15px 5px 15px;margin-top:45px;">
			<div>
				<a onclick="window.userAccountView.upgradeTo();return false;" class="btn aristo primary" style="font-size:180%;padding: 5px 25px;">Upgrade</a>
			</div>
			<div class="pas">
				<?php $nextPlan = Plan::getNextPlan(); ?>
				to <strong><?php echo $nextPlan['title']; ?></strong> and get <br/><strong><?php echo $nextPlan['projects']; ?> Projects.</strong>
			</div>
		</div>
	</div>
</div>