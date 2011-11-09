<form id="gridSettingsForm" method="post">
<?php
$className = get_class($model);
$columns = NData::visibleColumns($className, $gridId);
foreach ($columns as $key=>$value) {
	
	echo '<div class="line">';
	echo CHtml::checkBox($key,$value, array('style'=>'margin-right: 8px;', 'uncheckValue'=>'0'));
	echo CHtml::label($model->getAttributeLabel($key), $key);
	echo '</div>';
	
} ?>
</form>