<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2 class="error">Error <?php echo isset($code) ? $code : '[undefined]'; ?></h2>

<div class="alert-message block-message error">
<?php echo (isset($htmlMessage) && $htmlMessage == true) ? $message : CHtml::encode($message); ?>
	<p>Please contact the system administrator if you believe this error is incorrect.</p>
</div>