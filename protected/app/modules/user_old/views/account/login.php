<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login"); ?>
<div class="shadowBlockLarge paddedBlock w400">
<div style="text-align:center; margin-bottom: 16px;"><img src="<?php echo Yii::app()->baseUrl; ?>/images/logo.gif" /></div>

<div style="margin-left: 12px;">
<h2><?php echo UserModule::t("Login"); ?></h2>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
	<div class="success-msg">
		<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
	</div>
<?php endif; ?>

<p class="note">Please enter your details to login to the system.</p>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="line">
		<div class="field <?php echo $model->hasErrors('username') ? 'error' : '' ?>">
			<div class="unit size1of3">
				<?php echo CHtml::activeLabelEx($model,'username'); ?>
			</div>
			<div class="lastUnit">
					<div class="inputBox w240">
						<?php echo CHtml::activeTextField($model,'username') ?>
					</div>
				</div>
			</div>
	</div>
	
	<div class="line">
		<div class="field <?php echo $model->hasErrors('password') ? 'error' : '' ?>">
			<div class="unit size1of3">
				<?php echo CHtml::activeLabelEx($model,'password'); ?>
			</div>
			<div class="lastUnit">
				<div class="inputBox w240">
					<?php echo CHtml::activePasswordField($model,'password') ?>
				</div>
			</div>
		</div>
	</div>

	<div class="line rememberMe">
		<div class="unit size1of3">&nbsp;</div>
		<div class="lastUnit">
			<div class="unit size1of10">
				<?php echo CHtml::activeCheckBox($model,'rememberMe',array('class'=>'inputInline')); ?>
			</div>
			<div class="lastUnit">
				<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
			</div>
		</div>
	</div>

	<div class="line submit pts">
		<div class="unit size1of3">&nbsp;</div>
		<div class="lastUnit">
			<?php echo CHtml::submitButton(UserModule::t("Login"), array('class'=>'btn btnN')); ?>
		</div>
	</div>
	<?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
	
<?php echo CHtml::endForm(); ?>
</div><!-- form -->
</div>
</div>