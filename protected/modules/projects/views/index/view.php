
<?php
$this->breadcrumbs = array(
	'Projects Projects' => array('index'),
	$model->name,
);

$this->menu = array(
	array('label' => 'List ProjectsProject', 'url' => array('index')),
	array('label' => 'Create ProjectsProject', 'url' => array('create')),
	array('label' => 'Update ProjectsProject', 'url' => array('update', 'id' => $model->id)),
	array('label' => 'Delete ProjectsProject', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => 'Manage ProjectsProject', 'url' => array('admin')),
);
?>
<div class="page liquid">
	<div class="head"></div>
	<div class="body">
		<div class="leftCol gMail">
			<div>People:
			</div>
			<div>Support staff:</div>
		</div>
		<div class="main">
			<h1><?php echo $model->name; ?></h1>
			<?php
			$this->widget('zii.widgets.CDetailView', array(
				'data' => $model,
				'attributes' => array(
					'code',
					array('name'=>'description'),
					array('name'=>'created','value'=>$model->created.' ( '.$model->createdBy->username.' )'),
					array('name'=>'status')),
				'nullDisplay'=>'-'));
			?>
			<h2>Issues</h2>
		</div>

		<?php
		$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$modelProjectsIssue->search(),
		'filter'=>$modelProjectsIssue,
		'emptyText'=>'There are no issues set against this project.',
		'columns'=>array(
		array('name'=>'id','htmlOptions'=>array('class'=>'issueId')),
		'type',
		array('name'=>'name', 'htmlOptions'=>array('class'=>'issueNameCell') ,'value'=>'"<a href=\"#\" class=\"issueName\">".$data->name."</div>"','type'=>'html'),
		'description',
		'status',
		'created',
		'estimated_time',
		'out_of_scope')
		));
		?>

		<script>
			//Opens the view issue dialog.
			$('.issueName').click(function() {
				var thisParant = $(this).parent().parent();
				var issueId = thisParant.children('.issueId').html();
				var issueName = thisParant.children('.issueNameCell').html();
				$('#issueDialog').dialog('open').load('<?php echo Yii::app()->createUrl('projects/issue/view/id/1') ?>');
				$("#issueDialog").dialog( "option", "title", issueName);
			});
		</script>

		<?php

		$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
			'id'=>'issueDialog',
			// additional javascript options for the dialog plugin
			'options'=>array(
				'title'=>'Dialog box 1',
				'autoOpen'=>false,
				'dialogClass'=>'notelet'
			),
		));
		$this->endWidget('zii.widgets.jui.CJuiDialog');?>

	</div>
	<div class="foot"><!-- Foot --></div>
</div>
