<div class="line">
	<div class="unit pll prl pbl ptm">
		<div class="small-callout">YOUR PLAN</div>
		<?php $this->widget('account.widgets.plan.PlanBox'); ?>
	</div>
	<div class="lastUnit ptm pll prl pbl ">
		<div class="small-callout">UPGRADE</div>
		
		<?php $userPlan = Plan::getPlan(Yii::app()->user->record->plan); ?>
		<?php foreach(Plan::$plans as $k => $plan): ?>
			<?php $this->widget('account.widgets.plan.PlanBox',array('upgradeDowngrade'=>true, 'plan'=>$k)); ?>
		<?php endforeach; ?>
		
	</div>
</div>