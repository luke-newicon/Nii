<?php echo THelper::checkAccess(NHtml::btnLink($this->t('Edit'), '#', 'fam-pencil', array('class' => 'right-button', 'id' => 'cleric-edit-button'))); ?><h3>Cleric Details</h3>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Cleric Type'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo $model->type; ?>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#cleric-edit-button').click(function(){
			var selected = $( "#tabs" ).tabs( "option", "selected" )+1;
			$("#ui-tabs-"+selected).html('Loading...').load('<?php echo Yii::app()->baseUrl ?>/contact/clericDetails/cid/<?php echo $cid ?>/mode/edit');
		});
		
	});
</script>
