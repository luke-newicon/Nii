<!--<div class="page-header">
	<h3>Rules</h3>
</div>-->
<div class="page-header">
	<h3>Rule-based Members</h3>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ContactGroupRuleMembersGrid',
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
)); ?>