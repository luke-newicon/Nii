<?php $this->pageTitle = Yii::app()->name . ' - Error'; ?>
<h1>Sorry, we can not perform your request.</h1>
<div class="alert-message block-message error">
	<h1>Error <?php echo $code; ?></h1>
	<p><?php echo CHtml::encode($message); ?></p>
</div>