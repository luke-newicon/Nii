<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'authitem',
	'enableAjaxValidation'=>true,
	'focus'=>array($model,'name'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>


<?php
// array('data'=>'node 1', 'children'=>array('node 2', 'node 3'))
$this->Widget('application.widgets.jstree.CJsTree', array(
	'id'=>'permissions',
	'core'=>array('animation'=>0),
	'json_data'=>array(
		'data'=>$permissions
	),
//	'html_data'=>array(
//		'data'=>'<div id="demo1">
//		<ul>
//			<li>
//				<a href="some_value_here">Node title</a>
//				<ul>
//					<li><a href="some_value_here 1">Node title 1</a></li>
//					<li><a href="some_value_here 2">Node title 2</a>
//						<ul>
//							<li><a href="some_value_here 1">Node title 1</a></li>
//							<li><a href="some_value_here 2">Node title 2</a></li>
//						</ul>
//					</li>
//				</ul>
//
//			</li>
//		</ul>
//		</div>'
//	),
	'themes'=>array('theme'=>'ni'),
	'plugins'=>array("themes", "json_data", "checkbox"),
));
?>


<a href="#" onclick="jQuery('#permissions').jstree('get_checked').each(function(i, el){alert($(el).text())});return false;">get checked</a>