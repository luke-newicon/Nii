<div class="page-header">
	<h2>Preview Your Email</h2>
	<div class="action-buttons">
		<?php 
		if ($canEdit==1) {
			echo NHtml::link('Edit', array('create','id'=>$model->id), array('class'=>'btn')) . '&nbsp;'; 
			echo NHtml::link('Send', array('send','id'=>$model->id), array('class'=>'btn primary')); 
		} else
			echo NHtml::link('View Campaign', array('view','id'=>$model->id), array('class'=>'btn primary')); 
			?>		
	</div>
</div>
<div class="email-campaign-details">
	<div class="container pull-left">
		<div class="line field">
			<div class="unit w140">Recipients</div>
			<div class="lastUnit w500">
				<?php echo $model->listRecipients(); ?>
				<?php echo '<br />('.$model->countRecipients().' in total)'; ?>
			</div>
		</div>
		<div class="line field">
			<div class="unit w140">Subject</div>
			<div class="lastUnit w500">
				<div class="input">
					<?php echo $model->subject; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="line pbs">
		<div class="unit size3of4">Email Content</div>
		<div class="lastUnit">
			<div class="input">
				<?php echo NHtml::dropDownList('recipientPreviewSelect', '', $model->recipientContactsArray, array('prompt'=>'select contact to preview...', 'onchange'=>$model->selectPreviewDropdown())) ?>
			</div>
		</div>
	</div>
	<div class="line field">
		<div class="input">
			<iframe src="<?php echo NHtml::url(array('/email/index/previewContent', 'id'=>$model->id)) ?>" frameborder="0" width="100%" id="previewIframe"></iframe>
		</div>
	</div>
	<div class="actions">
		<?php 
		if ($canEdit==1) {
			echo NHtml::link('Edit', array('create','id'=>$model->id), array('class'=>'btn')) . '&nbsp;'; 
			echo NHtml::link('Send', array('send','id'=>$model->id), array('class'=>'btn primary')); 
		} else
			echo NHtml::link('View Campaign', array('view','id'=>$model->id), array('class'=>'btn primary')); 
		?>	
	</div>
</div>