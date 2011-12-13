<div class="page-header">
	<h2>View Email Group</h2>
</div>

<div class="container pull-left">
	<div class="well">
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Group Name') ?></div>
			<div class="lastUnit"><?php echo $model->name; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Description') ?></div>
			<div class="lastUnit"><?php echo $model->description; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Group Contacts') ?></div>
			<div class="lastUnit"><?php echo $model->groupContactsLinks; ?></div>
		</div>
	</div>
</div>