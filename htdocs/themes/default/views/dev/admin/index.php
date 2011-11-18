<?php $this->widget('nii.widgets.NTabs', 
	array(
		'id' => 'DeveloperTabs',
		'tabs' => array(
			'Cache'=>array('id'=>'cache', 'content'=>$this->renderPartial('tabs/_cache',null,true)),
			'Bootstrap'=>array('id'=>'bootstrap', 'content'=>$this->renderPartial('tabs/_bootstrap',null,true)),
			'Oocss'=>array('id'=>'oocss', 'content'=>$this->renderPartial('tabs/_oocss',null,true)),
			'Nii Components'=>array('id'=>'nii_components', 'content'=>$this->renderPartial('tabs/_nii-components',null,true)),
			'jQuery UI'=>array('id'=>'jqueryui', 'content'=>$this->renderPartial('tabs/_jqueryui',null,true)),
		),
		'options' => array(
			'cache' => true,
		),
		'htmlOptions' => array(
			'class' => 'vertical',
		),
//		'title' => 'Developer Tools',
	)
); ?>
