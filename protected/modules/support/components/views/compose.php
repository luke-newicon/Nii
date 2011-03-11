<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php echo CHtml::activeLabel($model, 'to', array('class'=>'unit size1of15 faded')); ?>
	<div class="unit lastUnit">
		<?php echo CHtml::activeTextField($model, 'to',array('class'=>'input')); ?>
	</div>
</div>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php echo CHtml::activeLabel($model, 'cc', array('class'=>'unit size1of15 faded')); ?>
	<div class="unit lastUnit">
		<?php echo CHtml::activeTextField($model, 'cc',array('class'=>'input')); ?>
	</div>
</div>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php echo CHtml::activeLabel($model, 'subject', array('class'=>'unit size1of15 faded')); ?>
	<div class="unit lastUnit">
		<?php echo CHtml::activeTextField($model, 'subject',array('class'=>'input')); ?>
	</div>
</div>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php echo CHtml::activeLabel($model, 'from', array('class'=>'unit size1of15 faded')); ?>
	<div class="unit lastUnit">
		<?php echo CHtml::activeTextField($model, 'from',array('class'=>'input')); ?>
	</div>
</div>
<div class="line inputBox" style="border-width:0px 0px 1px 0px; background: none;">
	<?php $this->widget('application.widgets.NTinyMce',array(
		'model'=>$model,
		'attribute'=>'message_html',
		'height'=>'100%',
		'editorTemplate'=>'full'
	)); ?>
</div>