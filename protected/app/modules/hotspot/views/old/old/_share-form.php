
<div id="shareForm" class="spotForm spotForm toolbarForm" style="width:320px;position:fixed;display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle-verticle"></div>
		<?php $link = $project->getLink(); ?>
		<span><a target="_blank" href="<?php echo $link->getLink(); ?>"><?php echo $link->getLink(); ?></a></span>
		<form id="shareLinkForm">
			<div class="field">
				<div class="field">
					<input <?php echo ($link->password==null)?'':'checked="checked"'; ?> autocomplete="off" onclick="$('#passwordBox').toggle();$('#ProjectLink_password').focus();" type="checkbox" name="makepassword" id="makepassword" />
					<label for="makepassword">Password protect this link</label>
					<div id="passwordBox" class="mll field" style="<?php echo ($link->password==null)?'display:none;':''; ?>">
						<?php echo CHtml::activeLabel($link, 'password',array('class'=>'inFieldLabel')); ?>
						<div class="inputBox" style="width:200px;" >
							<?php echo CHtml::activeTextField($link, 'password',array('autocomplete'=>'off')); ?>
						</div>
					</div>
				</div>
				<!--<div class="field">
					<input type="checkbox" name="allowcomments" id="allowcomments" />
					<label for="allowcomments">Allow comments</label>
				</div>-->
			</div>
			<?php echo CHtml::activeHiddenField($link, 'link'); ?>
			<div class="field man"><a href="#" onclick="return toolbar.shareForm.close()" class="btn aristo">Ok</a></div>
		</form>
	</div>
</div>