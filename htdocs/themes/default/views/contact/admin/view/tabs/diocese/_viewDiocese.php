<?php echo THelper::checkAccess(NHtml::btnLink($this->t('Edit'), '#', 'fam-pencil', array('class' => 'right-button', 'id' => 'diocese-edit-button'))); ?><h3>Diocese Details</h3>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Diocese Index'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo $model->diocese_index; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Bishop'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $model->bishopName; ?>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#diocese-edit-button').click(function(){
			var selected = $( "#tabs" ).tabs( "option", "selected" )+1;
			$("#ui-tabs-"+selected).html('Loading...').load('<?php echo Yii::app()->baseUrl ?>/contact/dioceseDetails/cid/<?php echo $cid ?>/mode/edit');
		});
		
	});
</script>
