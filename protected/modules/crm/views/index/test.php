<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'drtgsrh',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

<?php echo $form->labelEx($contact,'first_name'); ?>
<?php echo $form->textField($contact,'first_name'); ?>
<?php echo $form->error($contact,'first_name'); ?>


<?php $this->endWidget(); ?>