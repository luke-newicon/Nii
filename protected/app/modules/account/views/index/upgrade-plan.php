<?php $form=$this->beginWidget('NActiveForm', array(
	'id'=>'billing-info-form',
	'clientOptions'=>array(
		'afterValidateAttribute'=>'js:function(form, attribute, data, hasError){
			console.log(attribute)
			console.log(data)
			if(data.FormCreditCard_validExpirationDate)
				$("#FormCreditCard_validExpirationDate_em_").html(data.FormCreditCard_validExpirationDate[0]).fadeIn(300);
			else
				$("#FormCreditCard_validExpirationDate_em_").fadeOut(300);
			window.userAccountView.resize();
		}',
		'inputContainer'=>'.field'
	)
)); ?>
	<?php if(Yii::app()->user->trialExpired()): ?>
	<div class="alert-message block-message error">
		<strong>Trial Expired</strong>
		<p>Your trial has expired, if you liked hotspot and wish to continue using it to wow your clients and produce wondrous prototypes, please upgrade to a paid plan.</p>
	</div>
	<?php endif; ?>
	<div class="line">
		<div class="unit" style="width:63%;">
			<?php $p = Plan::getPlan($plan); ?> 
			<h4 style="margin-bottom:15px;"><?php echo $p['title']; ?> Plan <span style="color:#666;font-size:13px;">&pound;<?php echo $p['price']; ?>/month (<?php echo $p['projects']; ?> Projects)</span></h4> 
			
			<div class="fadeBox">
				<h4 style="color:#666;font-size:13px;">Payment Information (<a id="changeBillingInfoPayment" href="#upgrade-plan/planCode/<?php echo $plan; ?>">change</a>)</h4>

				<div class="line">
					<div class="unit" style="width:55px;"><span class="hint">Card: </span></div>
					<div class="lastUnit">
						<div class="line">
							<div class="unit ">
								<div class="sprite <?php echo $billing->getCardTypeImageClass(); ?>">&nbsp;</div>
							</div>
							<div class="lastUnit">
								<p class="plm">************<strong><?php echo $billing->card_last_four; ?></strong></p>
							</div>
						</div>
					</div>
				</div>

				<div class="line">
					<div class="unit" style="width:55px;"><span class="hint">Address: </span></div>
					<div class="lastUnit hint" style="color:#666;">
						<?php echo $billing->address1; ?>, <?php echo $billing->city; ?>, <?php echo $billing->zip; ?>
					</div>
				</div>
			</div>
			
			
			<a  id="save-billing" class="mtl btn aristo primary large" href="#">Upgrade to the <?php echo $p['title'] ?> Plan</a>
			
			<p class="hint mtm">You will be charged the new rate for your new plan on the next billing cycle.</p>
			<p class="hint">If you cancel you will be cancelled immediately and you won't be charged again.</p>
		
		</div>
		<div class="lastUnit">
			<?php $this->widget('account.widgets.plan.PlanBox',array('view'=>'upgrade-subscribe', 'plan'=>$plan)); ?>
			<?php $this->renderPartial('_billing-side-box'); ?>
		</div>
	</div>
	<?php echo CHtml::hiddenField('planCode',$plan); ?>
<?php $this->endWidget(); ?>