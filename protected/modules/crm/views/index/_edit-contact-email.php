<div class="field replicate">
	<div class="line">
		<div class="unit size23of25 inputBox multiInput ">
			<div class="line noHighlight">
				<div class="unit noBorder inputContainer size1of6 txtC">
					<a href="#email" class="btn btnN btnDropDown ui-corner-l-only" style="display:block;border-right:0px;padding:0.52em;">
					<span class="data"><?php echo NData::param($e->label,'&nbsp;'); ?></span>
					<span class="icon fam-bullet-arrow-down" style="float:right;">&nbsp;</span>
					</a>
					<?php echo CHtml::activeHiddenField($e, "[$i]label"); ?>
					<?php echo CHtml::activeHiddenField($e, "[$i]id"); ?>
				</div>
				<div class="lastUnit leftBorderOnly cornerLeftOff">
					<div class="inputBox">
						<?php echo $form->textField($e, "[$i]address",array('class'=>'input', 'data-tip'=>"{trigger:focus,gravity:'n'}",'title'=>'Enter email address')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="lastUnit" style="padding-top:6px;"><a href="#" title="Remove" class="icon ni-minus removeRow" data-tip="{gravity:'e'}"  ></a></div>
	</div>
	<?php echo $form->error($e, "[$i]address"); ?>
</div>