<div class="page-header">
	<h2>View Email Campaign</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('Preview Sent Email', array('preview','id'=>$model->id), array('class'=>'btn primary')); ?>		
	</div>
</div>

<div class="container pull-left">
	<div class="well">
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Subject') ?></div>
			<div class="lastUnit"><?php echo $model->subject; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Status') ?></div>
			<div class="lastUnit"><?php echo $model->status; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Created Date') ?></div>
			<div class="lastUnit"><?php echo NHtml::formatDate($model->created_date); ?></div>
		</div>
	</div>
</div>

<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $recipients,
	'id' => 'EmailCampaignEmailGrid',
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
)); ?>