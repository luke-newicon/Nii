<?php $this->pageTitle = Yii::app()->name . ' - Error'; ?>
<h1>Sorry, we can not perform your request.</h1>
<div class="alert-message block-message error">
	<h2>Error <?php echo $code; ?></h2>
	<p><?php echo CHtml::encode($message); ?></p>
</div>