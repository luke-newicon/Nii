<?php
/**
 *
 */
?>
<?php $this->beginWidget('application.widgets.oocss.Mod', array('class'=>'mod toolbar man')); ?>
	<div class="bd pas">
		<a href="#" class="reply btn btnN">Reply</a>
	</div>
<?php $this->endWidget(); ?>
<script >
$(function(){
	/**
	 * buttons
	 */
	$('.reply').click(function(){
		$('#reply').show();
		var id = $('#messageList .sel').data('id');
		$('#email').load('<?php echo NHtml::url('/support/index/reply/emailId') ?>/'+id, function(){
			$('#composeMail').removeAttr('style');
		});
	});

});

</script>