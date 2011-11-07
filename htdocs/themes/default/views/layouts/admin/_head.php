<div class="head">
	<?php if(true) : ?>
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
					<?php if(true) : ?>
					<ul>
						<li class="menu">
							<a href="<?php echo Yii::app()->baseUrl ?>">Dashboard</a>
						</li>
					</ul>
					<?php else : ?>
						<h3><a href="<?php echo Yii::app()->baseUrl ?>"><?php echo Yii::app()->name ?></a></h3>
					<?php endif; ?>
					<?php
					$this->widget('nii.widgets.NMenu', array(
						'items' => Yii::app()->menus->getItems('main'),
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
					Yii::app()->menus->addDivider('user','User');
					Yii::app()->menus->addItem('user','Logout',array('/user/account/logout'),'User');
					Yii::app()->menus->setUsername(Yii::app()->user->name);
					$this->widget('nii.widgets.NMenu', array(
						'items' => Yii::app()->menus->getItems('user'),
						'id' => 'userMenu',
						'activateParents' => true,
						'htmlOptions' => array('class' => 'secondary-nav'),
						'submenuHtmlOptions' => array('class' => 'menu-dropdown'),
//						'encodeLabel' => false,
					));
					$this->widget('nii.widgets.NMenu', array(
						'items' => Yii::app()->menus->getItems('secondary'),
						'id' => 'secondaryMenu',
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
</div>