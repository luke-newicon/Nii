<div class="page-header">
	<h2>View Contact</h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Edit'), array("edit","id"=>$model->id),array('id'=>'contact-edit-button', 'class'=>'btn primary'));?>
	</div>
</div>
<div class="container pull-left">
<div class="well">
	<span class="contact-photo"><?php echo $model->getPhoto('profile-main-'.  strtolower($model->contact_type)); ?></span>
<h2 class="contact-title"><?php echo $model->displayName;  ?></h2>
<div id="contact-general-info" class="line">
	<?php Yii::app()->getModule('contact')->onRenderContactAfterHeader($event); ?>
	<div class="unit size1of2">
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('Address')?></div>
			<div class="lastUnit"><?php echo $model->addressFields; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('City')?></div>
			<div class="lastUnit"><?php echo $model->city; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('County')?></div>
			<div class="lastUnit"><?php echo $model->county; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('Post Code')?></div>
			<div class="lastUnit"><?php echo $model->postcode; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('Country')?></div>
			<div class="lastUnit"><?php echo $model->countryName; ?></div>
		</div>
	</div>
	<div class="lastUnit pll">
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('Email - Home')?></div>
			<div class="lastUnit"><?php echo $model->getEmailLink(); ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('Email - Work')?></div>
			<div class="lastUnit"><?php echo $model->getEmailLink('work'); ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('Tel Home')?></div>
			<div class="lastUnit"><?php echo $model->tel_primary; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('Tel Work')?></div>
			<div class="lastUnit"><?php echo $model->tel_secondary; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('Mobile')?></div>
			<div class="lastUnit"><?php echo $model->mobile; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of3 detailLabel"><?=$this->t('Fax')?></div>
			<div class="lastUnit"><?php echo $model->fax; ?></div>
		</div>
	</div>
	<?php Yii::app()->getModule('contact')->onRenderContactBeforeTypeDetails($event); ?>
	<?php $this->renderPartial('view/_' . strtolower($model->contact_type), array('model' => $model)); ?>
	<?php Yii::app()->getModule('contact')->onRenderContactAfterTypeDetails($event); ?>
	<div class="detailRow">
		<div class="unit size1of6 detailLabel"><?=$this->t('Comment')?></div>
		<div class="lastUnit"><?php echo $model->comment; ?></div>
	</div>
	<?php Yii::app()->getModule('contact')->onRenderContactAfterComment($event); ?>
</div>
</div>
<?php $this->widget('nii.widgets.NTabs', 
	array(
		'tabs' => array(
			'Relationships'=>array('ajax'=>array('generalInfo','id'=>$model->id), 'id'=>'relationships'),
			'Notes'=>array('ajax'=>array('notes','id'=>$model->id), 'id'=>'notes'),
			'Attachments'=>array('ajax'=>array('attachments','id'=>$model->id), 'id'=>'attachments'),
		),
		'options' => array(
			'cache' => true,
		),
		'htmlOptions' => array(
			'id' => 'tabs',
			'class' => 'vertical',
		)
	)
); ?>
</div>