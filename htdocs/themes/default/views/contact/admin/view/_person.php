<div class="line ptm">
	<div class="unit size1of2">
		<div class="unit size1of3"><?=$this->t('DOB')?></div>
		<div class="lastUnit"><?php echo NHtml::formatDate($model->dob); ?></div>
	</div>
	<div class="unit size1of2">
		<div class="unit size1of3"><?=$this->t('Sex')?></div>
		<div class="lastUnit"><?php echo ($model->gender=='M')?'Male':(($model->gender=='F')?'Female':'<span class="noData">unknown</span>'); ?></div>
	</div>
</div>