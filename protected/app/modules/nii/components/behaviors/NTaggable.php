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
	

	
	
	
	
	

	public function preTableInit($sender, $event){
		//check search tag function has been implemented
		$rowclass = $this->getTable()->getRowClass();
		if(!method_exists($rowclass,'tagSearchData'))
			throw new CException('You must implement a tagSearchData() function on the row object "'.$rowclass.'" <br />');
	}

	public function postInsert(Newicon_Db_Row $sender, $event) {
		$this->setTags($sender);
	}

	public function postUpdate(Newicon_Db_Row $sender, $event) {
		$this->setTags($sender);
	}

	protected function setTags(Newicon_Db_Row $row) {
		if (!$tags = $row->getPluginData('tags'))
			$tags = array();
		$tagTbl = new Nworx_Utilities_Model_Tags();
		$tagTbl->setRowTags($tags, $row);
	}

	public function getColumn($columnName, $row) {
		$tagTbl = new Nworx_Utilities_Model_Tags();
		return $tagTbl->getRowTags($row);
	}
	
	
	
	
	
	
	/**
	 * adds or updates tags in the tags and tags association table.
	 * @param array $itemarray
	 * @param varchar $tablename
	 * @param int $recordid
	 */
	function updateTags($itemarray,$tablename,$recordid)
	{
		$tags = new Nworx_Utilities_Model_Tags();

		//Deletes all associations from the tag association table to prepare for the update and ensure that there are npt duplicate entries.
		//checks to make sure number is int

		if (is_int($recordid)===true) {
			$tagassocclear = new Nworx_Utilities_Model_TagAssociations();
			//
			// This is wrong - it deletes any entry for that table, not just the one for the row.
			//
			$tagassocclear->deleteQuery()->where('tablename =?',$tablename)->go();
		}

		// take the array and loop through it checking against the database
		foreach($itemarray as $row) {
			//If row not in database then adds item to items table.
			//if exists then just makes a note of the id of the row.
			$noindatabase = $tags->select()->where('name=?',$row)->go();

			if (count($noindatabase) ==0) {
				$tag = new Nworx_Utilities_Model_Tag();
				$tag->name = $row;
				$tag->save();
				$tagid = $tag->id();
			} else {
				$tagid = $noindatabase[0]->id;
				echo $tagid;
			}

			//Adds tag to the tag association table.
			$tagassoc = new Nworx_Utilities_Model_TagAssociation();
			$tagassoc->row_id = $recordid;
			$tagassoc->tag_id = $tagid;
			$tagassoc->tablename = $tablename;
			$tagassoc->save();
		}
	}
	
	
	
	
	
	public function configure() {
		$this->hasColumnPrimary('id');
		$this->hasColumnVarChar('name', 100);

		$this->hasUniqueIndex('name');
	}
	
	
	/**
	 * Gets all tags across all models
	 * 
	 * @return array array of tag_id => tag name e.g. array(1 => 'tag name', 3=> 'other tag')
	 */
	public function getAllModelsTags(){
		$res = NTag::model()->findAll(array('order'=>'tag ASC'));
		$tags = array(); foreach ($res as $r) $tags[$r->id] = $r->name;
		return $tags;
	}

	/**
	 * Get all known tags in the system for a particular model type.
	 * Returns all tags applied to every model of the current type (className)
	 * 
	 * @return array of tag id=>tag
	 */
	public function getAllTags() {
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
	 * Set the tags for a row
	 * @param array $tags  the full set of tags to be set
	 * @param Newicon_Db_Row $row  the row the tags are to be set on
	 * @return null
	 */
	public function setRowTags(array $tags)
	{
		
		$model = $this->getOwner();
		
		// delete all existing tags for this row in the associations table
		$this->deleteTags();
			
		if (count($tags)==0)
			return;

		// ok, so sort out the new set of tags
		foreach ($tags as $i=>$t)
			$tags[$i] = trim($t);

		// make sure that all of these tags exist in the tags table
		$tagsInsert = $this->multiInsert('name', true);
		foreach ($tags as $t)
			$tagsInsert->values($t);
		$tagsInsert->go();
		
		

		// now find all of the ids for the names provided
		$tids = $this->select()->where("`name` IN ('".implode("','",$tags)."')")->go();
		$tagIds = array();
		foreach ($tids as $tid)
			$tagIds[] = $tid->id();

		// and insert the new tags into the associations table
		$tagAssTbl->setRowTags($tagIds, $row);
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
		
		//if model context supplied return rows only for that table
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