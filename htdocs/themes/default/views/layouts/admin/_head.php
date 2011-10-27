<div id="message"></div>
<div class="head">
	<?php if(false) : ?>
		<div id="sitelogo">
			<a href="<?php echo Yii::app()->baseUrl; ?>">
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.gif" />
			</a>
		</div>
	<?php endif; ?>
	<div class="topbar-wrapper">
		<div class="topbar">
			<div class="topbar-inner" style="padding-left:20px;padding-right:20px;">
                <div class="container" style="width:auto">
					<?php if(false) : ?>
					<ul>
						<li class="menu">
							<a href="<?php echo Yii::app()->baseUrl ?>">Dashboard</a>
						</li>
					</ul>
					<?php else : ?>
						<h3><a href="<?php echo Yii::app()->baseUrl ?>"><?php echo Yii::app()->name ?></a></h3>
					<?php endif; ?>
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
					<?php
					Yii::app()->getModule('admin')->menu->addDivider('secondary','Luke Spencer');
					Yii::app()->getModule('admin')->menu->addItem('secondary','Logout',array('/user/account/logout'),'Luke Spencer');
					$this->widget('zii.widgets.CMenu', array(
						'items' => Yii::app()->getModule('admin')->menu->getItems('secondary'),
						'id' => 'mainMenu',
						'activateParents' => true,
						'htmlOptions' => array('class' => 'secondary-nav'),
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
</div>