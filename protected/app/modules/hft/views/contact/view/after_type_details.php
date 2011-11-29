<div class="detailRow">
	<div class="unit size1of2">
		<div class="unit size1of3 detailLabel"><?=$this->t('Newsletter')?></div>
		<div class="lastUnit"><?php echo NHtml::formatBool($model->newsletter); ?></div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of2">
		<div class="unit size1of3 detailLabel"><?=$this->t('Source')?></div>
		<div class="lastUnit"><?php echo ($model->source) ? $model->source->name : '<span class="noData">unknown</span>'; ?></div>
	</div>
</div>