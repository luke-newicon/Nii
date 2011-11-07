<div class="page-header">
	<h2>View Contact</h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Edit'), array("edit","id"=>$model->id),array('id'=>'contact-edit-button', 'class'=>'btn primary'));?>
	</div>
</div>
<span class="contact-photo"><?php echo $model->getPhoto('profile-main'); ?></span>
<h2 class="contact-title"><?php echo $model->displayName;  ?></h2>
<div id="contact-general-info" class="line pbl">
	<div class="unit size1of2">
		<div class="line">
			<div class="unit size1of3"><?=$this->t('Address')?></div>
			<div class="unit size2of3"><?php echo $model->addressFields; ?></div>
		</div>
		<div class="line">
			<div class="unit size1of3"><?=$this->t('City')?></div>
			<div class="unit size2of3"><?php echo $model->city; ?></div>
		</div>
		<div class="line">
			<div class="unit size1of3"><?=$this->t('County')?></div>
			<div class="unit size2of3"><?php echo $model->county; ?></div>
		</div>
		<div class="line">
			<div class="unit size1of3"><?=$this->t('Post Code')?></div>
			<div class="unit size2of3"><?php echo $model->postcode; ?></div>
		</div>
		<div class="line">
			<div class="unit size1of3"><?=$this->t('Country')?></div>
			<div class="unit size2of3"><?php echo $model->country; ?></div>
		</div>
	</div>
	<div class="lastUnit">
		<div class="line">
			<div class="unit size1of3"><?=$this->t('Email - Home')?></div>
			<div class="unit size2of3"><?php echo $model->getEmailLink(); ?></div>
		</div>
		<div class="line">
			<div class="unit size1of3"><?=$this->t('Email - Work')?></div>
			<div class="unit size2of3"><?php echo $model->getEmailLink('work'); ?></div>
		</div>
		<div class="line">
			<div class="unit size1of3"><?=$this->t('Tel Home')?></div>
			<div class="unit size2of3"><?php echo $model->tel_primary; ?></div>
		</div>
		<div class="line">
			<div class="unit size1of3"><?=$this->t('Tel Work')?></div>
			<div class="unit size2of3"><?php echo $model->tel_secondary; ?></div>
		</div>
		<div class="line">
			<div class="unit size1of3"><?=$this->t('Mobile')?></div>
			<div class="unit size2of3"><?php echo $model->mobile; ?></div>
		</div>
		<div class="line">
			<div class="unit size1of3"><?=$this->t('Fax')?></div>
			<div class="unit size2of3"><?php echo $model->fax; ?></div>
		</div>
	</div>
	<?php $this->renderPartial('view/_' . strtolower($model->contact_type), array('model' => $model)); ?>
	<div class="line">
		<div class="unit size1of3"><?=$this->t('Comment')?></div>
		<div class="unit size2of3"><?php echo $model->comment; ?></div>
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
<!--<div id="tabs" class="vertical">
	<ul>
		<li data-id="relationships"><?php echo CHtml::link($this->t('Relationships'), array('generalInfo','id'=>$model->id), array('class'=>'btn btnN')); ?></li>
		<li data-id="notes"><?php echo CHtml::link($this->t('Notes'), array('notes', 'id' => $model->id), array('class' => 'btn btnN')); ?></li>
		<li data-id="attachments"><?php echo CHtml::link($this->t('Attachments'), array('attachments', 'id' => $model->id), array('class' => 'btn btnN')); ?></li>
	</ul>
</div>
<script>
	$(function() {
		<?php if ($model->selectedTab && in_array($model->selectedTab, $tabs)) { 
			$selectedTab = true;?>
		selectedIndex = $('#tabs li').index($('#tabs li[data-id="<?php echo $model->selectedTab ?>"]'));
		<?php } ?>
		$( "#tabs" ).tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Error loading tab. Please try again." );
				}
			},
			<?php if (isset($selectedTab)) { ?>
			selected: selectedIndex,
			<?php } ?>
			cache: true,
			tabTemplate: '<li><a href="#{href}" class="btn btnN"><span>#{label}</span></a></li>'
		});
	});
	

</script>-->