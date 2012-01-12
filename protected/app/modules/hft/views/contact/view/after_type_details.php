<div class="detailRow">
		<div class="unit size1of6 detailLabel"><?=$this->t('Status')?></div>
		<div class="lastUnit"><?php echo $model->status; ?></div>
</div>
<div class="detailRow">
	<div class="unit size1of2">
		<div class="unit size1of3 detailLabel"><?=$this->t('Communication')?></div>
		<div class="lastUnit">
			<div class="unit size1of2"><?php echo $this->t('Email') . '&nbsp;&nbsp;&nbsp;' . NHtml::boolImage($model->receive_emails); ?></div>
			<div class="lastUnit"><?php echo $this->t('Letter') . '&nbsp;&nbsp;&nbsp;' . NHtml::boolImage($model->receive_letters); ?></div>
		</div>
	</div>
</div>
<div class="detailRow">
		<div class="unit size1of6 detailLabel"><?=$this->t('Source')?></div>
		<div class="lastUnit"><?php echo ($model->source) ? $model->source->name : '<span class="noData">unknown</span>'; ?></div>
</div>