<div class="smallPlanBox downgrade mtl">
	<div class="plan"><?php echo $plan['title']; ?></div>
	<div class="line">
		<div class="unit size1of3 pts txtL hint">
			<?php if($plan['price'] == 'free'): ?>
				Free
			<?php else: ?>
				&pound;<?php echo $plan['price']; ?> / month
			<?php endif; ?>	
		</div>
		<div class="unit size1of3 pts hint">
			<?php if($plan['projects'] == 'unlimited'): ?>
				No Limits!
			<?php elseif($plan['projects'] == 1): ?>
				1 Project
			<?php else: ?>
				<?php echo $plan['projects']; ?> Projects
			<?php endif; ?>
		</div>
		<div class="lastUnit txtR hint pts">
			<a onclick="userAccountView.downgradeTo('<?php echo $plan['code'] ?>');return false;" class="" href="#">Downgrade</a>
		</div>
	</div>
</div>