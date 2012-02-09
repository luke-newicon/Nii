<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'contactForm',
	'action' => $action,
	'enableAjaxValidation' => false,
	'enableClientValidation' => true,
		));

$event = new CEvent($this, array('c' => $c, 'form' => $form));
?>
<?php if ($c->hasErrors()) : ?>
	<div class="alert alert-block alert-error">
		<?php echo $form->errorSummary($c); ?>
	</div>
<?php elseif (!$c->id) : ?>
	<div class="alert alert-block alert-info">
		<p>This is where you can create a new contact.  Fill in all the required fields marked with a <span class="required">*</span>.</p>
		<p>Additional information can be added at any other time.</p>
	</div>
<?php endif; ?>
<div id="contact-general">
	<fieldset>
		<?php Yii::app()->getModule('contact')->onRenderContactBeforeTypeDetailsEdit($event); ?>
		<?php $this->renderPartial('edit/_' . strtolower($type), array('c' => $c, 'form' => $form)); ?>
		<?php Yii::app()->getModule('contact')->onRenderContactAfterTypeDetailsEdit($event); ?>
		<legend>Address & Contact Details</legend>
		<div class="row">
			<div class="span6">
				<?php echo $form->field($c, 'addr1'); ?>
				<?php echo $form->field($c, 'addr2'); ?>
				<?php echo $form->field($c, 'addr3'); ?>
				<?php echo $form->field($c, 'city'); ?>
				<?php echo $form->field($c, 'county'); ?>
				<?php echo $form->field($c, 'postcode'); ?>
				<?php echo $form->field($c, 'country', 'dropDownList', Contact::getCountriesArray(), array('prompt' => 'select...', 'options' => array('-' => array('disabled' => true)))); ?>
			</div>
			<div class="span6">
				<?php echo $form->field($c, 'email'); ?>
				<?php echo $form->field($c, 'email_secondary'); ?>
				<?php echo $form->field($c, 'tel_primary'); ?>
				<?php echo $form->field($c, 'tel_secondary'); ?>
				<?php echo $form->field($c, 'mobile'); ?>
				<?php echo $form->field($c, 'fax'); ?>
				<?php echo $form->field($c, 'website'); ?>
			</div>
		</div>
		<?php Yii::app()->getModule('contact')->onRenderContactAfterAddressEdit($event); ?>
		<legend>Photo</legend>
		<div class="control-group">
			<div class="controls" id="contactPhoto">
				<div id="currentImage"><?php echo $c->getPhoto('profile-main-' . strtolower($type)); ?></div>
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
		</div>
		<legend>Additional Details</legend>
		<?php echo $form->field($c, 'comment', 'textArea', null, array('class' => 'span9')); ?>
		<?php Yii::app()->getModule('contact')->onRenderContactAfterCommentEdit($event); ?>
		<div class="control-group">
			<?php echo $form->labelEx($c, 'tags') ?>
			<div class="controls">
				<?php
				$this->widget('nii.widgets.NTagInput', array(
					'model' => $c,
					'attribute' => 'tags',
					'showSelectDropdown' => true,
				));
				?>
			</div>
		</div>
		<div class="form-actions">
			<?php $cancelUrl = ($c->id) ? array('admin/view', 'id' => $c->id) : array('admin/index'); ?>
			<?php echo NHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>
			<?php echo NHtml::btnLink('Cancel', $cancelUrl, null, array('class' => 'btn')); ?>		
		</div>
	</fieldset>
</div>
<?php echo $form->hiddenField($c, 'changedFields') ?>
<?php
if ($action[0] == 'admin/create')
	$c->contact_type = $type;
echo $form->hiddenField($c, 'contact_type')
?>
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