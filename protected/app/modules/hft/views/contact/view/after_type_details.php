<?php if ($model->contact_type=='Person') { ?>
<div class="detailRow ptm">
	<div class="unit size1of6 detailLabel"><?php echo $this->t('Organisation')?></div>
	<div class="lastUnit"><?php echo $model->company_name ? $model->company_name : '<span class="noData">No organisation set</span>'; ?></div>
</div>
<?php } ?>
<div class="detailRow">
	<div class="unit size1of6 detailLabel"><?php echo $this->t('Position')?></div>
	<div class="lastUnit"><?php echo $model->company_position  ? $model->company_position : '<span class="noData">No position set</span>'; ?></div>
</div>
<div class="detailRow">
		<div class="unit size1of6 detailLabel"><?php echo $this->t('Status')?></div>
		<div class="lastUnit"><?php echo $model->status; ?></div>
</div>
<div class="detailRow">
	<div class="unit size1of2">
		<div class="unit size1of3 detailLabel"><?php echo $this->t('Communication')?></div>
		<div class="lastUnit">
			<div class="unit size1of2"><?php echo $this->t('Email') . '&nbsp;&nbsp;&nbsp;' . NHtml::boolImage($model->receive_emails); ?></div>
			<div class="lastUnit"><?php echo $this->t('Letter') . '&nbsp;&nbsp;&nbsp;' . NHtml::boolImage($model->receive_letters); ?></div>
		</div>
	</div>
</div>
<div class="detailRow">
		<div class="unit size1of6 detailLabel"><?php echo $this->t('Source')?></div>
		<div class="lastUnit"><?php echo ($model->source) ? $model->source->name : '<span class="noData">unknown</span>'; ?></div>
</div>