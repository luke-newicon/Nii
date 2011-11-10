

<!-- USER ACCOUNT STUFF! -->
<div id="accountDialog" style="display:none;padding:0">
	<?php $this->renderPartial('account.views.index.index'); ?>
</div>


<div id="userMenu" class="toolbarForm pas" style="width:100px;display:none;">
	<div style="top:-19px;" class="triangle-verticle"></div>
	<ul class="noBull menuLinks man">
		<li><a href="#" class="account-link">My Account</a></li>
		<li><a href="#" class="welcome-message">Welcome</a></li>
		<li><a href="<?php echo NHtml::url('logout'); ?>" class="logout-link">Log Out</a></li>
	</ul>
</div>


<div id="help-window" title="Welcome to Hotspotx" style="display:none;padding:0px;">
	<div class="line" style="border-bottom:1px solid #ccc;">
		<div class="unit size3of4">
			<h2 class="txtC mtl"><img style="display:inline;" src="<?php echo ProjectModule::get()->getAssetsUrl(); ?>/welcome-to-hotspot.png" /></h2>
			<p class="txtC mll mrl" style="color:#666;">Watch this quick getting started video to see how easy it is to start building beautiful, fully interactive website and web application prototypes</p>
			<a href="#" class="txtC" style="display:block;">
				<img style="display:inline;" src="<?php echo ProjectModule::get()->getAssetsUrl(); ?>/welcome-to-hotspot-video.png" />
			</a>
		</div>
		<div class="lastUnit plm" style="font-size:12px;height:412px;background-color:#eeeeee;border-top:1px solid #fff;border-left:1px solid #e5e5e5;">
			<h3>More Help</h3>
			<p>Well actually. We are still working on this, but feel free to drop us a line at <br/><a href="mailto:support@hotspot-app.com">support@hotspot-app.com</a></p>
		</div>
	</div>
	<div class="line dialog-footer">
		<div class="unit size1of2" style="padding:14px 13px 13px 13px;">
			<label>
				<input class="show-when-open" type="checkbox" <?php echo Yii::app()->user->settings->get('show-help-window', true) ? ' checked="checked" ' : ''; ?> /> Show this window when Hotspot opens
			</label>
		</div>
		<div class="lastUnit txtR" style="padding:10px 13px 10px 10px;" >
			<a href="#" class="btn aristo close" >Close</a>
		</div>
	</div>
</div>



<script>

