<div class="detailRow ptm">
	<div class="unit size1of2">
		<div class="unit size1of3 detailLabel"><?=$this->t('DOB')?></div>
		<div class="lastUnit"><?php echo NHtml::formatDate($model->dob); ?></div>
	</div>
	<div class="lastUnit pll">
		<div class="unit size1of3 detailLabel"><?=$this->t('Sex')?></div>
		<div class="lastUnit"><?php echo ($model->gender=='M')?'Male':(($model->gender=='F')?'Female':'<span class="noData">unknown</span>'); ?></div>
	</div>
</div>