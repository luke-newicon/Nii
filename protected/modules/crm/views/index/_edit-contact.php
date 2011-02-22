<style>

	.btn.btnDropDown{border-radius:4px 0px 0px 4px;-moz-border-radius:4px 0px 0px 4px;}
	.btn.btnDropDown:active {top:0px;}
	.addLabel h4 {margin:-1px 2px 5px 10px;}
	.popmenu{max-height:200px;overflow-y:scroll;position:absolute;z-index:100;padding:3px 0px 3px 0px;border:0px;box-shadow:0 4px 10px #8B8B8B;-webkit-box-shadow: 0 4px 10px #8B8B8B;-moz-box-shadow: 0 4px 10px #8B8B8B;background-color:#fff;display:none;border-top:0px;border-radius:0px 0px 4px 4px;-moz-border-radius:0px 0px 4px 4px;}
	/*for ie should add border to popup 1px solid #aaa*/
	.popmenu ul{margin:0px;}
	.popmenu a{display:block;padding:3px 10px 3px 10px;}
	.popmenu a:hover{background-color:#1686d4;color:#fff;text-decoration:none;}
	
	.btn.down{background:-moz-linear-gradient(center top ,#d8d8d8, #FFFFFF) repeat scroll 0 0 #ccc;}
	
	.inputBox.multiInput{padding:0px;}
	
	.addLabel p{margin:2px;}
	
	.formFieldState{padding:2%;}
	.formFieldState.focus{background-color:#EAF2FA;}
	
	.formFieldState .formFieldBlock {padding:0 0 2% 0;}
	.formGuide{color:#999;font-size:90%;}
</style> 
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contactForm',
	'action'=>array('/crm/index/editContact','cid'=>$c->id()),
	'enableAjaxValidation'=>true,
)); ?>
<?php // echo $form->errorSummary($c); ?>
<div id="editUserForm" class="flashy">
	<div class="formFieldBlock">
		<div class="media man size23of25">
			<?php if(isset($c) && $c != false): ?>
				<a href="#" class="img prm">
					<?php $this->widget('crm.components.CrmImage',array('contact'=>$c,'size'=>70)); ?>
				</a>
			<?php endif;?>	
			<div class="bd">
				<?php if($c && $c->type == CrmContact::TYPE_COMPANY): ?>
				<div class="inputBox multiInput">
					<div class="noHighlight noBorder">
						<?php echo $form->textField($c,'company',array('class'=>'input')); ?>
					</div>
				</div>
				<?php else: ?>
				<div class="inputBox multiInput">
					<div class="line noHighlight">
						<div class="unit inputContainer noBorder" style="width:11%;">
							<a href="#title" class="btn btnN btnDropDown ui-corner-tl-only" style="display:block;border-right:0px;padding:0.52em;"><?php echo NData::param($c->title,'&nbsp;'); ?></a>
							<?php echo $form->hiddenField($c,'title',array('class'=>'input')); ?>
						</div>
						<div class="unit leftBorderOnly cornerOff" style="width:39%;">
							<div class="inputContainer">
								<div class="inputBox">
									<?php echo $form->textField($c,'first_name',array('class'=>'input')); ?>
								</div>
							</div>
						</div>
						<div class="lastUnit leftBorderOnly cornerLeftOff">
							<div class="inputContainer">
								<div class="inputBox">
									<?php echo $form->textField($c,'last_name',array('class'=>'input')); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="line noHighlight">
						<div class="lastUnit topBorderOnly cornerTopOff">
							<div class="inputContainer">
								<div class="inputBox">
									<?php echo $form->textField($c,'company',array('class'=>'input')); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="formFieldState">
		<div class="line addLabel">
			<div class="unit"><h4>Email</h4></div>
			<div class="lastUnit"><p><a href="#" class="icon ni-add addRow showTip" tipsy-gravity="sw" title="Add another email address"></a></p></div>
		</div>
		<?php if(count($c->emails)): ?>
			<?php foreach($c->emails as $i=>$e): ?>
				<?php $this->render('_edit-contact-email',array('e'=>$e, 'i'=>$i)); ?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php $this->render('_edit-contact-email',array('e'=>new CrmEmail, 'i'=>0)); ?>
		<?php endif; ?>
	</div>
	<div class="formFieldState">
		<div class="line addLabel">
			<div class="unit"><h4>Phone</h4></div>
			<div class="lastUnit"><p><a href="#" class="icon ni-add addRow"></a></p></div>
		</div>
		<?php if(count($c->phones)): ?>
			<?php foreach($c->phones as $p): ?>
				<?php $this->render('_edit-contact-phone',array('p'=>$p, 'i'=>$i)); ?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php $this->render('_edit-contact-phone',array('p'=>new CrmPhone, 'i'=>0)); ?>
		<?php endif; ?>
	</div>
	
	<div class="formFieldState">
		<div class="line addLabel">
			<div class="unit"><h4>Website</h4></div>
			<div class="lastUnit"><p><a href="#" class="icon ni-add addRow"></a></p></div>
		</div>
		<?php if(count($c->websites)): ?>
			<?php foreach($c->websites as $w): ?>
				<?php $this->render('_edit-contact-website',array('w'=>$w, 'i'=>$i)); ?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php $this->render('_edit-contact-website',array('w'=>new CrmWebsite, 'i'=>0)); ?>
		<?php endif; ?>
	</div>
	
	<div class="formFieldState">
		<div class="line addLabel">
			<div class="unit"><h4>Address</h4></div>
			<div class="lastUnit"><p><a href="#" class="icon ni-add addRow"></a></p></div>
		</div>
		<?php if(count($c->addresses)): ?>
			<?php foreach($c->addresses as $a): ?>
				<?php $this->render('_edit-contact-address',array('a'=>$a, 'i'=>$i)); ?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php $this->render('_edit-contact-address',array('a'=>new CrmAddress, 'i'=>0)); ?>
		<?php endif; ?>
	</div>
</div>
<div id="title" class="popmenu ui-corner-all">
	<ul>
		<li><a href="#">Mr</a></li>
		<li><a href="#">Ms</a></li>
		<li><a href="#">Custom...</a></li>
	</ul>
</div>
<div id="email" class="popmenu ui-corner-all">
	<ul>
		<?php foreach(CrmEmail::getEmailLabels() as $k=>$l): ?>
			<li><a href="#" title="<?php echo CHtml::encode($l['title']); ?>"><?php echo $k; ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
<div id="phone" class="popmenu ui-corner-all">
	<ul>
		<?php //foreach($f->getPhoneLabels() as $k=>$l): ?>
			<li><a href="#" title="<?php //echo NPage::encode($l['title']); ?>"><?php //echo $k; ?></a></li>
		<?php //endforeach; ?>
	</ul>
</div>
<div id="website" class="popmenu ui-corner-all">
	<ul>
		<?php //foreach($f->getWebsiteLabels() as $k=>$l): ?>
			<li><a href="#" title="<?php //echo NPage::encode($l['title']); ?>"><?php //echo $k; ?></a></li>
		<?php //endforeach; ?>
	</ul>
</div>
<div id="address" class="popmenu ui-corner-all">
	<ul>
		<?php //foreach($f->getAddressLabels() as $k=>$l): ?>
		<li><a href="#" title="<?php //echo NPage::encode($l['title']); ?>"><?php //echo $k; ?></a></li>
		<?php //endforeach; ?>
	</ul>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
$(function(){
	$('#general_first_name').focus();
	$('#general_company').autocomplete({
		minLength: 2,
		source:'crm/index/lookup-company',
		select: function( event, ui ) {
		
		}
	}).data( "autocomplete" )._renderItem = function( ul, item ) {
		return $( "<li></li>" )
		.data("item.autocomplete", item )
		.append('<a>'+item.label+'</a>')
		.appendTo( ul );
	}
});


</script>