<?php
$this->widget('nii.widgets.NTabs', 
	array(
		'id' => 'TimesheetTabs',
		'tabs' => $tabs,
		'htmlOptions' => array(
			'class' => 'vertical',
		)
	)
);