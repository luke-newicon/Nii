<div class="modal" id="modal-login-user">
	<div class="modal-header">
		<h3>Error <?php echo $code; ?></h3>
	</div>
	<div class="modal-body">
		<div class="alert-message block-message error">
			<?php echo CHtml::encode($message); ?>
		</div>
	</div>
	<div class="modal-footer">
		<a id="error-back" class="btn primary" href="<?php echo Yii::app()->baseUrl ?>" onclick="window.history.back();return false;">Go Back</a>
	</div>
</div>