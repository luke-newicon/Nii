<div class="page-header">
	<h1>View Donation Details</h1>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Edit'), array("edit","id"=>$model->id),array('id'=>'donation-edit-button', 'class'=>'btn btn-primary'));?>
	</div>
</div>
<div class="container pull-left">
	<div class="well">
		<div class="line detailRow">
			
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Donation Amount')?></div>
				<div class="lastUnit"><?php echo NHtml::formatPrice($model->donation_amount); ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Date Received')?></div>
				<div class="lastUnit"><?php echo NHtml::formatDate($model->date_received, 'jS F Y'); ?></div>
			</div>
		</div>
		
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Donation Type')?></div>
				<div class="lastUnit"><?php echo $model->displayType; ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Gift Aid?')?></div>
				<div class="lastUnit"><?php echo NHtml::formatBool($model->giftaid); ?></div>
			</div>
		</div>
		
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Donor')?></div>
				<div class="lastUnit"><?php echo $model->contactLink; ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Event')?></div>
				<div class="lastUnit"><?php echo $model->eventLink; ?></div>
			</div>
		</div>
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?php echo $this->t('Thankyou Sent')?></div>
				<div class="lastUnit"><?php echo $model->getThankyouLink(false); ?></div>
			</div>
		</div>
		<?php /*
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?php echo$this->t('Statement Number')?></div>
				<div class="lastUnit"><?php echo $model->statement_number; ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?php echo$this->t('Statement Date')?></div>
				<div class="lastUnit"><?php echo NHtml::formatDate($model->statement_date, 'jS F Y'); ?></div>
			</div>
		</div>
		*/ ?>
		<div class="line detailRow">
			<div class="unit size1of6 detailLabel"><?php echo $this->t('Comments')?></div>
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