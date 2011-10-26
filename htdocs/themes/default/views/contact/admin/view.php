<div id="contact-general" class="shadowBlockLarge">
	<?php echo THelper::checkAccess(NHtml::btnLink($this->t('Edit'), array("contact/edit","id"=>$model->id),'fam-pencil',array('id'=>'contact-edit-button')));?>
	<span class="contact-photo"><?php echo $model->getPhoto('profile-main'); ?></span>
	<h2 class="contact-title"><?php echo $model->displayName;  ?></h2>
	<div id="contact-general-info" class="line">
		<div class="unit size1of2">
			<div class="line">
				<div class="unit size1of3 label"><?=$this->t('Address')?></div>
				<div class="unit size2of3"><?php echo $model->getFullAddress(); ?></div>
			</div>
		</div>
		<div class="lastUnit">
			<div class="line">
				<div class="unit size1of3 label"><?=$this->t('Email')?></div>
				<div class="unit size2of3"><?php echo $model->getEmailLink(); ?></div>
			</div>
			<div class="line">
				<div class="unit size1of3 label"><?=$this->t('Tel Home')?></div>
				<div class="unit size2of3"><?php echo $model->tel_primary; ?></div>
			</div>
			<div class="line">
				<div class="unit size1of3 label"><?=$this->t('Tel Work')?></div>
				<div class="unit size2of3"><?php echo $model->tel_secondary; ?></div>
			</div>
			<div class="line">
				<div class="unit size1of3 label"><?=$this->t('Mobile')?></div>
				<div class="unit size2of3"><?php echo $model->mobile; ?></div>
			</div>
			<div class="line">
				<div class="unit size1of3 label"><?=$this->t('Fax')?></div>
				<div class="unit size2of3"><?php echo $model->fax; ?></div>
			</div>
		</div>
		<?php $this->renderPartial('view/_' . strtolower($model->contact_type), array('model' => $model)); ?>
		<div class="line">
			<div class="unit size1of3 label"><?=$this->t('Comment')?></div>
			<div class="unit size2of3"><?php echo $model->comment; ?></div>
		</div>
	</div>
</div>

<div id="tabs" class="vertical">
	<ul>
		<?php 
		$height = 0;
		if ($rs = $model->getContactTypes($model->contact_type)) {
			foreach ($rs as $r) {
				echo '<li data-id="'.$r['key'].'">' . CHtml::link($this->t($r['value']), array('contact/'.$r['key'].'Details','cid'=>$model->id), array('class'=>'btn btnN')) . '</li>';
				$height = $height + 28;
				/**
				 * Add the Programmes tab if the contact has student details
				 */
				if ($r['key'] == 'student') {
					// Programme list
					$progUrl = array('contact/studentProgrammeList','cid'=>$model->id);
					if ($_GET['scope'])
						$progUrl['scope'] = $_GET['scope'];
					echo '<li data-id="studentProgrammeList" class="level-2">' . CHtml::link($this->t('Programmes'), $progUrl, array('class'=>'btn btnN','data-id'=>'studentProgrammeList')) . '</li>';
					$height = $height + 28;
					$tabs[] = 'studentProgrammeList';
					
					// Computer user details
					$progUrl = array('contact/computerUserDetails','cid'=>$model->id);
					echo '<li data-id="computerUserDetails" class="level-2">' . CHtml::link($this->t('Computer User'), $progUrl, array('class'=>'btn btnN','data-id'=>'computerUserDetails')) . '</li>';
					$height = $height + 28;
					$tabs[] = 'computerUserDetails';
				}
				$tabs[] = $r['key'];
			}
		}
		?>
		<li data-id="relationships"><?php echo CHtml::link($this->t('Relationships'), array('contact/generalInfo','id'=>$model->id), array('class'=>'btn btnN')); ?></li>
		<li data-id="notes"><?php echo CHtml::link($this->t('Notes'), array('contact/notes', 'id' => $model->id), array('class' => 'btn btnN')); ?></li>
		<li data-id="attachments"><?php echo CHtml::link($this->t('Attachments'), array('contact/attachments', 'id' => $model->id), array('class' => 'btn btnN')); ?></li>
	</ul>
</div>
<div id="addRelationshipDialog"></div>
<div id="addProgrammeDialog"></div>
<script>
	$(function() {
		<?php if ($model->selectedTab && in_array($model->selectedTab, $tabs)) { 
			$selectedTab = true;?>
		selectedIndex = $('#tabs li').index($('#tabs li[data-id="<?php echo $model->selectedTab ?>"]'));
		<?php } ?>
		$( "#tabs" ).tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Error loading tab. Please try again." );
				}
			},
			<?php if (isset($selectedTab)) { ?>
			selected: selectedIndex,
			<?php } ?>
			cache: true,
			tabTemplate: '<li><a href="#{href}" class="btn btnN"><span>#{label}</span></a></li>'
		});
	});
	

</script>