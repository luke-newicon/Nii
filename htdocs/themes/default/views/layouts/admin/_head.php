<div id="message"></div>
<div class="head">
	<div class="topbar-wrapper">
		<div class="topbar">
			<div class="topbar-inner" style="padding-left:20px;padding-right:20px;">
                <div class="container" style="width:auto">
					<h3><a href="<?php echo Yii::app()->baseUrl ?>">Nii</a></h3>
					<?php
					$this->widget('zii.widgets.CMenu', array(
						'items' => Yii::app()->getModule('admin')->menu->getItems('main'),
						'id' => 'mainMenu',
						'activateParents' => true,
						'submenuHtmlOptions' => array('class' => 'menu-dropdown'),
					));
					?>
					<ul class="nav secondary-nav">
						<li>
							<form action="">
								<input type="text" placeholder="Search">
							</form>
						</li>
					</ul>
					<ul class="nav secondary-nav">
						<li class="menu">
							<a class="menu" href="#">Luke Spencer</a>
							<ul class="menu-dropdown">
								<li><a href="#">Settings</a></li>
								<li><a href="#">Account</a></li>
								<li class="divider"></li>
								<li><a href="#">Logout</a></li>
							</ul>
						</li>
					</ul>
					<?php
					$this->widget('zii.widgets.CMenu', array(
						'items' => Yii::app()->getModule('admin')->menu->getItems('secondary'),
						'id' => 'mainMenu',
						'activateParents' => true,
						'htmlOptions' => array('class' => 'nav secondary-nav'),
						'submenuHtmlOptions' => array('class' => 'menu-dropdown'),
					));
					?>
                </div>
			</div>
		</div>
	</div>
	<script>
		jQuery(function($){
			$('.topbar').dropdown();
		});
	</script>
	<?php if (!Yii::app()->user->isGuest)
		$this->widget('app.widgets.user.TUserProfile', array('id' => 'profileMenuWidget')); ?>
<!--	<div id="sitelogo"><a href="<?php echo Yii::app()->baseUrl; ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.gif" /></a></div>-->
	<?php if (!Yii::app()->user->isGuest) { ?>
	<?php } ?>
</div>