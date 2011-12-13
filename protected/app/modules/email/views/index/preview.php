<div class="page-header">
	<h2>Preview Your Email</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('Edit', array('create','id'=>$model->id), array('class'=>'btn')) . '&nbsp;'; ?>		
		<?php echo NHtml::link('Send', array('send','id'=>$model->id), array('class'=>'btn primary')); ?>		
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
				<?php echo NHtml::dropDownList('recipientPreviewSelect', '', $model->recipientContactsArray, array('prompt'=>'select to preview...', 'onchange'=>$model->selectPreviewDropdown())) ?>
			</div>
		</div>
	</div>
	<div class="line field">
		<div class="input">
			<iframe src="<?php echo NHtml::url(array('/email/index/previewContent', 'id'=>$model->id)) ?>" frameborder="0" width="100%" id="previewIframe"></iframe>
		</div>
	</div>
	<div class="actions">
		<?php echo NHtml::link('Edit', array('create','id'=>$model->id), array('class'=>'btn')) . '&nbsp;'; ?>		
		<?php echo NHtml::link('Send', array('send','id'=>$model->id), array('class'=>'btn primary')); ?>		
	</div>
</div>
<script>
// @todo Move to separate function...
$(document).ready(function()
	{
		// Set specific variable to represent all iframe tags.
		var iFrames = document.getElementsByTagName('iframe');

		// Resize heights.
		function iResize()
		{
			// Iterate through all iframes in the page.
			for (var i = 0, j = iFrames.length; i < j; i++)
			{
				// Set inline style to equal the body height of the iframed content.
				iFrames[i].style.height = iFrames[i].contentWindow.document.body.offsetHeight + 'px';
			}
		}

		// Check if browser is Safari or Opera.
		if ($.browser.safari || $.browser.opera)
		{
			// Start timer when loaded.
			$('iframe').load(function()
				{
					setTimeout(iResize, 0);
				}
			);

			// Safari and Opera need a kick-start.
			for (var i = 0, j = iFrames.length; i < j; i++)
			{
				var iSource = iFrames[i].src;
				iFrames[i].src = '';
				iFrames[i].src = iSource;
			}
		}
		else
		{
			// For other good browsers.
			$('iframe').load(function()
				{
					// Set inline style to equal the body height of the iframed content.
					this.style.height = this.contentWindow.document.body.offsetHeight + 'px';
				}
			);
		}
	}
);
</script>