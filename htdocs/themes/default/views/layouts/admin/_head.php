<?php $topbarColor = Yii::app()->getModule('admin')->topbarColor ?>
<?php if ($topbarColor) : ?>
<?php $topbarColorLighter = NHtml::hexLighter(Yii::app()->getModule('admin')->topbarColor, 8) ?>
	<style>
		.topbar-inner, .topbar .fill {
		  background-color: <?php echo $topbarColor ?>;
		  background-image: -khtml-gradient(linear, left top, left bottom, from(<?php echo $topbarColorLighter ?>), to(<?php echo $topbarColor ?>));
		  background-image: -moz-linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  background-image: -ms-linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $topbarColorLighter ?>), color-stop(100%, <?php echo $topbarColor ?>));
		  background-image: -webkit-linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  background-image: -o-linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  background-image: linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $topbarColorLighter ?>', endColorstr='<?php echo $topbarColor ?>', GradientType=0);
		}
		.topbar div > ul .menu-dropdown li a:hover,
		.nav .menu-dropdown li a:hover,
		.topbar div > ul .dropdown-menu li a:hover,
		.nav .dropdown-menu li a:hover {
		  background-color: <?php echo $topbarColor ?>;
		  background-image: -khtml-gradient(linear, left top, left bottom, from(<?php echo $topbarColorLighter ?>), to(<?php echo $topbarColor ?>));
		  background-image: -moz-linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  background-image: -ms-linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $topbarColorLighter ?>), color-stop(100%, <?php echo $topbarColor ?>));
		  background-image: -webkit-linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  background-image: -o-linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  background-image: linear-gradient(top, <?php echo $topbarColorLighter ?>, <?php echo $topbarColor ?>);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $topbarColorLighter ?>', endColorstr='<?php echo $topbarColor ?>', GradientType=0);
		}
		.topbar div > ul .menu-dropdown,
		.nav .menu-dropdown,
		.topbar div > ul .dropdown-menu,
		.nav .dropdown-menu {
		  background-color: <?php echo NHtml::hexLighter($topbarColor,10) ?>;
		}
		.topbar div > ul .menu-dropdown .divider,
		.nav .menu-dropdown .divider,
		.topbar div > ul .dropdown-menu .divider,
		.nav .dropdown-menu .divider {
		  background-color: <?php echo $topbarColor ?>;
		  border-color: <?php echo NHtml::hexLighter($topbarColorLighter,20) ?>;
		}
	</style>
<?php endif; ?>
<div id="message"></div>
<div class="head">
	<?php if (Yii::app()->getModule('admin')->logo) : ?>
		<div id="sitelogo">
			<a href="<?php echo Yii::app()->baseUrl; ?>">
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/<?php echo Yii::app()->getModule('admin')->logo ?>" />
			</a>
		</div>
	<?php endif; ?>
	<div class="topbar-wrapper">
		<div class="topbar">
			<div class="topbar-inner" style="padding-left:20px;padding-right:20px;">
                <div class="container" style="width:auto">
					<?php if (Yii::app()->getModule('admin')->menuAppname) : ?>
						<h3><a href="<?php echo Yii::app()->baseUrl ?>"><?php echo Yii::app()->name ?></a></h3>
					<?php else : ?>
						<ul>
							<li class="menu">
								<a href="<?php echo CHtml::normalizeUrl(array('/admin/index/dashboard')) ?>">Dashboard</a>
							</li>
						</ul>
					<?php endif; ?>
					<?php
					$this->widget('nii.widgets.NMenu', array(
						'items' => Yii::app()->menus->getItems('main'),
						'id' => 'mainMenu',
						'activateParents' => true,
						'submenuHtmlOptions' => array('class' => 'menu-dropdown'),
					));
					?>
<!--					<ul class="nav secondary-nav">
						<li>
							<form action="">
								<input type="text" placeholder="Search">
							</form>
						</li>
					</ul>-->
					<?php
					Yii::app()->menus->addDivider('user', 'User');
					Yii::app()->menus->addItem('user', 'Logout', array('/user/account/logout'), 'User');
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