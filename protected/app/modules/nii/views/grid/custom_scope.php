<form id="customScopeForm" method="post" class="form-horizontal">
<?php
$url = array('/nii/grid/updateCustomScope/', 'gridId'=>$gridId);
if ($formAction=='edit')
	$url['scopeId']=$scopeId;
?>
<div class="control-group">
	<?php echo CHtml::label($this->t('Name:'), 'scopeName', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo CHtml::textField('scopeName', @$scope['scopeName'], array('class'=>'span4')); ?>
	</div>
</div>
<div class="control-group">
	<?php echo CHtml::label($this->t('Description:'), 'scopeDescription', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo CHtml::textArea('scopeDescription', @$scope['scopeDescription'], array('rows'=>2, 'class'=>'span4')); ?>
	</div>
</div>
<div class="control-group">
	<?php echo CHtml::label($this->t('Matches:'),'match', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php
			$match_and = '';
			$match_or = '';
			if(isset($scope['match']) && $scope['match'])
				$match_or = ' checked="checked"';
			else 
				$match_and = ' checked="checked"';
		?>
		<label class="radio">
			<input type="radio" name="match"<?php echo $match_and ?> id="match_0" value="AND">
			ALL of the rules
		</label>
		<label class="radio">
			<input type="radio" name="match"<?php echo $match_or ?> id="match_1" value="OR">
			ANY of the rules
		</label>
		<?php //echo CHtml::radioButtonList('match', $match, array('AND'=>'ALL of the rules','OR'=>'ANY of the rules'), array('separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
	</div>
</div>
<h3 class="ptm pbn mtm mbs topLine"><?php echo $this->t('Rules'); ?></h3>
<div id="customScopes">
	<?php 
	if ($formAction == 'edit')
		$this->renderPartial('scope/_rules', array('model'=>$model, 'fields'=>$fields, 'scope'=>$scope, 'cs'=>$cs));
	else 
		$this->renderPartial('ajax/_new_custom_scope', array('model'=>$model, 'fields'=>$fields, 'count'=>1)); 
	?>
</div>
<?php echo CHtml::hiddenField('formModel', $className); ?>
</form>
<script>
	$(function(){

		ajaxUrl = "<?php echo CHtml::normalizeUrl(array('/nii/grid/ajaxNewCustomScope/','model'=>$className)); ?>";
		
		$('#customScopeForm').delegate('.customScopeAdd','click',function() {
			var filterCount = ($('.customScope').length +1);
			$.ajax({
				url: ajaxUrl,
				data: 'count='+filterCount,
				dataType: "html",
				type: 'get',
				success: function(response) {
					$('#customScopes').append(response);
					$('#filter-'+filterCount).effect("highlight",2000);
					$('.customScope:first .customScopeDelete').removeClass('hidden');
				}
			});
			return false;
		});
		
			
		$('#customScopeForm').delegate('.customScopeDelete','click',function() {
			$(this).parent().parent().remove();
			$.each($('.customScope'), function(itemCount){
				itemCount++;
				$('.filterCount', this).html(itemCount);
				$(this).attr('id', 'filter-'+itemCount);
				$('.filterValue', this).attr('id', 'filterValue-'+itemCount);
				$('.filterField', this).attr('id', 'filterField-'+itemCount);
				$('.filterField', this).attr('name', 'rule['+itemCount+'][field]');
				$('.filterValue', this).attr('name', 'rule['+itemCount+'][value]');
				$('.searchMethod', this).attr('name', 'rule['+itemCount+'][searchMethod]');
				if (itemCount==1) {
					$('.customScope:first .customScopeDelete').addClass('hidden');
				} else {
					$('.customScope:first .customScopeDelete').removeClass('hidden');
				}
			});
			return false;
		});
		
		$('#customScopeForm').delegate('.filterField','change',function(){
			
			var model = $('#formModel').val();
			var selectedField = $(this).val();
			var valueID = $(this).attr('data-id');
			url = '<?php echo Yii::app()->baseUrl; ?>/nii/grid/ajaxUpdateCustomScopeValueBlock/model/'+model+'/field/'+selectedField+'/id/'+valueID+'/';
			$.ajax({
				url: url,
				dataType: 'html',
				type: 'get',
				success: function(response) {
					$('#filterFields-'+valueID).html(response);
				}
			});
			return false;
		});

	});

</script>