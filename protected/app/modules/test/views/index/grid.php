<div class="page-header">
	<h1>Test Grid</h1>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => 'contact-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => $model->columns(),
));