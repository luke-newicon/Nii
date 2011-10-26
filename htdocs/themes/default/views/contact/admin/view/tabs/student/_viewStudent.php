<?php echo THelper::checkAccess(NHtml::btnLink($this->t('Edit'), '#', 'fam-pencil', array('class' => 'right-button', 'id' => 'student-edit-button'))); ?><h3>Student Details</h3>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Student ID'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo $s->id ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('UOB ID Code'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w200">
			<?php echo $s->UOB_idcode ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('International') ?></div>
	<div class="unit">
		<div class="detailBox w50">
			<?php echo $s->international ? "Yes" : "No"; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Nationality'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w250">
			<?php echo $s->nationality; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Learning Support'); ?></div>
	<div class="lastUnit">
		<div class="detailBox w50">
			<?php echo $s->learning_support == "Y" ? "Yes" : "No"; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Learning Support Details'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $s->learning_support_detail ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Academic Qualifications'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $s->academicquals ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Other Qualifications'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $s->otherquals ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Work Experience'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $s->wrkexperience ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Marital Status'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo ucfirst($s->marital) ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5">
		<?php echo $this->t('Spouse'); ?>
	</div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo $s->spousefirst . ' ' . $s->spouselast; ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of5"><?php echo $this->t('Notes about children'); ?></div>
	<div class="lastUnit">
		<div class="detailBox">
			<?php echo ucfirst($s->childrennote) ?>
		</div>
	</div>
</div>
<div class="detailRow">
	<div class="unit size1of2">
		<div class="unit size2of5"><?php echo $this->t('Passport Expiry'); ?></div>
		<div class="lastUnit">
			<div class="detailBox">
				<?php echo THelper::formatDate($s->passport_expiry) ?>
			</div>
		</div>
	</div>
	<div class="lastUnit">
		<div class="unit size2of5"><?php echo $this->t('Visa Expiry'); ?></div>
		<div class="lastUnit">
			<div class="detailBox">
				<?php echo THelper::formatDate($s->visa_expiry) ?>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#student-edit-button').click(function(){
			var selected = $( "#tabs" ).tabs( "option", "selected" )+1;
			$("#ui-tabs-"+selected).html('Loading...').load('<?php echo Yii::app()->baseUrl ?>/contact/studentDetails/cid/<?php echo $cid ?>/mode/edit');
		});
		
	});
</script>
