<h4>What you have achieved</h4>
<div class="line">
	<div class="unit size1of4">
		<div class="stat">
			<div class="number"><?php echo ProjectModule::totalProjects(); ?></div>
			<div class="text">Projects <br /> Created</div>
		</div>
	</div>
	<div class="unit size1of4">
		 <div class="stat">
			<div class="number"><?php echo ProjectModule::totalScreens(); ?></div>
			<div class="text">Screens <br /> Designed</div>
		</div>
	</div>
	<div class="unit size1of4">
		 <div class="stat">
			<div class="number"><?php echo ProjectModule::totalHotspots(); ?></div>
			<div class="text">Hotspots <br /> Created</div>
		</div>
	</div>
	<div class="lastUnit">
		 <div class="stat">
			<div class="number"><?php echo ProjectModule::totalComments(); ?></div>
			<div class="text">Comments <br /> Created</div>
		</div>
	</div>
</div>

<div class="line">
	<div class="unit size1of3">
		<h4 class="mtm">Account information</h4>
	</div>
	<div class="lastUnit">
		<div id="personal-info-success-msg" class="ui-state-highlight pas mts" style="display:none;border-radius:8px;">Your details have been saved!</div>
	</div>
</div>


<?php $model = Yii::app()->user->record; ?>
<?php $form = $this->beginWidget('NActiveForm',array('id'=>'user-form')); ?>
<div class="line">
	<div class="unit size1of5">
		<img src="<?php echo Yii::app()->user->getImageUrl(80); ?>" />
	</div>
	<div class="lastUnit">
		<div class="line">
			<div class="unit size1of2">
				<div class="field prm">
					<?php echo $form->labelEx($user,'company',array('class'=>'inFieldLabel')); ?>
					<div class="inputBox">
						<?php echo $form->textField($user,'company'); ?>
					</div>
				</div>
				<?php echo $form->error($user,'company'); ?>
			</div>
			<div class="lastUnit">
				&nbsp;
			</div>
		</div>
		<div class="line">
			<div class="unit size1of2">
				<div class="field prm">
					<?php echo $form->labelEx($user,'first_name',array('class'=>'inFieldLabel')); ?>
					<div class="inputBox">
						<?php echo $form->textField($user,'first_name'); ?>
					</div>
				</div>
				<?php echo $form->error($user,'first_name'); ?>
			</div>
			<div class="lastUnit">
				<div class="field">
					<?php echo $form->labelEx($user,'last_name',array('class'=>'inFieldLabel')); ?>
					<div class="inputBox">
						<?php echo $form->textField($user,'last_name'); ?>
					</div>
				</div>
				<?php echo $form->error($user,'last_name'); ?>
			</div>
		</div>
		<div class="line">
			<div class="field">
				<div class="inputContainer">
					<?php echo $form->labelEx($user,'email',array('class'=>'inFieldLabel')); ?>
					<div class="inputBox">
						<?php echo $form->textField($user,'email'); ?>
					</div>
				</div>
				<?php echo $form->error($user,'email'); ?>
				<span class="hint">This is your email address, and your login</span>
			</div>
		</div>
	</div>
</div>

<div id="changePasswordLink" class="line ptl">
	<a href="">Change Password</a>
</div>
<div id="changePasswordForm" class="line" style="display:none;">
	<div id="cancelPasswordLink" class="line ptm">
		<h4 class="mtm">Change Password ( <a href="">Cancel</a> )</h4>
	</div>
	<div class="unit size1of2">
		<div class="field prm">
			<?php echo $form->labelEx($userPassword,'password',array('class'=>'inFieldLabel')); ?>
			<div class="inputBox">
				<?php echo $form->passwordField($userPassword,'password'); ?>
			</div>
		</div>
		<?php echo $form->error($userPassword,'password'); ?>
	</div>
	<div class="lastUnit">
		<div class="field">
			<?php echo $form->labelEx($userPassword,'verifyPassword',array('class'=>'inFieldLabel')); ?>
			<div class="inputBox">
				<?php echo $form->passwordField($userPassword,'verifyPassword'); ?>
			</div>
		</div>
		<?php echo $form->error($userPassword,'verifyPassword'); ?>
	</div>
</div>

<?php $this->endWidget(); ?>

<div class="txtR mtm ptm" style="border-top:1px solid #ccc;">
	<a id="personal-info-save" class="btn aristo primary large" href="#">Save</a>
</div>
<script>
	$(function(){
		$('#changePasswordLink a').click(function(){
			$('#changePasswordLink').hide();
			$('#changePasswordForm').show();
			window.userAccountView.resize();
			return false;
		});
		$('#cancelPasswordLink a').click(function(){
			$('#changePasswordLink').show();
			$('#changePasswordForm').hide();
			
			$('#UserChangePassword_verifyPassword').val('').closest('.field').removeClass('error success');
			$('#UserChangePassword_password').val('').closest('.field').removeClass('error success');
			// hide the password field error messages, as the fields are now blank
			$('#UserChangePassword_password_em_').hide();
			$('#UserChangePassword_verifyPassword_em_').hide();
			
			//$.fn.nii.form();
			
			//$('#changePasswordForm .field .inFieldLabel').show().fadeTo(0,1);
			$.fn.nii.form();
			window.userAccountView.resize();
			return false;
		});
		$('#personal-info-save').click(function(){
			$('#personal-info-save').addClass('disabled').html('Saving...');
			$.post("<?php echo NHtml::url('account/index/personalInfo'); ?>",$('#user-form').serialize(),function(){
				$.gritter.add({
					// (string | mandatory) the heading of the notification
					title: 'Information Saved',
					// (string | mandatory) the text inside the notification
					text: 'Your personal information has been updated',
					// (string | optional) the image to display on the left
					image: '<?php echo Yii::app()->theme->baseUrl ?>/images/ok_48.png',
					// (bool | optional) if you want it to fade out on its own or just sit there
					sticky: false,
					// (int | optional) the time you want it to be alive for before fading out
					time: ''
				});
				$('#personal-info-save').removeClass('disabled').html('Save');
				$('#personal-info-success-msg').fadeIn().delay(3500).fadeOut();
				
			});
			return false;
		});
	})
	
</script>