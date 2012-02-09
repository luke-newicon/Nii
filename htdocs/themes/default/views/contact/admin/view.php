<div class="page-header">
	<h1><?php echo $this->t('View Contact') ?></h1>
	<div class="action-buttons">
		<?php if($model->addableTabs) : ?>
			<a href="#" class="btn" data-controls-modal="modal-add-relation" data-backdrop="true"><?php echo $this->t('Add a Relation') ?></a>
		<?php endif; ?>
		<?php echo NHtml::link($this->t('Edit'), array("edit", "id" => $model->id), array('id' => 'contact-edit-button', 'class' => 'btn btn-primary')) ?>
	</div>
</div>
<div class="container pull-left">
	<div class="well">
		<span class="contact-photo"><?php echo $model->getPhoto('profile-main-' . strtolower($model->contact_type)); ?></span>
		<h2 class="contact-title"><?php echo $model->displayName; ?></h2>
		<div id="contact-general-info" class="line">
			<div class="line">
				<?php Yii::app()->getModule('contact')->onRenderContactAfterHeader($event); ?>
				<div class="unit size1of2">
					<div class="detailRow">
						<div class="unit size1of3 detailLabel"><?php echo $this->t('Address') ?></div>
						<div class="lastUnit"><?php echo $model->fullAddress; ?></div>
					</div>
				</div>
				<div class="lastUnit pll">
					<?php if ($model->email) { ?>
					<div class="detailRow">
						<div class="unit size1of3 detailLabel"><?php echo $this->t('Email - Home') ?></div>
						<div class="lastUnit"><?php echo $model->getEmailLink(); ?></div>
					</div>
					<?php } ?>
					<?php if ($model->email_secondary) { ?>
					<div class="detailRow">
						<div class="unit size1of3 detailLabel"><?php echo $this->t('Email - Work') ?></div>
						<div class="lastUnit"><?php echo $model->getEmailLink('work'); ?></div>
					</div>
					<?php } ?>
					<?php if ($model->tel_primary) { ?>
					<div class="detailRow">
						<div class="unit size1of3 detailLabel"><?php echo $this->t('Tel - Home') ?></div>
						<div class="lastUnit"><?php echo $model->tel_primary; ?></div>
					</div>
					<?php } ?>
					<?php if ($model->tel_secondary) { ?>
					<div class="detailRow">
						<div class="unit size1of3 detailLabel"><?php echo $this->t('Tel - Work') ?></div>
						<div class="lastUnit"><?php echo $model->tel_secondary; ?></div>
					</div>
					<?php } ?>
					<?php if ($model->mobile) { ?>
					<div class="detailRow">
						<div class="unit size1of3 detailLabel"><?php echo $this->t('Tel - Mobile') ?></div>
						<div class="lastUnit"><?php echo $model->mobile; ?></div>
					</div>
					<?php } ?>
					<?php if ($model->fax) { ?>
					<div class="detailRow">
						<div class="unit size1of3 detailLabel"><?php echo $this->t('Fax') ?></div>
						<div class="lastUnit"><?php echo $model->fax; ?></div>
					</div>
					<?php } ?>
					<?php if ($model->website) { ?>
					<div class="detailRow">
						<div class="unit size1of3 detailLabel"><?php echo $this->t('Website URL') ?></div>
						<div class="lastUnit"><?php echo $model->websiteLink; ?></div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php Yii::app()->getModule('contact')->onRenderContactBeforeTypeDetails($event); ?>
			<?php $this->renderPartial('view/_' . strtolower($model->contact_type), array('model' => $model)); ?>
			<?php Yii::app()->getModule('contact')->onRenderContactAfterTypeDetails($event); ?>
			<div class="detailRow">
				<div class="unit size1of6 detailLabel"><?php echo $this->t('Comment') ?></div>
				<div class="lastUnit"><?php echo nl2br($model->comment); ?></div>
			</div>
			<?php Yii::app()->getModule('contact')->onRenderContactAfterComment($event); ?>
			<div class="detailRow">
				<div class="unit size1of6 detailLabel"><?php echo $this->t('Categories') ?></div>
				<div class="lastUnit pbs"><?php echo $model->printTags(); ?></div>
			</div>
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
<?php if ($model->addableTabs) : ?>
<div class="modal hide fade" id="modal-add-relation">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>Add a Relation</h3>
	</div>
	<div class="modal-body">
		<form>
			<div class="field">
				<div class="input">
					<?php echo $model->relationdropDownList() ?>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a id="add-relation-save" class="btn primary" href="#">Add</a>
	</div>
</div>
<script>
	jQuery(function($){
		$('#add-relation-save').click(function(){
			var $selected =$('#contact-relation option:selected');
			$('#tabs').tabs('add',$selected.attr('data-relation-url'),$selected.html(),0).tabs('select',0);
			$('#modal-add-relation').modal('hide');
		});
	});
</script>
<?php endif;