$(function(){
		
	window.CUserAccountView = Backbone.View.extend({
		el:$('#accountDialog'),
		events:function(){
			$('#accountDialog .tab').click(_.bind(this.tab,this));
		},
		initialize:function(){
			this.el.dialog({
				autoOpen:false,
				width: 750,
				modal: true,
				title: 'My Account',
				resizable: false,
				zIndex:5001,
				position:['center', 100],
				open:_.bind(function(){
					this.resize();
				},this)
			});
			
			$('#accountDialog').delegate('#changeBillingInfo','click', _.bind(this.changeBilling,this));
			$('#accountDialog').delegate('#changeBillingInfoPayment','click', _.bind(this.changeBilling, this));
			
			$('#accountDialog').delegate('#save-billing','click', _.bind(this.saveBillingClick,this));
			$('#accountDialog').delegate('#billing-info-form','submit',_.bind(this.billingInfoSubmit,this));
			
			$('#accountDialog').delegate('#save-change-billing', 'click', _.bind(this.changeBillingInfoClick,this));
			$('#accountDialog').delegate('#change-billing-info-form', 'submit', _.bind(this.changeBillingInfoSubmit,this));
				
		},
		open:function(){
			this.el.dialog('open');
			this.loadTab($('#accountDialog .tab.selected'));
		},
		resize:function(){
			this.$('.tab-list').height(this.$('.tabContent').height());
		},
		upgradeTo:function(planCode){
			this.el.dialog('open');
			if (planCode == undefined) planCode = '';
			this.loadPage('upgrade-plan/planCode/'+planCode);
			// select the correct tab
			$('#accountDialog .tab-list .tab').removeClass('selected');
			$('#upgrade-plan-tab').addClass('selected');
		},
		downgradeTo:function(planCode){
			this.loadPage('downgrade-plan/planCode/'+planCode, _.bind(function(){window.userAccountView.trigger("planChange");}));
		},
		loadTab:function(tabElement){
			
			$('#accountDialog .tab-list .tab').removeClass('selected');
			$(tabElement).addClass('selected');
			var tab = $(tabElement).find('a').attr('href');
			var route = tab.replace('#','');
			this.loadPage(route);
		},
		loadPage:function(url, fun){
			//  do some ajax to load in the content for the tab
			// hack for now
			$('#accountDialog .tabContent').addClass('loading-fb').children().hide();
			$.get('<?php echo NHtml::baseUrl(); ?>/account/index/'+url, _.bind(function(r){
				$('#tab-info').html(r);
				$.fn.nii.form();
				$('#tab-info').show();
				$('#accountDialog .tabContent').removeClass('loading-fb');
				this.resize();
				if(fun != undefined)
					fun();
			},this));
		},
		tab:function(e){
			this.loadTab(e.currentTarget);
			return false;
		},
		changeBilling:function(e){
			var returnUrl = $(e.currentTarget).attr('href').replace('#','');
			
			$('#accountDialog .tabContent').addClass('loading-fb').children().hide();
			$.getJSON('<?php echo NHtml::baseUrl(); ?>/account/index/change-billing/',{ret:returnUrl}, _.bind(function(r){
				$('#tab-info').html(r.result.html);
				$.fn.nii.form();
				$('#tab-info').show();
				$('#accountDialog .tabContent').removeClass('loading-fb');
				this.resize();
			},this));
			return false;
		},
		saveBillingClick:function(){
			// the billing information form has been submited to sign up to a subscription plan
			$('#save-billing').addClass('disabled');
			$('#save-billing').html('Upgrading...');
			$('#billing-info-form').submit();
			return false;
		},
		billingInfoSubmit:function(){
			var data = $('#billing-info-form').serialize();
			$.post("<?php echo NHtml::url('account/index/upgrade-plan') ?>", data, _.bind(function(r){
				$('#save-billing').removeClass('disabled');
				$('#save-billing').html('Upgrade');
				$('#tab-info').html(r);
				$.fn.nii.form();
				window.userAccountView.resize();
				// plan has been upgraded or downgraded (it may have failed but it may have changed)
				// lets raise an event so other things can update if they are plan specific
				this.trigger("planChange");
			},this));
			window.userAccountView.resize();
			return false;
		},
		changeBillingInfoClick:function(){
			$('#save-change-billing').addClass('disabled');
			$('#save-change-billing').html('Updating...');
			$('#change-billing-info-form').submit();
			return false;
		},
		changeBillingInfoSubmit:function(){
			var data = $('#change-billing-info-form').serialize();
			$.post("<?php echo NHtml::url('account/index/change-billing') ?>", data, _.bind(function(r){
				if(r.method && r.method == 'returnTo'){
					var retUrl = r.params[0];

					window.userAccountView.loadPage(retUrl);
					$.gritter.add({title:'Billing Details Updated', text:'Your billing details have been successfully updated.',image: '<?php echo Yii::app()->theme->baseUrl ?>/images/ok_48.png'});
				} else {
					$('#tab-info').html(r.result.html);
					$('#save-change-billing').removeClass('disabled');
					$('#save-change-billing').html('Update Details');
					$.fn.nii.form();
					window.userAccountView.resize();
				}
			},this),'json');
			window.userAccountView.resize();
			return false;
		}
		
	});
	
	window.CUserMenu = Backbone.View.extend({
		el:$('#userMenu'),
		events:{
			'click .account-link' : 'account',
			'click .welcome-message' : 'welcome'
		},
		initialize:function(){
			$('#userBox').live('click',_.bind(function(){
				this.open();
				return false;
			},this));
		},
		render:function(){
			this.open();	
		},
		open:function(){
			$('#userMenu').show().position({my:'center top',at:'center bottom', of:$('#userBox'),offset:'0px 10px;'});
			$('#userBox').addClass('selected');
			$('#userMenu').click(function(e){e.stopPropagation();});
			$('body').bind('click.userMenu',_.bind(function(){
				this.close();
			},this));
		},
		close:function(){
			this.el.hide();
			$('body').unbind('click.userMenu');
			$('#userBox').removeClass('selected');
		},
		account:function(){
			window.userAccountView.open();
			
			this.close();
			return false;
		},
		welcome:function(){
			window.helpWindow.render();
			this.close();
			return false;
		}
	});
	

	window.userAccountView = new CUserAccountView;
	window.userMenu = new CUserMenu;
	
	
	// update the project create and project upgrade box based on the plan
	window.userAccountView.bind('planChange', function(){
		window.projectLimit();
		// see if the user has successfully upgraded and if they are still on a trial
	});
	
	
	
	window.CHelpWindow = Backbone.View.extend({
		el:$('#help-window'),
		events:{
			'click .close':'close',
			'change .show-when-open':'setShowWhenOpen'
		},
		initialize:function(){
			this.el.dialog({
				autoOpen:false,
				width:800,
				height:489,
				zIndex:5001,
				resizable:false
			});
		},
		render:function(){
			this.el.dialog('open');
		},
		close:function(){
			this.el.dialog('close');
		},
		// function called when the check box is changed whether to show the help window when hotspot opens
		setShowWhenOpen:function(){
			var show = this.$('.show-when-open').prop('checked');
			$.post("<?php echo NHtml::url('project/index/help-window'); ?>/show/"+show);
		}
	});
	
	
	window.projectLimit = function(params){
		$.getJSON('<?php echo NHTml::url('project/index/planChange'); ?>', function(r){
			r.result.canCreateProject ? $('#newProject').show() : $('#newProject').hide();
			r.result.canCreateProject ? $('#upgradeProject').hide() : $(' #upgradeProject').show();
			$('#upgradeProject').html(r.result.html);
			if(r.result.user_trial == 0){
				$('.toolbar .trial').hide();
			}else{
				$('.toolbar .trial').show();
			}
		})
	}
	
	window.helpWindow = new CHelpWindow;
	<?php if(Yii::app()->user->hasJustLoggedIn() && Yii::app()->user->settings->get('show-help-window',true)): ?>
		window.helpWindow.render();
	<?php endif; ?>
	
});

</script>