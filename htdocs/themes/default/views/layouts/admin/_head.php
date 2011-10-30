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
					$this->widget('nii.widgets.NMenu', array(
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
					Yii::app()->getModule('admin')->menu->addDivider('user','User');
					Yii::app()->getModule('admin')->menu->addItem('user','Logout',array('/user/account/logout'),'User');
					Yii::app()->getModule('admin')->menu->setUsername(Yii::app()->user->name);
					$this->widget('nii.widgets.NMenu', array(
						'items' => Yii::app()->getModule('admin')->menu->getItems('user'),
						'id' => 'userMenu',
						'activateParents' => true,
						'htmlOptions' => array('class' => 'secondary-nav'),
						'submenuHtmlOptions' => array('class' => 'menu-dropdown'),
					));
					$this->widget('nii.widgets.NMenu', array(
						'items' => Yii::app()->getModule('admin')->menu->getItems('secondary'),
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