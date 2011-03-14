<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project_id')); ?>:</b>
	<?php echo CHtml::encode($data->project_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('estimated_time')); ?>:</b>
	<?php echo CHtml::encode($data->estimated_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_of_scope')); ?>:</b>
	<?php echo CHtml::encode($data->out_of_scope); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assigned_user')); ?>:</b>
	<?php echo CHtml::encode($data->assigned_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sprint_id')); ?>:</b>
	<?php echo CHtml::encode($data->sprint_id); ?>
	<br />

	*/ ?>

</div>