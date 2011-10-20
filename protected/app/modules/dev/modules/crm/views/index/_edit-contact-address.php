<?php $display = (!empty($a->lines) || !empty($a->city) || !empty($a->postcode) || !empty($a->county))?'block':'none'; ?>
<div class="line replicate " style="display:<?php echo $display; ?>;">
	<div class="unit size23of25 field">
		<div class="line inputBox multiInput" style="background-color:#f9f9f9;">
			<div class="unit noBorder size1of6 txtC">
				<a href="#address" class="btn btnN btnDropDown ui-corner-l-only" style="display:block;border-right:0px;padding:0.52em;">
					<span class="data"><?php echo NData::param($a->label,'&nbsp;'); ?></span>
					<span class="icon fam-bullet-arrow-down" style="float:right;">&nbsp;</span>
				</a>
				<?php echo CHtml::activeHiddenField($a, "[$i]label"); ?>
				<?php echo CHtml::activeHiddenField($a, "[$i]id"); ?>
			</div>
			<div class="lastUnit leftBorderOnly noHighlight">
				<div class="line cornerLeftOff">
					<div class="inputBox">
						<?php echo CHtml::activeTextArea($a, "[$i]lines",array('class'=>'input', 'placeholder'=>'Address')); ?>
					</div>
				</div>
				<div class="line">
					<div class="unit cornerOff topLeftBorderOnly">
						<div class="inputBox">
							<?php echo CHtml::activeTextField($a, "[$i]city",array('class'=>'input','placeholder'=>'City')); ?>
						</div>
					</div>
					<div class="lastUnit cornerOff topLeftBorderOnly">
						<div class="inputBox">
							<?php echo CHtml::activeTextField($a, "[$i]postcode",array('class'=>'input','placeholder'=>'Postcode')); ?>
						</div>
					</div>
				</div>
				<div class="line cornerOff topLeftBorderOnly">
					<div class="inputBox">
						<?php echo CHtml::activeTextField($a, "[$i]county",array('class'=>'input','placeholder'=>'County')); ?>
					</div>
				</div>
				<div class="line topLeftBorderOnly cornerTopBottomLeftOff">
					<div class="inputBox">
						<?php echo CHtml::activeDropDownList($a, "[$i]country_id", CrmAddress::getCountryArray(),array('class'=>'input')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="lastUnit" style="padding-top:6px;"><a href="#" class="icon ni-minus removeRow showTip" title="Remove"></a></div>
</div>