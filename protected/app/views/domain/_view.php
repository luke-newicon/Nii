<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('domain')); ?>:</b>
	<?php echo CHtml::encode($data->domain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registered_date')); ?>:</b>
	<?php echo CHtml::encode($data->registered_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expires_date')); ?>:</b>
	<?php echo CHtml::encode($data->expires_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registered_with')); ?>:</b>
	<?php echo CHtml::encode($data->registered_with); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_id')); ?>:</b>
	<?php echo CHtml::encode($data->contact_id); ?>
	<br />


</div>