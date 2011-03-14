<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php echo CHtml::activeLabel($model, 'to', array('class'=>'unit size1of15 faded','style'=>'width:30px;')); ?>
	<div class="unit lastUnit">
		<?php $this->widget('application.widgets.fbcomplete.FBComplete', array(
			'model'=>$model,
			'attribute'=>'to',
			'dataOptions'=>array(
				'0'=>array('label'=>'Some label'),
				'1'=>array('label'=>'Some label 2')
			),
			'options'=>array(
				'json_url'=>NHtml::url('/docs/contactsComplete'),
				'newel'=>true
			)
		)); ?>
	</div>
</div>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php echo CHtml::activeLabel($model, 'cc', array('class'=>'unit size1of15 faded','style'=>'width:30px;')); ?>
	<div class="unit lastUnit">
		<?php echo CHtml::activeTextField($model, 'cc',array('class'=>'input')); ?>
	</div>
</div>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php echo CHtml::activeLabel($model, 'subject', array('class'=>'unit size1of15 faded','style'=>'width:60px;')); ?>
	<div class="unit lastUnit">
		<?php echo CHtml::activeTextField($model, 'subject',array('class'=>'input')); ?>
	</div>
</div>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php echo CHtml::activeLabel($model, 'from', array('class'=>'unit size1of15 faded','style'=>'width:60px;')); ?>
	<div class="unit lastUnit">
		<?php echo CHtml::activeTextField($model, 'from',array('class'=>'input')); ?>
	</div>
</div>

<div id="emailWysiwyg" class="line" style="border-width:0px 0px 1px 0px; background: none;">

	<?php
	$this->widget('application.extensions.editor.CKkceditor',array(
		"model"=>$model,                # Data-Model
		"attribute"=>'message_html',    # Attribute in the Data-Model,
		"width"=>'100%',
		'height'=>'200px',
		'config'=>array(
			'toolbar'=> array(
				array('Bold', 'Italic', 'Underline', '-', 'Font', 'FontSize',
					'-', 'JustifyLeft','JustifyCenter','JustifyRight', '-', 'BulletedList','NumberedList'),
				array( 'Image', 'Link', 'Unlink', 'Anchor' )
			),
			//'toolbar'=>'Full',
			'skin'=>'nii',
			'toolbarCanCollapse'=>false,
			'resize_enabled'=>false,
		),
		"filespath"=>Yii::app()->getRuntimePath(),
		"filesurl"=>'/runtime',
//	['Source','-','Save','NewPage','Preview','-','Templates'],
//    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
//    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
//    '/',
//    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
//    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
//    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
//    ['BidiLtr', 'BidiRtl'],
//    ['Link','Unlink','Anchor'],
//    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
//    '/',
//    ['Styles','Format','Font','FontSize'],
//    ['TextColor','BGColor'],
//    ['Maximize', 'ShowBlocks','-','About']
//    ];
//		'config'=>array('toolbar'=> array(
//				array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
//				array( 'Image', 'Link', 'Unlink', 'Anchor' )
//			),
//			'ui'=>'',

	));
		//"filespath"=>(!$model->isNewRecord)?Yii::app()->basePath."/../media/paquetes/".$model->idpaquete."/":"",
		//"filesurl"=>(!$model->isNewRecord)?Yii::app()->baseUrl."/media/paquetes/".$model->idpaquete."/":"",
	
	?>
</div>