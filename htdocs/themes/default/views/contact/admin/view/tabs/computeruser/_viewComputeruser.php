<h3>Computer User Details</h3>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t("Student's Number"); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo $model->sn; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t("Student's Full Name"); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo $model->cn; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t("Student's Username"); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo $model->uid; ?>
		</div>
	</div>
</div>