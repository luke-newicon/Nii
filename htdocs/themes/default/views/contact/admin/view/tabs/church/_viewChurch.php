<?php echo THelper::checkAccess(NHtml::btnLink($this->t('Edit'), '#', 'fam-pencil', array('class' => 'right-button', 'id' => 'church-edit-button'))); ?>
<h3>Church Details</h3>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Contact Officer'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo $model->contact_officer; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Vicar / Pastor'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $model->vicar_pastor; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Denomination'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $model->denomination; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Diocese'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $model->dioceseName; ?>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#church-edit-button').click(function(){
			var selected = $( "#tabs" ).tabs( "option", "selected" )+1;
			$("#ui-tabs-"+selected).html('Loading...').load('<?php echo Yii::app()->baseUrl ?>/contact/churchDetails/cid/<?php echo $cid ?>/mode/edit');
		});
		
	});
</script>