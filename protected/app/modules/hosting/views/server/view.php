<div class="page-header">
	<h2>View Server Details - <?php echo $model->name; ?></h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Edit'), array("edit","id"=>$model->id),array('id'=>'server-edit-button', 'class'=>'btn primary'));?>
	</div>
</div>
<div class="container pull-left">
	<div class="well">
		<div class="line detailRow">
				<div class="unit size1of6 detailLabel"><?php echo $this->t('Name')?></div>
				<div class="lastUnit item-title"><?php echo $model->name; ?></div>
		</div>
		
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Server Name')?></div>
				<div class="lastUnit"><?php echo $model->server_name; ?></div>
			</div>			
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('IP Address')?></div>
				<div class="lastUnit"><?php echo $model->ip_address; ?></div>
			</div>
		</div>
		
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Root Password')?></div>
				<div class="lastUnit"><?php echo $model->root_password; ?></div>
			</div>
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Created Date')?></div>
				<div class="lastUnit"><?php echo NHtml::formatDate($model->created_date, "d M Y"); ?></div>
			</div>
		</div>
	</div>
	<?php 
//	$this->widget('nii.widgets.NTabs', 
//		array(
//			'tabs' => array(
//	//			'Relationships'=>array('ajax'=>array('generalInfo','id'=>$model->id), 'id'=>'relationships'),
//				'Notes'=>array('ajax'=>array('notes','id'=>$model->id), 'id'=>'notes', 'count'=>NNote::countNotes(get_class($model), $model->id)),
//				'Attachments'=>array('ajax'=>array('attachments','id'=>$model->id), 'id'=>'attachments', 'count'=>NAttachment::countAttachments(get_class($model), $model->id)),
//			),
//			'options' => array(
////				'cache' => true,
//			),
//			'htmlOptions' => array(
//				'id' => 'tabs',
//				'class' => 'vertical',
//			)
//		)
//	); 
	?>
</div>