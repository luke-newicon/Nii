<div class="line">
	<div class="unit size1of3">
		<?php if($overallProjectStats['good']>0): ?>
		<div class="mod simple healthy">
				<b class="top"><b class="tl"></b><b class="tr"></b></b>
				<div class="inner">
					<div class="hd">
						<h3>Healthy</h3>
					</div>
					<div class="bd">
						<p>Active Projects: <?php echo $overallProjectStats['good'] ?></p>
					</div>
				</div>
				<b class="bottom"><b class="bl"></b><b class="br"></b></b>
			</div>
		<?php endif; ?>
	</div>
	<div class="unit size1of3">
		<?php if($overallProjectStats['warnings']>0): ?>
		<div class="mod simple">
				<b class="top"><b class="tl"></b><b class="tr"></b></b>
				<div class="inner">
					<div class="hd">
						<h3>Warnings</h3>
					</div>
					<div class="bd">
						<p>Nearing Completion: <?php echo $overallProjectStats['warnings'] ?></p>
					</div>
				</div>
				<b class="bottom"><b class="bl"></b><b class="br"></b></b>
			</div>
		<?php endif; ?>
	</div>
	<div class="unit size1of3 lastUnit">
		<?php if($overallProjectStats['bad']>0): ?>
		<div class="mod simple">
				<b class="top"><b class="tl"></b><b class="tr"></b></b>
				<div class="inner">
					<div class="hd">
						<h3>Problems </h3>
					</div>
					<div class="bd">
						<p>Overdue: <?php echo $overallProjectStats['bad'] ?></p>
						<p>Over Hours: <?php echo $overallProjectStats['bad'] ?></p>
					</div>
				</div>
				<b class="bottom"><b class="bl"></b><b class="br"></b></b>
			</div>
		<?php endif; ?>
	</div>
</div>