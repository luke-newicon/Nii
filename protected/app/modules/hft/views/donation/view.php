<div class="page-header">
	<h2>View Donation Details</h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Edit'), array("edit","id"=>$model->id),array('id'=>'donation-edit-button', 'class'=>'btn primary'));?>
	</div>
</div>
<div class="container pull-left">
	<div class="well">
		<div class="line detailRow">
			
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?=$this->t('Donation Amount')?></div>
				<div class="lastUnit"><?php echo NHtml::formatPrice($model->donation_amount); ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?=$this->t('Date Received')?></div>
				<div class="lastUnit"><?php echo NHtml::formatDate($model->date_received, 'jS F Y'); ?></div>
			</div>
		</div>
		
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?=$this->t('Donation Type')?></div>
				<div class="lastUnit"><?php echo $model->displayType; ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?=$this->t('Gift Aid?')?></div>
				<div class="lastUnit"><?php echo NHtml::formatBool($model->giftaid); ?></div>
			</div>
		</div>
		
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?=$this->t('Donor')?></div>
				<div class="lastUnit"><?php echo $model->contactLink; ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?=$this->t('Event')?></div>
				<div class="lastUnit"><?php echo $model->eventLink; ?></div>
			</div>
		</div>
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?=$this->t('Thankyou Sent')?></div>
				<div class="lastUnit"><?php echo $model->getThankyouLink(false); ?></div>
			</div>
		</div>
		<?php /*
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?=$this->t('Statement Number')?></div>
				<div class="lastUnit"><?php echo $model->statement_number; ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?=$this->t('Statement Date')?></div>
				<div class="lastUnit"><?php echo NHtml::formatDate($model->statement_date, 'jS F Y'); ?></div>
			</div>
		</div>
		*/ ?>
		<div class="line detailRow">
			<div class="unit size1of6 detailLabel"><?=$this->t('Comments')?></div>
			<div class="lastUnit"><?php echo $model->comment; ?></div>
		</div>
	</div>
	<?php 
	$this->widget('nii.widgets.NTabs', 
		array(
			'tabs' => array(
	//			'Relationships'=>array('ajax'=>array('generalInfo','id'=>$model->id), 'id'=>'relationships'),
				'Notes'=>array('ajax'=>array('notes','id'=>$model->id), 'id'=>'notes', 'count'=>NNote::countNotes(get_class($model), $model->id)),
				'Attachments'=>array('ajax'=>array('attachments','id'=>$model->id), 'id'=>'attachments', 'count'=>NAttachment::countAttachments(get_class($model), $model->id)),
			),
			'options' => array(
//				'cache' => true,
			),
			'htmlOptions' => array(
				'id' => 'tabs',
				'class' => 'vertical',
			)
		)
	); 
	?>
</div>