<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logo')); ?>:</b>
	<?php echo CHtml::encode($data->logo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('completion_date')); ?>:</b>
	<?php echo CHtml::encode($data->completion_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tree_lft')); ?>:</b>
	<?php echo CHtml::encode($data->tree_lft); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tree_rgt')); ?>:</b>
	<?php echo CHtml::encode($data->tree_rgt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tree_level')); ?>:</b>
	<?php echo CHtml::encode($data->tree_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tree_parent')); ?>:</b>
	<?php echo CHtml::encode($data->tree_parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estimated_time')); ?>:</b>
	<?php echo CHtml::encode($data->estimated_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	*/ ?>

</div>