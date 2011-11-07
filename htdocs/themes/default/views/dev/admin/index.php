<?php $this->widget('nii.widgets.NTabs', 
	array(
		'tabs' => array(
			'Cache'=>array('id'=>'cache', 'content'=>$this->renderPartial('tabs/_cache',null,true)),
			'Bootstrap'=>array('id'=>'bootstrap', 'content'=>$this->renderPartial('tabs/_bootstrap',null,true)),
			'Oocss'=>array('id'=>'oocss', 'content'=>$this->renderPartial('tabs/_oocss',null,true)),
		),
		'options' => array(
			'cache' => true,
		),
		'htmlOptions' => array(
			'id' => 'tabs',
			'class' => 'vertical',
		),
//		'title' => 'Developer Tools',
	)
); ?>
