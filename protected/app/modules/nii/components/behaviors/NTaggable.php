<?php

/**
 * NTaggable class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of NTaggable
 *
 * @author steve
 */
class NTaggable extends CActiveRecordBehavior
{
	
	

	/**
	 * Set the tags for a row, removes all existing tags and sets the tags to those specified
	 * in the $tags array, this is useful for input widgets that always post all tags
	 * @param array $tags  the full set of tags to be set
	 * @param Newicon_Db_Row $row  the row the tags are to be set on
	 * @return null
	 */
	public function setTags(array $tags)
	{
		Yii::import('nii.components.db.*');
		if(is_string($tags))
			$tags = array($tags);
		if(empty($tags))
			return;
		
		// delete all existing tags for this row in the associations table
		$this->deleteTags();
			
		if (count($tags)==0)
			return;

		// ok, so sort out the new set of tags
		foreach ($tags as $i=>$t)
			$tags[$i] = trim($t);

		// make sure that all of these tags exist in the tags table
		$q = new NQuery(NTag::model());
		$q->multiInsert(array('tag'), true);
		foreach ($tags as $t)
			$q->multiInsertValues(array($t));
		$q->execute();
		

		// now find all of the ids for the names provided
		$tagRows = NTag::model()->findAllByAttributes(array('tag'=>$tags));

		// and insert the new tags into the associations table
		$q = new NQuery(NTagLink::model());
		$q->multiInsert(array('model', 'model_id', 'tag_id'));
		$model = get_class($this->getOwner()); 
		foreach ($tagRows as $tag)
			$q->multiInsertValues(array($model, $this->getOwner()->id, $tag->id));
		$q->execute();
	}
	
	/**
	 * Gets all tags across all models
	 * 
	 * @return array array of tag_id => tag name e.g. array(1 => 'tag name', 3=> 'other tag')
	 */
	public function getAllTags(){
		$res = NTag::model()->findAll(array('order'=>'tag ASC'));
		$tags = array(); foreach ($res as $r) $tags[$r->id] = $r->tag;
		return $tags;
	}

	/**
	 * Get all known tags in the system for a particular model type.
	 * Returns all tags applied to every model of the current type (className)
	 * 
	 * @return array of tag id=>tag
	 */
	public function getModelTags() {
		$tagIds = array();
		$tagRows = NTagLink::model()->with('tag')->findAllByAttributes(array(
			'model'=>get_class($this->getOwner())), 
			array('order'=>'tag')
		);
		
		$tags = array();
		foreach ($tagRows as $t)
			$tags[$t->tag->id]=$t->tag->tag;
		
		return $tags;
	}

	/**
	 * Get all tags for this model, only return the tags for the specific model row
	 * @return array e.g. array('tag1', 'tag two', 'tag3')
	 */
	public function getTags()
	{
		// lets check if the owner is a true model
		if($this->getOwner()->getScenario()==''){
			// trying to get tags on a static instance so you must want
			// all tags applied to all of these model types
			return $this->getModelTags();
		}
		
		$tagRows = NTagLink::model()->with('tag')->findAllByAttributes(array(
			'model_id'=>$this->getOwner()->id, 
			'model'=>get_class($this->getOwner())), array('order'=>'tag ASC')
		);
		$tags = array();
		foreach ($tagRows as $t)
			$tags[$t->tag->id]=$t->tag->tag;
		
		return $tags;
	}
	
	
	/**
	 * Deletes all tags associated with this model
	 * @return void
	 */
	public function deleteTags(){
		NTagLink::model()->deleteAllByAttributes(array(
			'model_id'=>$this->getOwner()->id(), 
			'model'=>get_class($this->getOwner()))
		);
	}
	
	/**
	 * Find the models that have a set of tags associated with them
	 * for a given model type
	 * @param array $tags array of tag names array('tag1', 'tag2')
	 * @param NActiveRecord $model
	 * @return array | null if nothing found
	 */
	public function search($tags)
	{
		$model = $this->getOwner();
		
		if (count($tags)==0)
			return null;
		// find all of the ids for the tags provided
		$tids = NTag::model()->findAllByAttributes(array('tag'=>$tags));
		if (count($tids)==0)
			return null;
		
		$tagIds = array(); foreach ($tids as $tid) $tagIds[] = $tid->id();

		$res = NTagLink::model()->with('tag')->findAllByAttributes(
				array('model'=>get_class($model), 'tag_id'=>$tagIds),
				array('order'=>'model ASC'));
			
		$rowIds = array();$rows = array();
		foreach ($res as $t)
			$rowIds[] = $t->model_id; $rows[]=$t;
			
		if (count($rowIds) == 0)
			return null;
		
		return $model->findAllByAttributes(array('id'=>$rowIds));
	}
	
	/**
	 * Finds all models that have a set of tags associated with them
	 * @param $tags array of tag names
	 * @return array of NTagLink records | null if nothing found you can call the NTagLink::getRecord() 
	 * function to get the model the tag belongs to. 
	 */
	public function searchAllRows($tags)
	{
		if (count($tags)==0)
			return null;
		
		// find all of the ids for the tags provided
		$tids = NTag::model()->findAllByAttributes(array('tag'=>$tags));
		
		if (count($tids)==0)
			return null;
		
		$tagIds = array();
		foreach ($tids as $tid)
			$tagIds[] = $tid->id();
 
		$res = NTagLink::model()
				->with('tag')
				->findAllByAttributes(array('tag_id'=>$tagIds), array('order'=>'model ASC'));
			
		$rows = array();
		foreach ($res as $t)
			$rows[]=$t;
		if (count($rows) == 0)
			return null;
			
		return $rows;
	}
	
	/**
	 * Install necessary tables for behavior
	 */
	public static function install(){
		NAppRecord::install('NTag');
		NAppRecord::install('NTagLink');
	}
	
	
}