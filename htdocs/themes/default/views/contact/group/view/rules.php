<div class="page-header">
	<h3>Rules</h3>
	
</div>
<?php // Display current rules ?>
<?php //$this->renderPartial('view/rules/_currentRules', array('model'=>$model, 'ruleModel'=>$ruleModel)); ?>
<?php $count=1;
$this->renderPartial('view/rules/_newRule', array('model'=>$model, 'ruleModel'=>$ruleModel, 'count'=>$count)); ?>
<div class="page-header">
	<h3>Rule-based Members</h3>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ContactGroupRuleMembersGrid',
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
)); ?>
<?php echo CHtml::textField('formModel', get_class($ruleModel)) ?>
<script>
	$(function(){

		ajaxUrl = "<?php echo CHtml::normalizeUrl(array('/contact/group/addRule/','model'=>get_class($model))); ?>";
		
		$('#groupRulesForm').delegate('.groupRulesAdd','click',function() {
			var filterCount = ($('.groupRules').length +1);
			$.ajax({
				url: ajaxUrl,
				data: 'count='+filterCount,
				dataType: "html",
				type: 'get',
				success: function(response) {
					$('#groupRuless').append(response);
					$('#filter-'+filterCount).effect("highlight",2000);
					$('.groupRules:first .groupRulesDelete').removeClass('hidden');
				}
			});
			return false;
		});
		
			
		$('#groupRulesForm').delegate('.groupRulesDelete','click',function() {
			$(this).parent().parent().remove();
			$.each($('.groupRules'), function(itemCount){
				itemCount++;
				$('.filterCount', this).html(itemCount);
				$(this).attr('id', 'filter-'+itemCount);
				$('.filterValue', this).attr('id', 'filterValue-'+itemCount);
				$('.filterField', this).attr('id', 'filterField-'+itemCount);
				$('.filterField', this).attr('name', 'rule['+itemCount+'][field]');
				$('.filterValue', this).attr('name', 'rule['+itemCount+'][value]');
				$('.searchMethod', this).attr('name', 'rule['+itemCount+'][searchMethod]');
				if (itemCount==1) {
					$('.groupRules:first .groupRulesDelete').addClass('hidden');
				} else {
					$('.groupRules:first .groupRulesDelete').removeClass('hidden');
				}
			});
			return false;
		});
		
		$('#groupRulesForm').delegate('.ruleGrouping','change',function(){
			
			var model = $('#formModel').val();
			var selectedGrouping = $(this).val();
			var valueID = $(this).attr('data-id');
			url = '<?php echo Yii::app()->baseUrl; ?>/contact/group/ajaxRuleField/model/'+model+'/grouping/'+selectedGrouping+'/id/'+valueID+'/';
			$.ajax({
				url: url,
				dataType: 'html',
				type: 'get',
				success: function(response) {
					$('#ruleField-'+valueID).html(response);
				}
			});
			return false;
		});
		
		$('#groupRulesForm').delegate('.ruleField','change',function(){
			
			var valueID = $(this).attr('data-id');
			var grouping = $('#ruleGrouping-'+valueID).val();
			var selectedField = $(this).val();
			url = '<?php echo Yii::app()->baseUrl; ?>/contact/group/ajaxRuleSearchBox/grouping/'+grouping+'/field/'+selectedField+'/id/'+valueID+'/';
			$.ajax({
				url: url,
				dataType: 'html',
				type: 'get',
				success: function(response) {
					$('#ruleSearchBox-'+valueID).html(response);
				}
			});
			return false;
		});

	});

</script>