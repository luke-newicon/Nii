<?php $this->renderPartial('//layouts/admin/_header'); ?>
<body class="<?php echo Yii::app()->getModule('admin')->logo ? 'show-logo':''?><?php echo Yii::app()->getModule('admin')->fixedHeader==true ? ' fixed':''?>">
	<div class="page liquid">
		<?php $this->renderPartial('//layouts/admin/_head'); ?>
		<div class="body">
			<?php //$this->renderPartial('//layouts/_breadcrumbs'); ?>
			<div class="alert-messages">
				<?php
				// probably move this into a widget in the admin module.
				// Needs some javascript to go with it so that flash messages can also be added via javascript function
				// for ajax events,
				// Responds to success, error, info, and warning flash message categories
				$flashes = array('success', 'error', 'info', 'warning');
				?>
				<?php foreach($flashes as $k => $flashKey): ?>
					<?php if(Yii::app()->user->hasFlash($flashKey)): ?>
						<div class="alert alert-block fade in alert-<?php echo $flashKey ?>">
							<a class="close" data-dismiss="alert" href="#">&times;</a>
							<p><?php echo Yii::app()->user->getFlash($flashKey); ?></p>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if (Yii::app()->user->hasFlash('error-block-message')) : ?>
					<div class="alert alert-block alert-error"><?php echo Yii::app()->user->getFlash('error-block-message'); ?></div>
				<?php endif; ?>
			</div>
			<div class="main">
				<?php echo $content; ?>
			</div>
		</div>
		<?php $this->renderPartial('//layouts/admin/_foot'); ?>
	</div>
</body>
<?php $this->renderPartial('//layouts/admin/_footer'); ?>