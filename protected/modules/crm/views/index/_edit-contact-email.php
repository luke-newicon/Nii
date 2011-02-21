<div class="formFieldBlock replicate">
	<div class="line">
		<div class="unit size23of25 inputBox multiInput ">
			<div class="line noHighlight">
				<div class="unit noBorder size1of6 txtC">
					<a href="#email" class="btn btnN btnDropDown ui-corner-l-only" style="display:block;border-right:0px;padding:0.52em;"><?php echo NData::param($e->label,'&nbsp;'); ?></a>
					<?php echo CHtml::activeHiddenField($e, "[$i]label"); ?>
					<?php echo CHtml::activeHiddenField($e, "[$i]id"); ?>
				</div>
				<div class="lastUnit leftBorderOnly cornerLeftOff">
					<div class="inputBox">
						<?php echo CHtml::activeTextField($e, "[$i]address",array('class'=>'input')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="lastUnit" style="padding-top:6px;"><a href="#" class="icon ni-minus  removeRow showTipLive" tipsy-gravity="w" title="Remove"></a></div>
	</div>
</div>