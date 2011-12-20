<div class="page-header">
	<h2>View Contact Group</h2>
</div>

<div class="container pull-left">
	<div class="well">
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Group Name') ?></div>
			<div class="lastUnit item-title"><?php echo $model->name; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Description') ?></div>
			<div class="lastUnit"><?php echo $model->description; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Total No. of Members') ?></div>
			<div class="lastUnit" id="totalMembersCount"><?php echo $model->countGroupContacts(); ?></div>
		</div>
	</div>

	<?php
	$this->widget('nii.widgets.NTabs', array(
		'tabs' => $model->tabs,
		'options' => array(
//			'cache' => true,
		),
		'htmlOptions' => array(
			'id' => 'tabs',
			'class' => 'vertical',
		)
			)
	);
	?>
</div>