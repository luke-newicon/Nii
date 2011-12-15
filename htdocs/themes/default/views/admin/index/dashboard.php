<?php
/*$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
	'items' => array(
		array('label'=>'Home', 'url'=>'#', 'active' => true),
		array('label'=>'Tab 1', 'url'=>'#'),
		array('label'=>'Tab 2', 'url'=>'#'),
		array('label'=>'Tab 3', 'url'=>'#'),
	),
	'heading' => 'Dashboard',
));*/ ?>
<div class="page-header">
	<h1>Dashboard</h1>
</div>
<div class="row">
	<div class="span10">
		<?php foreach($portlets as $portlet) : if($portlet['position'] == 'main') : ?>
			<?php $this->widget($portlet['widget']); ?>
		<?php endif;endforeach; ?>
	</div>
	<div class="span6">
		<?php foreach($portlets as $portlet) : if($portlet['position'] == 'side') : ?>
			<?php $this->widget($portlet['widget']); ?>
		<?php endif;endforeach; ?>
	</div>
</div>