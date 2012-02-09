<legend>General</legend>
<?php echo $form->field($c, 'title', 'dropDownList', NHtml::enumItem($c, 'title'), array('class' => 'input-small', 'prompt' => 'Select')); ?>
<?php echo $form->field($c, 'givennames'); ?>
<?php echo $form->field($c, 'lastname'); ?>
<?php echo $form->field($c, 'suffix'); ?>
<?php echo $form->field($c, 'dob', 'dateField') ?>
<?php echo $form->field($c, 'gender', 'dropDownList', array('M' => 'Male', 'F' => 'Female'), array('class' => 'input-small', 'prompt' => 'Select')); ?>