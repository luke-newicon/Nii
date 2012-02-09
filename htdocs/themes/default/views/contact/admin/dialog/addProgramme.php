<div class="line">
	<div class="field">
		<div class="unit size1of4"><?php echo $this->t('Select a Programme') ?></div>
		<div class="lastUnit">
			<div class="inputBox">
				<?php
				$data = $model->getLiveProgrammes();
				echo NHtml::dropDownList('programme_id', '', $data, array('class' => 'inputInline', 'prompt' => 'select...'));
				?>
			</div>
		</div>
	</div>
</div>
<div class="line" id="addButton">
	<div class="unit size1of3">&nbsp;</div>
	<div class="lastUnit">
		<?php echo NHtml::btnLink($this->t('Add and Continue'), '#', 'icon fam-tick', array('class' => 'btn btnN addContinue', 'id' => 'addContinue', 'style' => 'padding: 3px 5px;')); ?>
	</div>
</div>
<?php echo NHtml::hiddenField('student_id', $model->student->id); ?>
<script>
	$(function(){
		$('#addButton').delegate('.addContinue','click',function(){
			var url = '<?php echo Yii::app()->baseUrl ?>/study/addProgramme/sid/'+$('#student_id').val()+'/pid/'+$('#programme_id').val();
			window.location = url;
		}); 
	});
</script>