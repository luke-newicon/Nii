<?php

/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
?>
<div class="page-header">
	<h1>Nii Components</h1>
</div>

<p>Nii components for pleasure and profit.</p>



<div class="row">
	<div class="span4">
		<h2>Active Record</h2>
		<p>
			Behaviors and exciting enhancements to Activerecord classes
		</p>
	</div>
	<div class="span12">
		<h2>Taggable Behavior</h2>
		<p>Adds the ability to tag active record models and later search records based on tags.</p>
		
		Attaching the taggable behavior to a model
<?php $this->beginWidget('CTextHighlighter', array('language' => 'php')); ?>
	function behaviors(){
	   return array(
		   'tag'=>array(
			   'class'=>'nii.components.behaviors.NTaggable'
		   )
	   );
	}
<?php $this->endWidget(); ?>
	<p>Or we can attch a behavior to an individual model Yii normally takes care of this for us. If we define the behaviors function.
	For an example we will demonstrate taggable behavior on the user model</p>
<?php $this->beginWidget('CTextHighlighter', array('language' => 'php')); ?>
	// get a user record
	$users = User::model()->findAll(array('limit'=>1));
	$u = $users[0];
	$u->attachBehavior('tag', array(
		'class' => 'nii.components.behaviors.NTaggable',
	));
<?php $this->endWidget(); ?>
	
	
<?php
	$users = User::model()->findAll(array('limit'=>1));
	$u = $users[0];
	User::model()->attachBehavior('tag', array(
		'class' => 'nii.components.behaviors.NTaggable',
	));
	$u->attachBehavior('tag', array(
		'class' => 'nii.components.behaviors.NTaggable',
	));
?>
	<p><code>$u</code> is user with email address <strong><?php echo $u->email; ?></strong> we are going to experiment with this user. Mwaa haha. We will reset things back to normal after.</p>
	
	<h2>Adding Tags</h2>
	<p>To add tags simply call the setTags function with an array of tags we wish to add to the model</p>
	
	<?php $this->beginWidget('CTextHighlighter', array('language' => 'php')); ?>
		$u->tags = array('cool dude', 'admin');
	<?php $this->endWidget(); ?>
	<p>The code above has added two tags to the user record <span class="label">cool dude</span> and <span class="label">admin</span>.
		<code>$u->tags = ...</code> will call the <code>NTaggable::setTags()</code> function.  We can also call this function using 
		<code>$u->setTags()</code> or <code>$u->tag->setTags()</code> or even <code>$u->tag->tags</code> because the <code>$u->tag</code> will return the <code>NTaggable</code> object.  Got it? 
	</p>

<?php		
	$u->tags = array('cool dude', 'admin');
?>
	<h2>Listing Tags</h2>
	<h3>List All Tags For One Record</h3>
	<p>To get a list of tags applied to the user model we can use the following:</p>
	
	<?php $this->beginWidget('CTextHighlighter', array('language' => 'php')); ?>
		$u->getTags();
	<?php $this->endWidget(); ?>
	<p>This returns an array tags applied to this model like:</p>
	<?php dp($u->getTags()); ?>
	
	<h3>List All Tags For a Model</h3>
	<p>We also often want to get a list of all tags that currently exist across all models of a particular type. The most common useage is to display previously used tags in an auto-completing widget.</p>
	<?php $this->beginWidget('CTextHighlighter', array('language' => 'php')); ?>
		User::model()->getTags();
	<?php $this->endWidget(); ?>
		<p>When <code>getTags</code> is called on a static instance it assumes you want to get a list of all tags applied to all models. 
			In this case all tags applied to all <code>User</code> models.  
			This function will delegate to the <code>getModelTags()</code> function. 
			This means you can also return a list of all tags by calling <code>$u->getModelTags();</code> from the active record row itself.</p>
		
	<h3>List All Tags For All Models</h3>
	<p>Function to return all tags that have been used across the whole system.</p>
	<?php $this->beginWidget('CTextHighlighter', array('language' => 'php')); ?>
		User::model()->getAllTags();
		// or
		$u->getAllTags();
	<?php $this->endWidget(); ?>
	
	<p>So now we may want to search for all users that have the tag of <span class="label">admin</span></p>
	
	<?php $this->beginWidget('CTextHighlighter', array('language' => 'php')); ?>
		$users = User::model()->tag->search(array('admin'));
	<?php $this->endWidget(); ?>
		<p><code>$users</code> will be an array of user active record objects that have the tag of <span class="label">admin</span></p>
		<p><span class="label notice">note</span> we call the search function directly on the tag object <code>User::model()->tag</code> because often a search function already exists on active record models, and this will be called before the search funxtion of the <code>NTaggale</code> behavior</p>
		<p>check we have received the correct same user:</p>	
	<?php $this->beginWidget('CTextHighlighter', array('language' => 'php')); ?>
		foreach($users as $found)
			dp($found->email);
	<?php $this->endWidget(); ?>
			<p>The Result:</p>
	<?php 
		$users = User::model()->tag->search(array('admin'));
		foreach($users as $found)
			dp($found->email);
	?>
			
			<form method="post">
			<div class="line">
				<div class="unit size1of2">
					
					<div class="field">
						<label class="lbl" >Tags:</label>
						<?php $this->widget('nii.widgets.tokeninput.NTokenInput', array(
							'model'=>$u,
							'attribute'=>'tags',
							'data'=>$u->getModelTags(),
							'options'=>array('hintText'=>'','addNewTokens'=>true,'animateDropdown'=>false)
						)); ?>
					</div>
				</div>
				<div class="lastUnit">
					<div class="field ">
						<label class="lbl" >Some other field:</label>
						<div class="input ">
							<input type="text" />
						</div>
					</div>
				</div>
			</div>
				<input type="submit" value="submit" />
	</form>
<!--	</div>-->
	
	
	
	
</div>