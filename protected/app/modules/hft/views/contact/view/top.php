<div class="detailRow ptm">
	<div class="unit size1of6 detailLabel"><?=$this->t('Contact Type')?></div>
	<div class="lastUnit"><?php echo $model->classificationName; ?></div>
</div>
<div class="detailRow">
	<div class="unit size1of6 detailLabel"><?=$this->t('Account Number')?></div>
	<div class="lastUnit"><?php echo $model->id; ?></div>
</div>
<div class="detailRow ptm">
	<div class="unit size1of6 detailLabel"><?=$this->t('Company Name')?></div>
	<div class="lastUnit"><?php echo $model->company_name ? $model->company_name : '<span class="noData">No organisation set</span>'; ?></div>
</div>
<div class="detailRow">
	<div class="unit size1of6 detailLabel"><?=$this->t('Position')?></div>
	<div class="lastUnit"><?php echo $model->company_position  ? $model->company_position : '<span class="noData">No position set</span>'; ?></div>
</div>