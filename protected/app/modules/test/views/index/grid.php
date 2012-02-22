<div class="page-header">
	<h1>Test Grid</h1>
</div>
<?php

$grid = new TestContactGrid('search');
$grid->extra = new TestExtra('search');

$grid->unsetAttributes();

if(isset($_GET['TestContactGrid'])){
	$grid->attributes = $_GET['TestContactGrid'];
//	echo '<pre>'.print_r($grid->extra->attributes,true).'</pre>';
//	exit;
}

$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => 'contact-grid',
	'dataProvider' => $grid->search(),
	'filter' => $grid,
	'columns' => $grid->columns(),
));