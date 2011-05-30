<?php
/* 
 * Displays the compose email message form
 */
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'compose-email',
	'enableAjaxValidation'=>false,
));
?>
<form>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<div id="ccMore" class="unit" style="width:20px;" ><a onclick="$('.ccFields').toggle();return false;" href="#">&gt;</a></div>
	<div class="unit txtR prs" style="width:35px;">
		<?php echo CHtml::activeLabel($model, 'to', array('class'=>'faded')); ?>
	</div>
	<div class="unit">
		<?php dp($model->to); ?>
		<?php $this->widget('nii.widgets.tokeninput.NTokenInput', array(
			'model'=>$model,
			'attribute'=>'to',
			'url'=>'/support/index/contacts',
			'options'=>array('hintText'=>'','addNewTokens'=>true,'animateDropdown'=>false)
		)); ?>
	</div>
</div>
<div class="ccFields" style="display:none;">
	<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
		<div class="unit txtR prs" style="width:55px;">
			<?php echo CHtml::activeLabel($model, 'cc', array('class'=>'mll faded')); ?>
		</div>
		<div class="unit">
			<?php $this->widget('application.widgets.tokeninput.NTokenInput', array(
				'model'=>$model,
				'attribute'=>'cc',
				'url'=>'/support/index/contacts',
				'options'=>array('hintText'=>'','addNewTokens'=>true,'animateDropdown'=>false)
			)); ?>
			<?php //echo CHtml::activeTextField($model, 'cc',array('class'=>'input')); ?>
		</div>
	</div>
	<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
		<div class="unit txtR prs" style="width:55px;">
			<?php echo CHtml::activeLabel($model, 'bcc', array('class'=>' faded')); ?>
		</div>
		<div class="unit">
			<?php $this->widget('application.widgets.tokeninput.NTokenInput', array(
				'model'=>$model,
				'attribute'=>'bcc',
				'url'=>'/support/index/contacts',
				'options'=>array('hintText'=>'','addNewTokens'=>true,'animateDropdown'=>false)
			)); ?>
			<?php // echo CHtml::activeTextField($model, 'bcc',array('class'=>'input')); ?>
		</div>
	</div>
</div>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<div class="unit txtR prs" style="width:55px;">
		<?php echo CHtml::activeLabel($model, 'subject', array('class'=>'faded')); ?>
	</div>
	<div class="lastUnit" style="padding-top:1px;">
		<?php echo CHtml::activeTextField($model, 'subject',array('class'=>'input')); ?>
	</div>
</div>
<!--<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php echo CHtml::activeLabel($model, 'from', array('class'=>'unit size1of15 faded')); ?>
	<div class="unit lastUnit">
		<?php echo CHtml::activeTextField($model, 'from',array('class'=>'input')); ?>
	</div>
</div>-->

<div id="emailWysiwyg" class="line" style="border-width:0px 0px 1px 0px; background: none;">

	<?php
	$this->widget('application.widgets.editor.CKkceditor',array(
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
			'bodyId'=>'composeMail'
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
<?php $this->endWidget(); ?>