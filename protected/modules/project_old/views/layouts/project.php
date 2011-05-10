<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php $this->beginContent('//layouts/admin'); ?>
<?php $this->widget('zii.widgets.CMenu', array('items'=>$this->menu)); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>
