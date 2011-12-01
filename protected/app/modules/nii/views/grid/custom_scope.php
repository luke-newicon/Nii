<form id="customScopeForm" method="post">
<?php
$url = array('/nii/grid/updateCustomScope/', 'gridId'=>$gridId);
if ($formAction=='edit')
	$url['scopeId']=$scopeId;
?>
	<div class="line pbm">
		<div class="unit size1of5 ptm">
				<?php echo Chtml::label($this->t('Name:'), 'scopeName', array('style'=>'font-weight:bold;')); ?>
		</div>
		<div class="lastUnit">
			<div class="field">
			<div class="input w300">
				<?php echo CHtml::textField('scopeName', @$scope['scopeName']); ?>
			</div>
			</div>
		</div>
	</div>
	<div class="line pbm">
		<div class="unit size1of5 ptm">
				<?php echo Chtml::label($this->t('Description:'), 'scopeDescription', array('style'=>'font-weight:bold;')); ?>
		</div>
		<div class="lastUnit">
			<div class="field">
			<div class="input w300">
				<?php echo CHtml::textArea('scopeDescription', @$scope['scopeDescription'], array('rows'=>2)); ?>
			</div>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="unit size1of5">
			<?php echo CHtml::label($this->t('Matches:'),'match', array('style'=>'font-weight:bold;')).'&nbsp;&nbsp;&nbsp;'; ?>
		</div>
		<div class="lastUnit">
			<?php $match = (isset($scope['match'])) ? $scope['match'] : 'AND';
			echo CHtml::radioButtonList('match', $match, array('AND'=>'ALL of the rules','OR'=>'ANY of the rules'), array('separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
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