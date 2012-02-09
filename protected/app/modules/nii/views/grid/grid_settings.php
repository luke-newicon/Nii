<!--<form id="gridSettingsForm" method="post">-->
<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'gridSettingsForm',
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
));
$className = get_class($model);
$columns = NData::visibleColumns($className, $gridId);
?>
	<?php foreach ($columns as $key => $value) : ?>
		<div class="line">
			<i class="icon-resize-vertical"></i>
			<?php echo $form->checkBoxField($model, $key); ?>
			<?php //echo CHtml::checkBox($key, $value, array('style' => 'margin-right: 8px;', 'uncheckValue' => '0')); ?>
			<?php //echo CHtml::label($model->getAttributeLabel($key), $key); ?>
		</div>
	<?php endforeach; ?>
<?php $this->endWidget(); ?>