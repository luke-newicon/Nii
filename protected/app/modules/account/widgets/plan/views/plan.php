<div class="planBox mtl" style="width:165px;">
	<div class="hd txtC">
		<h3><?php echo $plan['title']; ?></h3>
	</div>
	<div class="bd txtC">
		<p class="projects ptm pbm"><?php echo $plan['projects']; echo ($plan['projects'] == 0) ? ' Project' : ' Projects'; ?></p>
		<ul class="noBull">
			<li><strong>unlimited</strong> screens</li>
			<li><strong><?php echo $plan['collaborators']; ?></strong> collaborators</li>
			<li><strong>unlimited</strong> sharing</li>
		</ul>
	</div>
	<div class="ft txtC ptm pbl">
		<span class="price ">
			<?php if($plan['price'] == 'free'): ?>
				Free
			<?php else: ?>
				<strong>&pound;<?php echo $plan['price']; ?></strong> / month
			<?php endif; ?>
		</span>
	</div>
</div>