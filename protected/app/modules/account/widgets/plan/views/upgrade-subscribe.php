<?php
/**
 * This view file shows the upgrade box for the plan on the upgrade checkout page
 */
?>
<div class="planBox buyCool mll">
	<div class="hd txtC">
		<h3><?php echo $plan['title']; ?></h3>
	</div>
	<div class="bd txtC">
		<p class="projects ptm pbm"><?php echo $plan['projects']; ?> Projects</p>
	</div>
	<div class="ft txtC ptm pbm">
		<span class="price "><strong>&pound;<?php echo $plan['price']; ?></strong> / month</span>
	</div>
</div>