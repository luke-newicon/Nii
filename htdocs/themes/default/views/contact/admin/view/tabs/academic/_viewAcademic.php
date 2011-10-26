<?php echo THelper::checkAccess(NHtml::btnLink($this->t('Edit'), '#', 'fam-pencil', array('class' => 'right-button', 'id' => 'academic-edit-button'))); ?><h3>Academic Details</h3>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Examiner'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo THelper::formatBool($model->examiner, 'Y', 'N', true); ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of2">
		<div class="unit size2of5"><?php echo $this->t('Internal') ?></div>
		<div class="lastUnit">
			<div class="detailBox w50">
				<?php echo THelper::formatBool($model->internal, 'Y', 'N', true); ?>
			</div>
		</div>
	</div>
	<div class="lastUnit">
		<div class="unit size2of5"><?php echo $this->t('External'); ?></div>
		<div class="lastUnit">
			<div class="detailBox w50">
				<?php echo THelper::formatBool($model->external, 'Y', 'N', true); ?>
			</div>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Unavailable'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w50">
			<?php echo $model->unavailable; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Institution'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $model->institution ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Department'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $model->department ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Position'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $model->position ?>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#academic-edit-button').click(function(){
			var selected = $( "#tabs" ).tabs( "option", "selected" )+1;
			$("#ui-tabs-"+selected).html('Loading...').load('<?php echo Yii::app()->baseUrl ?>/contact/academicDetails/cid/<?php echo $cid ?>/mode/edit');
		});
		
	});
</script>
