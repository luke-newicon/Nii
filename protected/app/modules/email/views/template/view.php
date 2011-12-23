<div class="page-header">
	<h2>View Saved Campaign</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('Back to List', array('index'), array('class'=>'btn')); ?>	
		<?php echo NHtml::link('Edit', array('edit','id'=>$model->id), array('class'=>'btn primary')); ?>		
	</div>
</div>

<div class="container pull-left">
	<div class="well">
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Name') ?></div>
			<div class="lastUnit item-title"><?php echo $model->name; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Description') ?></div>
			<div class="lastUnit"><?php echo $model->description; ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Default Global Template') ?></div>
			<div class="lastUnit"><?php echo NHtml::formatBool($model->default_template); ?></div>
		</div>
		<div class="detailRow">
			<div class="unit size1of4 detailLabel"><?= $this->t('Email Content') ?></div>
		</div>
		<div class="line input">
			<iframe src="<?php echo NHtml::url(array('/email/template/templateContent', 'id'=>$model->id)) ?>" frameborder="0" width="100%" id="previewIframe"></iframe>
		</div>
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