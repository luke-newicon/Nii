<?php $form = $this->beginWidget('NActiveForm', array(
		'id' => 'groupRuleForm',
		'enableAjaxValidation' => false,
		'action' => array('/contact/group/saveGroupRules','id'=>$group->id),
	)); 
?>
<div class="page-header">
	<h3>Rules</h3>
	<div class="action-buttons"><?php echo CHtml::submitButton('Save',array('class'=>'btn primary', 'id'=>'','name'=>'')) ?></div>
</div>
<div id="groupRules">
	<div class="line pbs">
		<div class="unit size2of10"><div class="lbl">Grouping</div></div>
		<div class="unit size3of10"><div class="lbl">Field</div></div>
			<div class="lastUnit"><div class="lbl">Search Options</div></div>
	</div>
	<?php 
	if ($group->filterScopes) {
		$rules = CJSON::decode($group->filterScopes);
		$this->renderPartial('view/rules/_currentRules', array('groupRules'=>$rules, 'ruleModel'=>$ruleModel));
	} else
		$this->renderPartial('view/rules/_newRule', array('model'=>$model, 'ruleModel'=>$ruleModel, 'count'=>1)); ?>
</div>
<?php $this->endWidget(); ?>
<div class="page-header ptm">
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
<script>
	$(function(){

		ajaxUrl = "<?php echo CHtml::normalizeUrl(array('/contact/group/addRule/')); ?>";
		
		$('#groupRuleForm').delegate('.groupRuleAdd','click',function() {
			var ruleCount = ($('.groupRule').length +1);
			$.ajax({
				url: ajaxUrl,
				data: 'count='+ruleCount,
				dataType: "html",
				type: 'get',
				success: function(response) {
					$('#groupRules').append(response);
					$('#rule-'+ruleCount).effect("highlight",2000);
					$('.groupRule:first .groupRuleDelete').removeClass('hidden');
				}
			});
			return false;
		});
		
			
		$('#groupRuleForm').delegate('.groupRuleDelete','click',function() {
			$(this).parent().parent().remove();
			$.each($('.groupRule'), function(itemCount){
				itemCount++;
				// IDs
				$(this).attr('id', 'rule-'+itemCount);
				$('.ruleGrouping', this).attr('data-id', itemCount);
				$('.ruleGrouping', this).attr('id', 'ruleGrouping-'+itemCount);
				
				$('.ruleValue', this).attr('id', 'ruleValue-'+itemCount);
				$('.searchMethod', this).attr('id', 'searchMethod-'+itemCount);
				$('.ruleFieldBox', this).attr('id', 'ruleField-'+itemCount);
				$('.ruleSearchBox', this).attr('id', 'ruleSearchBox-'+itemCount);
				// Names
				$('.ruleGrouping', this).attr('name', 'rule['+itemCount+'][grouping]');
				$('.ruleField', this).attr('name', 'rule['+itemCount+'][field]');
				$('.ruleValue', this).attr('name', 'rule['+itemCount+'][value]');
				$('.searchMethod', this).attr('name', 'rule['+itemCount+'][searchMethod]');
				// Buttons
				if (itemCount==1) {
					$('.groupRule:first .groupRuleDelete').addClass('hidden');
				} else {
					$('.groupRule:first .groupRuleDelete').removeClass('hidden');
				}
			});
			return false;
		});
		
		$('#groupRuleForm').delegate('.ruleGrouping','change',function(){
			
			var selectedGrouping = $(this).val();
			var valueID = $(this).attr('data-id');
			url = '<?php echo Yii::app()->baseUrl; ?>/contact/group/ajaxRuleField/grouping/'+selectedGrouping+'/id/'+valueID+'/';
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
		
		$('#groupRuleForm').delegate('.ruleField','change',function(){
			
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