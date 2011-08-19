<?php $this->beginWidget('CMarkdown'); ?>

 - User

  - Yii::app()->user()->getName();
 
 Returns the name of the currently logged in user.
   

  - Yii::app()->user()->getName($userId);

 Returns the name of the user with the supplied user id.

  - Yii::app()->user()->getProfileImage();
 
 Returns the profile image of the logged in user.
 
  - Yii::app()->user()->getProfileImage(null,"medium");
 
 Returns the profile image of the logged in user with the returned image size being medium.
 
  - Yii::app()->user()->getProfileImage($id);
 
 Returns the profile image for the user with the supplied user id.
 
  - Yii::app()->user()->getProfileImage($id,"medium");
 
 Returns the profile image for the user with the supplied user id with an image size of medium.
 
  - Yii::app()->user()->cryptPassword($password)
  
  Encrypts a supplied password.
 
<?php $this->endWidget(); ?>