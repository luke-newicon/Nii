<?php
$this->breadcrumbs = array(
	'Docs',
);
?>

fcbk! <br />

<?php $this->widget('application.widgets.fbcomplete.FBComplete', array(
	'name'=>'test',
	'dataOptions'=>array(
		'0'=>array('label'=>'Some label'),
		'1'=>array('label'=>'Some label 2')
	),
	'options'=>array(
		'json_url'=>NHtml::url('/docs/contactsComplete'),
		'newel'=>true
	)
)); ?>



<?php $this->beginWidget('CTextHighlighter',array('language'=>'php')); ?>
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'mydialog',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Dialog box 1',
		'autoOpen' => false,
		'buttons' => array(
			'ok' => array(
				'text' => 'ok'
			),
		),
	),
));
echo 'dialog content here';
$this->endWidget();
// the link that may open the dialog
echo CHtml::link('open dialog', '#', array(
	'onclick' => '$("#mydialog").dialog("open"); return false;',
));
<?php $this->endWidget(); ?>
<?php $this->widget('support.components.NComposeMail'); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'mydialog',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Dialog box 1',
		'width'=>'500',
		'autoOpen' => false,
		'buttons' => array(
			'ok' => array(
				'text' => 'ok'
			),
		),
	),
));
echo 'dialog content here';
$this->endWidget();
// the link that may open the dialog
echo CHtml::link('open dialog', '#', array(
	'onclick' => '$("#mydialog").dialog("open"); return false;',
));
?>
<br />
<br />
<!--<div class="mod popup" style="width:200px;padding:6px;">
	<div class="popShadow" style="height: 100%; width: 100%; background: none repeat scroll 0% 0% rgb(0, 0, 0); position: absolute; top: 0px; left: 0px; -moz-border-radius: 8px 8px 8px 8px; opacity: 0.5;"></div>
	<div class="inner" style="background-color:#fff;-moz-border-radius: 3px;">
		<div class="hd">
			title
		</div>
		<div class="bd">sdfgsdfg</div>
		<div class="ft">sdfgsdfg</div>
	</div>
</div>-->

<script>
	$('.popup').position({my:'center',at:'center',of:'body'});
	
	$('.ui-dialog-content .ui-widget-content').addClass('shimmer');
</script>		


<div style="display:none"><div id="data">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div></div>


<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
	'name' => 'publishDate',
	// additional javascript options for the date picker plugin
	'options' => array(
		'showAnim' => 'fold',
	),
));
?>