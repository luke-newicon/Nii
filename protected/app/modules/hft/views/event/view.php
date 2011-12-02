<div class="page-header">
	<h2><?php echo $this->t('View Event Details') ?></h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Edit'), array("edit","id"=>$model->id),array('id'=>'event-edit-button', 'class'=>'btn primary'));?>
	</div>
</div>
<div class="container pull-left">
	<div class="well">
		<div class="line detailRow">
			
			<div class="unit">
				<div class="unit size1of6 detailLabel"><?=$this->t('Event Name')?></div>
				<div class="lastUnit item-title"><?php echo $model->name; ?></div>
			</div>
		</div>
		
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?=$this->t('Start Date')?></div>
				<div class="lastUnit"><?php echo NHtml::formatDate($model->start_date, 'jS F Y'); ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?=$this->t('End Date')?></div>
				<div class="lastUnit"><?php echo NHtml::formatDate($model->end_date, 'jS F Y'); ?></div>
			</div>
		</div>
		
		<div class="line detailRow">
			<div class="unit size1of2">
				<div class="unit size1of3 detailLabel"><?=$this->t('Organiser Type')?></div>
				<div class="lastUnit"><?php echo $model->displayOrganiserType; ?></div>
			</div>
			<div class="lastUnit">
				<div class="unit size1of3 detailLabel"><?=$this->t('Organiser\'s Name')?></div>
				<div class="lastUnit"><?php echo $model->organiser_name; ?></div>
			</div>
		</div>
		
		<div class="line detailRow">
			<div class="unit">
				<div class="unit size1of6 detailLabel"><?=$this->t('Description')?></div>
				<div class="lastUnit"><?php echo $model->description; ?></div>
			</div>
			
		</div>

	</div>
	<?php 
	$this->widget('nii.widgets.NTabs', 
		array(
			'tabs' => array(
	//			'Relationships'=>array('ajax'=>array('generalInfo','id'=>$model->id), 'id'=>'relationships'),
				'Attendees'=>array('ajax'=>array('attendees','id'=>$model->id), 'id'=>'attendees', 'count'=>$model->totalAttendees),
				'Notes'=>array('ajax'=>array('notes','id'=>$model->id), 'id'=>'notes', 'count'=>$model->countNotes()),
				'Attachments'=>array('ajax'=>array('attachments','id'=>$model->id), 'id'=>'attachments', 'count'=>$model->countAttachments()),
			),
			'options' => array(
				'cache' => true,
			),
			'htmlOptions' => array(
				'id' => 'tabs',
				'class' => 'vertical',
			)
		)
	); 
	?>
</div>