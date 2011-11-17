<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'contactForm',
		'action' => $action,
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
	));

$event = new CEvent($this, array('c'=>$c,'form'=>$form));
?>
<div id="contact-general">
	<div class="line">
		<div class="unit size1of6" id="contactPhoto">
			<div id="currentImage"><?php echo $c->getPhoto('profile-main-'.strtolower($type)); ?></div>
			<a href="#" class="removeButton btn">Remove</a>
			<span class="uploadButton btn primary">Upload</span>
			<?php
			$this->widget('nii.widgets.uploadify.UploadifyWidget', array(
				'multi' => false,
				'ID' => 'photoUpload',
				'script' => Yii::app()->createAbsoluteUrl('contact/admin/uploadPhoto'),
				'onComplete' => 'js:function(event, queueID, fileObj, response, data){updateContactPhoto(response)}',
				'hideButton' => true,
				'wmode' => 'transparent',
				'width' => 64,
			));
			?>
<?php echo $form->hiddenField($c, 'photoID'); ?>
		</div>
		<div class="lastUnit">
			<div class="line">
				<?php Yii::app()->getModule('contact')->onRenderContactBeforeTypeDetailsEdit($event); ?>
				<?php $this->renderPartial('edit/_' . strtolower($type), array('c' => $c, 'form' => $form)); ?>
				<?php Yii::app()->getModule('contact')->onRenderContactAfterTypeDetailsEdit($event); ?>
			</div>
			<div class="line">
				<div class="unit size1of2">
					<div class="line">
						<div class="unit size1of3"><?= $form->labelEx($c,'addr1') ?></div>
						<div class="lastUnit">
							<div class="field inputContainer">
								<div class="input">
									<?php echo $form->textField($c, 'addr1', array('size' => 30)); ?>
								</div>
								<?php echo $form->error($c,'addr1'); ?>
							</div>
							<div class="field inputContainer">
								<div class="input">
									<?php echo $form->textField($c, 'addr2', array('size' => 30)); ?>
								</div>
							</div>
							<div class="field inputContainer">
								<div class="input">
									<?php echo $form->textField($c, 'addr3', array('size' => 30)); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'city') ?></div>
						<div class="lastUnit">
							<div class="input w170"><?php echo $form->textField($c, 'city', array('size' => 30)); ?></div>
							<?php echo $form->error($c,'city'); ?>
						</div>
					</div>
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'county') ?></div>
						<div class="lastUnit inputContainer">
							<div class="input w150"><?php echo $form->textField($c, 'county', array('size' => 30)); ?></div>
							<?php echo $form->error($c,'county'); ?>
						</div>
					</div>
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'postcode') ?></div>
						<div class="lastUnit inputContainer">
							<div class="input w70"><?php echo $form->textField($c, 'postcode', array('size' => 10)); ?></div>
							<?php echo $form->error($c,'postcode'); ?>
						</div>
					</div>
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'country') ?></div>
						<div class="lastUnit inputContainer">
							<div class="input w180">
								<?php 
								echo $form->dropDownList($c, 'country', Contact::getCountriesArray(), array(
									'prompt'=>'select...', 
									'options'=>array(
										'-'=>array('disabled'=>true),
									),
								)); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="unit size1of2 lastUnit">
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'email') ?></div>
						<div class="lastUnit inputContainer">
							<div class="input"><?php echo $form->textField($c, 'email', array('size' => 30)); ?></div>
							<?php echo $form->error($c,'email'); ?>
						</div>
					</div>
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'email_secondary') ?></div>
						<div class="lastUnit inputContainer">
							<div class="input"><?php echo $form->textField($c, 'email_secondary', array('size' => 30)); ?></div>
							<?php echo $form->error($c,'email_secondary'); ?>
						</div>
					</div>
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'tel_primary') ?></div>
						<div class="lastUnit inputContainer">
							<div class="input w120"><?php echo $form->textField($c, 'tel_primary', array('size' => 20)); ?></div>
						</div>
					</div>
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'tel_secondary') ?></div>
						<div class="lastUnit inputContainer">
							<div class="input w120"><?php echo $form->textField($c, 'tel_secondary', array('size' => 20)); ?></div>
						</div>
					</div>
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'mobile') ?></div>
						<div class="lastUnit inputContainer">
							<div class="input w120"><?php echo $form->textField($c, 'mobile', array('size' => 20)); ?></div>
						</div>
					</div>
					<div class="line field">
						<div class="unit size1of3"><?= $form->labelEx($c,'fax') ?></div>
						<div class="lastUnit inputContainer">
							<div class="input w120"><?php echo $form->textField($c, 'fax', array('size' => 20)); ?></div>
						</div>
					</div>
				</div>
			</div>
			<?php Yii::app()->getModule('contact')->onRenderContactAfterAddressEdit($event); ?>
			<div class="line field">
				<div class="unit size1of6"><?= $form->labelEx($c,'comment') ?></div>
				<div class="lastUnit inputContainer">
					<div class="input w400"><?php echo $form->textArea($c, 'comment',array('rows'=>6)); ?></div>
				</div>
			</div>
			<?php Yii::app()->getModule('contact')->onRenderContactAfterCommentEdit($event); ?>
		</div>
	</div>
	<div class="actions">
		<?php
		$cancelUrl = ($c->id) ? array('admin/view','id'=>$c->id) : array('admin/index');
		echo NHtml::submitButton('Save', array('class'=>'btn primary')) . '&nbsp;';
		echo NHtml::btnLink('Cancel', $cancelUrl, null, array('class'=>'btn cancel cancelButton')) . '&nbsp;';
		if ($c->id)
			echo NHtml::trashButton($c, 'contact', 'contact/index', 'Successfully deleted '.$c->name);

		?>		
	</div>
</div>

<?php echo $form->hiddenField($c, 'changedFields') ?>
<?php if ($action[0] == '/contact/create')
	$c->contact_type = $type;
echo $form->hiddenField($c, 'contact_type') ?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
	$(function(){

		changedFields = '#Contact_changedFields';
	
		$('.dobField').change(function() {
			var dob = $('#Contact_dob_year').val() + '-' + $('#Contact_dob_month').val() + '-' + $('#Contact_dob_day').val();
			$('#Contact_dob').val(dob);
		});
	
		$('.page').delegate('.cancelButton, .menu a','click',function(){
			confirmCancel(changedFields,'.cancelButton');
			return false;
		});

		$('#contactForm').delegate('.contactSave','click',function(){
			$('#contactForm').submit();
			return false;
		}); 
	
		$('#contactForm input, #contactForm select').change(function() {
			$(changedFields).val('1');
		});
	
		$('#contactForm').delegate('.removeButton','click',function(){
			clearContactPhoto();
		}); 
	});

	function updateContactPhoto(response) {
		var imgHtml = '<img src="<?php echo Yii::app()->baseUrl ?>/nii/index/show/id/'+response+'/type/profile-main/" />';
		$('#currentImage').html(imgHtml);
		$('#Contact_photoID').val(response);
		$(changedFields).val('1');
	}

	function clearContactPhoto() {
		var imgHtml = '<img src="<?php echo Yii::app()->baseUrl ?>/nii/index/show/id/0/type/profile-main/" />';
		$('#currentImage').html(imgHtml);
		$('#Contact_photoID').val('-1');
		$(changedFields).val('1');
		return;
	}
</script>