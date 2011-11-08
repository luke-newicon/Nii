<h4>Update your card and billing details.</h4><hr class="mln mrn mtn"/>
<?php $form=$this->beginWidget('NActiveForm', array(
	'id'=>'change-billing-info-form',
	'clientOptions'=>array(
		'afterValidateAttribute'=>'js:function(form, attribute, data, hasError){
			if(data.FormCreditCard_validExpirationDate)
				$("#FormCreditCard_validExpirationDate_em_").html(data.FormCreditCard_validExpirationDate[0]).fadeIn(300);
			else
				$("#FormCreditCard_validExpirationDate_em_").fadeOut(300);
			window.userAccountView.resize();
		}',
		'inputContainer'=>'.field'
	)
)); ?>
	
	<div class="line">
		<div class="unit" style="width:63%;">
			<div class="line">
				<h4 class="unit">Credit Card Information </h4>
			</div>
			<div class="line">
				<?php if($error): ?>
					<div class="ui-state-error"><?php echo $error; ?></div>
					<div class="ui-state-highlight">If you need help please don't hesitate to <a href="mailto:support@hotspot-app.com">contact us at support@hotspot-app.com</a> 
						<span class="hint">(we are a friendly bunch)</span>.</div>
				<?php endif; ?>
			</div>
			<div class="line">
				<div class="unit size1of2">
					<div class="field prm">
						<?php echo $form->labelEx($billing, 'first_name', array('class'=>'inFieldLabel')); ?>
						<div class="inputBox">
							<?php echo $form->textField($billing, 'first_name'); ?>
						</div>
					</div>
					<?php echo $form->error($billing, 'first_name'); ?>
				</div>
				<div class="lastUnit">
					<div class="field">
						<?php echo $form->labelEx($billing, 'last_name', array('class'=>'inFieldLabel')); ?>
						<div class="inputBox">
							<?php echo $form->textField($billing, 'last_name'); ?>
						</div>
					</div>
					<?php echo $form->error($billing, 'last_name'); ?>
				</div>
			</div>
			<div class="line">
				<div class="unit" style="width:225px;">
					<div class="field prm">
						<?php echo $form->labelEx($card, 'number', array('class'=>'inFieldLabel')); ?>
						<div class="inputBox">
							<?php echo $form->textField($card, 'number'); ?>
						</div>
					</div>
					<?php echo $form->error($card, 'number'); ?>
				</div>
				<div class="lastUnit" style="padding-top:8px;">
					<span style="color:#666;"><span class="icon account-lock"></span> SECURE</span>
				</div>
			</div>
			<span class="hint">Your current card number on file ends with <?php echo $billing->card_last_four; ?>.</span>
			<div class="field prm line">
				<div class="unit" style="width:80px;">
					<div class="inputContainer prm">
						<?php echo $form->labelEx($card, 'verification_value', array('class'=>'inFieldLabel')); ?>
						<div class="inputBox line">
							<?php echo $form->textField($card, 'verification_value'); ?>
						</div>
					</div>
				</div>
				<div class="lastUnit">
					<div class="line cvv-hint" style="padding-top:3px;">
						<div class="unit prm">	
							<div class="sprite account-cvv"></div>
						</div>
						<div class="lastUnit">
							<label class="hint" for="card_cvv">Card Verification Value</label>
						</div>
					</div>
				</div>
			</div>
			<?php echo $form->error($card, 'verification_value'); ?>
			<div class="line">
				<div class="unit">
					<div class="field prm">
						<div class="">
							<?php echo $form->dropDownList($card, 'month', $card->getMonths()); ?>
						</div>
						<?php echo $form->labelEx($card, 'month', array('class'=>'hint')); ?>
						<?php echo $form->error($card, 'month'); ?>
					</div>
				</div>
				<div class="lastUnit">
					<div class="field">
						<div class="">
							<?php echo $form->dropDownList($card, 'year', $card->getYears()); ?>
						</div>
						<?php echo $form->labelEx($card, 'year', array('class'=>'hint')); ?>
						<?php echo $form->error($card, 'year'); ?>
					</div>
				</div>
			</div>
			<?php echo $form->error($card, 'validExpirationDate'); ?>


			<h4 class="mtl">Billing Address</h4>
<!--		<div class="field">
				<label for="billing_company" class="inFieldLabel">Company</label>
				<div class="inputBox">
					<input name="billing[company]" id="billing_company" type="text" />
				</div>
			</div>-->

			<div class="line">
				<div class="field">
					<?php echo $form->labelEx($billing, 'address1', array('class'=>'inFieldLabel')); ?>
					<div class="inputBox">
						<?php echo $form->textField($billing, 'address1'); ?>
					</div>

				</div>
				<?php echo $form->error($billing, 'address1'); ?>
			</div>
			<div class="line">
				<div class="field">
					<?php echo $form->labelEx($billing, 'address2', array('class'=>'inFieldLabel')); ?>
					<div class="inputBox">
						<?php echo $form->textField($billing, 'address2'); ?>
					</div>
				</div>
				<?php echo $form->error($billing, 'address2'); ?>
			</div>
			<div class="line">
				<div class="unit size3of5">
					<div class="field prm">
						<?php echo $form->labelEx($billing, 'city', array('class'=>'inFieldLabel')); ?>
						<div class="inputBox">
							<?php echo $form->textField($billing, 'city'); ?>
						</div>
					</div>
					<?php echo $form->error($billing, 'city'); ?>
				</div>
				<div class="lastUnit">
					<div class="field">
						<?php echo $form->labelEx($billing, 'zip', array('class'=>'inFieldLabel')); ?>
						<div class="inputBox">
							<?php echo $form->textField($billing, 'zip'); ?>
						</div>
					</div>
					<?php echo $form->error($billing, 'zip'); ?>
				</div>
			</div>
			<div class="line">
				<div class="field">
					<?php echo $form->labelEx($billing, 'state', array('class'=>'inFieldLabel')); ?>
					<div class="inputBox">
						<?php echo $form->textField($billing, 'state'); ?>
					</div>
				</div>
				<?php echo $form->error($billing, 'state'); ?>
			</div>
			<div class="line">
				<div class="lastUnit">
					<div class="field">
						<div class="">
							<?php echo $form->dropDownList($billing, 'country', $billing->getCountries()) ?>						
						</div>
					</div>
				</div>
			</div>


			<div class="txtR mtm ptm" style="border-top:1px solid #ccc;">
				<a id="save-change-billing" class="btn aristo primary large" href="#">Update Details</a>
			</div>

		</div>
		<div class="lastUnit">
			<?php $this->renderPartial('_billing-side-box'); ?>
			
		</div>
	</div>
<?php echo CHtml::hiddenField('ret', $ret); ?>
<?php $this->endWidget(); ?>