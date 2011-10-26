<?php echo THelper::checkAccess(NHtml::btnLink($this->t('Edit'), '#', 'fam-pencil', array('class' => 'right-button', 'id' => 'staff-edit-button'))); ?>
<h3>Staff Details</h3>
<p class="message">There is no further information related to this relationship</p>
<script>
	$(function(){
		$('#staff-edit-button').click(function(){
			var selected = $( "#tabs" ).tabs( "option", "selected" )+1;
			$("#ui-tabs-"+selected).html('Loading...').load('<?php echo Yii::app()->baseUrl ?>/contact/staffDetails/cid/<?php echo $cid ?>/mode/edit');
		});
		
	});
</script>