<div class="page-header">
	<h2>View Saved Campaign</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('Back to List', array('index'), array('class'=>'btn')); ?>	
		<?php echo NHtml::link('Edit', array('edit','id'=>$model->id), array('class'=>'btn primary')); ?>		
	</div>
</div>

<div class="container pull-left">
	<div class="well">
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Name') ?></div>
			<div class="lastUnit item-title"><?php echo $model->name; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Description') ?></div>
			<div class="lastUnit"><?php echo $model->description; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Default Group') ?></div>
			<div class="lastUnit"><?php echo $model->defaultGroupLink; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Design Template') ?></div>
			<div class="lastUnit"><?php echo $model->designTemplateLink; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Email Subject') ?></div>
			<div class="lastUnit"><?php echo $model->subject; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Email Content') ?></div>
			<div class="lastUnit input"><?php echo $model->content; ?></div>
		</div>
	</div>
</div>