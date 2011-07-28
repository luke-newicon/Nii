<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login"); ?>

<h1><?php echo $title; ?></h1>

<div class="form">
<?php echo UserModule::t("Your account is activated."); ?>
</div>

<a href="<?php echo NHtml::url('/user/account/login'); ?>">You can now log in</a>