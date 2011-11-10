<div class="smallPlanBox upgrade mtl">
	<div class="plan"><?php echo $plan['title']; ?></div>
	<div class="line">
		<div class="unit size1of3 pts txtL">
			<?php if($plan['price'] == 'free'): ?>
				Free
			<?php else: ?>
				<strong>&pound;<?php echo $plan['price']; ?></strong> <span class="hint">/ month</span>
			<?php endif; ?>	
		</div>
		<div class="unit size1of3 pts ">
			<strong>
				<?php if($plan['projects'] == 'unlimited'): ?>
					No Limits!
				<?php elseif($plan['projects'] == 1): ?>
					1 Project
				<?php else: ?>
					<?php echo $plan['projects']; ?> Projects
				<?php endif; ?>
			</strong>
		</div>
		<div class="lastUnit txtR">
			<a onclick="userAccountView.upgradeTo('<?php echo $plan['code'] ?>');return false;" class="btn aristo primary" href="#">Upgrade</a>
		</div>
	</div>
</div>