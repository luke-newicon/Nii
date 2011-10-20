<ul id="userprofilemenu">
	<li>
		<a href="#"><?php
		if (!$contact) {
			$contact = new Contact;
			$contact->name = $user->record->username;
		}
		echo $contact->getPhoto('profile-menu'); echo '<span class="user-name">'.$contact->name.'</span>';
		?>
		</a>
		<ul class="profile-menu">
			<li><a href="<?php echo CHtml::normalizeUrl(array('/user/account/logout'))?>">Logout</a></li>
<!--			<li><a href="<?php echo CHtml::normalizeUrl(array('/users/settings'))?>">Settings</a></li>-->
		</ul>
	</li>
</ul>
