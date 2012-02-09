<?php $this->pageTitle = Yii::app()->name . ' - Tasks'; ?>
<div class="page-header">
	<h1>Tasks</h1>
	<div class="action-buttons">
		<?php if(Yii::app()->user->checkAccess('task/admin/addTask')) : ?>
		<a class="btn primary" href="<?php echo CHtml::normalizeUrl(array('/task/admin/addTask')) ?>">Add a Task</a>
		<?php endif; ?>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
	'id' => 'TaskTabs',
	'items' => array(
		array('label'=>'My Tasks', 'url'=>'#mytasks', 'active' => true),
		array('label'=>'Group Tasks', 'url'=>'#grouptasks'),
	),
//	'htmlOptions' => array('class' => 'tabs vertical'),
//	'heading' => 'Developer Tools',
));
?>
<div class="tab-content vertical">
	<div id="mytasks" class="active">
		<?php
		$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
			'dataProvider' => $dataProvider,
			'filter' => $model,
			'id' => 'task-grid',
			'enableButtons' => false,
			'enableCustomScopes' => false,
			'scopes' => array('enableCustomScopes' => false),
			'columns' => array(
				'id' => array(
					'name' => 'id',
					'htmlOptions' => array('width' => '100px'),
				),
				'name' => array(
					'name' => 'name',
					'type' => 'raw',
					'value' => '$data->viewLink(NHtml::hilightText($data->name, $this->grid->filter->name))',
				),
				'project' => array(
					'name' => 'project_name',
					'type' => 'raw',
					'value' => '$data->viewProject()',
				),
				'customer' => array(
					'name' => 'customer_name',
					'type' => 'raw',
					'value' => '$data->viewCustomer()',
				),
//				'priority' => array(
//					'name' => 'priority',
//					'htmlOptions' => array('width' => '100px'),
//				),
//				'importance' => array(
//					'name' => 'importance',
//					'htmlOptions' => array('width' => '100px'),
//				),
				'finish_date' => array(
					'name' => 'finish_date',
					'htmlOptions' => array('width' => '100px'),
				),
				'owner' => array(
					'name' => 'owner',
					'htmlOptions' => array('width' => '250px'),
				),
			),
		));
		?>
		<?php if(Yii::app()->user->checkAccess('task/admin/addTask')) : ?>
		<div class="modal hide fade" id="modal-add-task">
			<div class="modal-header">
				<a class="close" href="#">×</a>
				<h3>Add a Task</h3>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<a id="add-task-save" class="btn primary" href="#">Save</a>
			</div>
		</div>
	</div>
	<div id="grouptasks"></div>
</div>
<script>
	jQuery(function($){
		$('#TaskTabs').tabs();
	});
</script>
<script>
	jQuery(function($){
		
		$('#modal-add-task').bind('show',function(){
			$(this).find('.modal-body').load("<?php echo CHtml::normalizeUrl(array('/task/admin/addTask')) ?>");
		});
		
		$('#add-task-save').click(function(){
			$('#add-task-form').submit();
			return false;
		});
				
		$('#modal-add-task').delegate('#add-task-form','submit',function(){
			$.ajax({
				url: $(this).attr('action'),
				data: jQuery('#add-task-form').serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						$.fn.yiiGridView.update('task-grid');
						$('#modal-add-task').modal('hide');
					} else {
						alert(response.error);
					}
				},
				error: function() {
					alert("JSON failed to return a valid response");
				}
			});
			return false;
		});
	});
</script>
<?php endif; ?>