<?php echo  THelper::checkAccess($model->getAddProgrammeButton($cid)); ?>
<h3><?php echo $this->t('Programmes of Study'); ?></h3>
<?php 
$this->widget('app.widgets.grid.TGridView', array(
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'id'=>'contactStudentProgrammeListGrid',
	'enableButtons'=>true,
	'buttonModelId'=>$cid,
	'scopes' => array(
		'scopeUrl' => 'contact/view/id/'.$cid.'/selectedTab/studentProgrammeList',
		'default'=>'current',
		'items' => array(
			'current' => array(
				'label' => 'Current Year',
				'description' => 'Display this student\'s studies in the current year',
			),
			'all' => array(
				'label' => 'All',
				'description' => 'Display this student\'s studies for all years',
			),
		),
	),
	'columns'=>$model->columns(Setting::visibleColumns('StudentProgrammes')),
));