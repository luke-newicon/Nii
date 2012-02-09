<legend>Account</legend>
<?php echo $c->id ? $form->viewField($c, 'id') : ''; ?>
<?php echo $form->field($c, 'classification_id', 'dropDownList', HftContactClassification::getClassificationsArray(), array('prompt'=>'Select')); ?>
<?php echo $form->field($c, 'status', 'dropDownList', NHtml::enumItem($c, 'status'), array('prompt'=>'Select')); ?>