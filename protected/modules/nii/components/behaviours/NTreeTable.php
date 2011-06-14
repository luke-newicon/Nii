<?php

/**
 * The Nii tree table plugin
 * the owner ActiveRecord must have an id column which is a single primary key column
 *
 * @version 0.1
 */
class NTreeTable extends CActiveRecordBehavior 
{

	/**
	 * The left column name
	 * @var string
	 */
	public $left = 'tree_left';
	/**
	 * The right column name
	 * @var string
	 */
	public $right = 'tree_right';
	/**
	 * The tree level
	 * @var string
	 */
	public $level = 'tree_level';
	
	/**
	 * this class also maintains an acurate parent id cos its great and darn handy
	 * @var string
	 */
	public $parent = 'tree_parent';

	/**
	 * Returns left right and level values of the columns.
	 *
	 * This function has been designed to save space in functions which rely on
	 * the included values over and over again.
	 *
	 * Please pass this function blank variables. It will automagically change them for you.
	 * For example if you called getProperties($left);
	 *
	 * From that point onwards, $left will equal the left column name in the database.
	 * @param string $left null
	 * @param string $right null
	 * @param string $level null
	 */
	public function getProperties(&$left=null, &$right=null, &$level=null, &$parent=null) {
		$left = $this->left;
		$right = $this->right;
		$level = $this->level;
		$parent = $this->parent;
	}

	/**
	 * Returns all the nodes in a tree
	 * @return array of CActiveRecord's
	 */
	public function getAllNodes() {
		$baseNode = $this->getTreeRoot();
		return $this->getDescendentsOf($baseNode);
	}

	/**
	 * Gets the root row of the tree table
	 * @return CActiveRecord / null if none found
	 */
	public function getTreeRoot() {
		$search = $this->getOwner()->find($this->left . '=0');
		return $search;
	}

	/**
	 * Gets all of the descendants of a particular node through all levels
	 *
	 * Descendants are different to children as they are not limited to only the next level
	 * of the tree down.
	 * 
	 * @param CActiveRecord $node The node which you would like to find all the descendant of
	 * @return CActiveRecord
	 */
	public function getDescendentsOf(CActiveRecord $node) {
		$this->getProperties($left, $right);
		$nodes = $this->getOwner()->findAll(array(
			'condition' => "$left > :lft AND $right < :rgt",
			'params' => array(':lft' => $node->$left, ':rgt' => $node->$right),
			'order' => "$left ASC"
		));
		return $nodes;
	}

	/**
	 * shortcut to getDescendentsOf
	 * 
	 * @return array of CActiveRecord's
	 */
	public function getDescendents() {
		return $this->getDescendentsOf($this->getOwner());
	}

	/**
	 * Get all ancestors of a given node
	 * 
	 * @param CActiveRecord $node The node to get all the ancestors on
	 * @return CActiveRecord
	 */
	public function getAncestorsOf(CActiveRecord $node) {
		$this->getProperties($left, $right);
		$ancestors = $this->getOwner()->findAll(array(
			'condition' => "$left < :lft AND $right > :rgt",
			'params' => array(':lft' => $node->$left, ':rgt' => $node->$right),
			'order' => "$left ASC"
		));

		return $ancestors;
	}

	/**
	 * shortcut function to getAncestorsOf
	 *  
	 * @return array of CActiveRecord's 
	 */
	public function getAncestors() {
		return $this->getAncestorsOf($this->getOwner());
	}

	/**
	 * returns a CActiveRecord or boolean false
	 * 
	 * @param CActiveRecord $node
	 * @return CActiveRecord
	 */
	public function getParentOf(CActiveRecord $node) {
		$this->getProperties($left, $right, $level);
		$res = $this->getOwner()->find(array(
			'condition' => "$left < :left AND $right > :right AND $level > :level",
			'params' => array(':left' => $node->$left, ':right' => $node->$right, ':level' => $node->$level - 1)
		));

		if ($res->count() <= 0) {
			return false;
		}
		return $res->first[0];
	}

	/**
	 * shortcut function to getParentOf
	 * 
	 * @return CActiveRecord 
	 */
	public function getParent() {
		return $this->getParentOf($this->getOwner());
	}

	/**
	 * returns all children nodes of supplied node
	 *
	 * @param CActiveRecord $node
	 * @return list of CActiveRecords or empty array
	 */
	public function getChildrenOf(CActiveRecord $node) {

		$c = $this->getQueryChildrenOf($node);

		$search = $this->getOwner()->findAll($c);

		return $search;
	}

	/**
	 * This function is designed to be called from a row object and will discover all
	 * of the rows children.
	 *
	 * Note: When you find the children, it will only return the next level
	 * To find everything below the selected row, use getDescendants
	 *
	 * @see TreeTable::getChildrenOf
	 * @return list of CActiveRecords or empty array
	 */
	public function getChildren() {
		return $this->getChildrenOf($this->getOwner());
	}

	/**
	 * gets a criteria object prepopulated with criteria that selects children nodes form the specified $node
	 *
	 * @param CActiveRecord $node
	 * @return CDbCriteria
	 */
	public function getQueryChildrenOf(CActiveRecord $node) {
		$this->getProperties($left, $right, $level);
		$c = new CDbCriteria(array(
			'condition' => "$left > :nodeLeft AND $right < :nodeRight AND $level = :level",
			'params' => array(':nodeLeft' => $node->$left, ':nodeRight' => $node->$right, ':level' => $node->$level + 1)
		));
		return $c;
	}

	/**
	 * detach a node from the heirarchy
	 * 
	 * @param CActiveRecord $node 
	 */
	public function detachNode(CActiveRecord $node) {
		$this->getProperties($left, $right);
		$node->$left = -1;
		$node->$right = -1;
		$node->save();
	}

	/**
	 * deletes node and it's descendants
	 */
	public function deleteNode(CActiveRecord $node, $deleteDescendants = false) {

		$left = $this->left;
		$right = $this->right;

		$transaction = $this->getOwner()->dbConnection->beginTransaction();
		try {
			$t = $this->getDb()->beginTransaction();
			//TODO: add the setting whether or not to delete descendants or relocate children

			$this->getOwner()->deleteAll(array(
				'condition' => "$left >= :left AND <= :right",
				'params' => array(':left'=>$node->$left, ':right' => $node->$right))
			);

			$first = $node->$left + 1;
			$delta = $node->$right - $node->$left - 1;

			$this->_shiftRLValues($first, $delta);

			$t->commit();
		} catch (Exception $e) {
			$t->rollBack();
			throw $e;
		}

		return true;
	}

	/**
	 * Determines if node is valid
	 *
	 * @return bool 
	 */
	public function isValidNode($treeNode) {
		if ($treeNode instanceof CActiveRecord) {
			$this->getProperties($left, $right);
			return ($treeNode->$right > $treeNode->$left);
		} else {
			return false;
		}
	}

	/**
	 * adds the $node to the root node
	 * 
	 * @param CActiveRecord $node 
	 */
	public function addNodeToRoot($node) {
		// get root node
		$root = $this->getTreeRoot();
		$this->insertAsLastChildOf($node, $root);
	}

	/**
	 * inserts node as parent of dest record
	 *
	 * @param $insertNode the node to be inserted (will become the parent of $refNode)
	 * @param $refNode the node that already exists and will become the child of $insertNode
	 * @return bool
	 * @todo Wrap in transaction
	 */
	public function insertAsParentOf(CActiveRecord $insertNode, CActiveRecord $refNode) {
		$this->getProperties($colLeft, $colRight, $colLevel, $colParent);

		// cannot insert a node that has already has a place within the tree
		if ($this->isValidNode($insertNode))
			return false;

		// cannot insert as parent of root
		if ($refNode->$colLeft == 0)
			return false;

		// cannot insert as parent of itself
		if ($refNode === $insertNode) {
			throw new CException("Cannot insert node as parent of itself");
			return false;
		}

		$newLeft = $refNode->$colLeft;
		$newRight = $refNode->$colRight + 2;
		$newLevel = $refNode->$colLevel;

		try {
			$t = $this->getDb()->beginTransaction();

			// Make space for new node
			$this->_shiftRlValues($refNode->$right + 1, 2);

			// Slide child nodes over one and down one to allow new parent to wrap them
			$sql = "UPDATE `$tableName` SET ";
			$sql .= " $colLeft   = $colLeft+1, $colRight  = $colRight+1, $colLevel  = $colLevel+1, ";
			$sql .= " $colParent = {$insertNode->getPrimaryKey()}";
			$sql .= " WHERE $colLeft >= $newLeft AND $colRight<= $newRight";
			$this->getDb()->createCommand($sql)->execute();
			
			//  possible implementation with NQuery
			//  NQuery::get($this->getOwner())->update()
			//     ->set('tree_lft', 'tree_lft + 1', true)
			//     ->set('tree_rgt', 'tree_rgt + 1', true)
			//     ->set('tree_level', 'tree_level + 1', true)
			//     ->set('tree_parent', $insertNode->getPrimaryKey()())
			//     ->where('tree_lft >= ?', $newLeft)
			//     ->where('tree_rgt <= ?', $newRight)
			//     ->go();


			$this->_insertNode($insertNode, $newLeft, $newRight, $refNode->$colLevel, $refNode->$colParent);

			$t->commit();
		} catch (Exception $e) {
			$t->rollback();
			throw $e;
		}

		return true;
	}


	/**
	 * inserts node as previous sibling of refNode record
	 *
	 * @return bool
	 * @todo Wrap in transaction
	 */
	public function insertBeforeNode(CActiveRecord $insertNode, CActiveRecord $refNode) {
		// cannot insert a node that has already has a place within the tree
		if ($this->isValidNode($insertNode))
			return false;
		// cannot insert as sibling of itself
		if ($insertNode === $refNode) {
			throw CException("Cannot insert node as previous sibling of itself");
			return false;
		}

		$this->getProperties($left, $right, $level, $parent);
		
		$newLeft = $refNode->$left;
		$newRight = $refNode->$left + 1;

		try {
			$t = $this->getDb()->beginTransaction();

			$this->_shiftRlValues($newLeft, 2);

			$this->_insertNode($insertNode, $newLeft, $newRight, $refNode->$level, $refNode->$parent);

			$t->commit();
		} catch (Exception $e) {
			$t->rollback();
			throw $e;
		}

		return true;
	}

	/**
	 * inserts node as next sibling of dest record
	 *
	 * @return bool
	 * @todo Wrap in transaction
	 */
	public function insertAfterNode(CActiveRecord $insertNode, CActiveRecord $refNode) {
		// cannot insert a node that already has a place within the tree
		if ($this->isValidNode($insertNode))
			throw Exception('node is not valid!');
		return false;

		// cannot insert as sibling of itself
		if ($insertNode === $refNode) {
			throw Exception("Cannot insert node as next sibling of itself");
			return false;
		}
		
		$this->getProperties($left,$right,$level);

		$newLeft = $refNode->$right + 1;
		$newRight = $refNode->$right + 2;

		try {
			$t = $this->getDb()->beginTransaction();

			
			$this->_shiftRlValues($newLeft, 2);
			$this->_insertNode($insertNode, $newLeft, $newRight, $refNode->tree_level, $refNode->tree_parent);

			$t->commit();
		} catch (Exception $e) {
			$t->rollback();
			throw $e;
		}

		return true;
	}

	/**
	 * Inserts a new node into the tree
	 * @param CActiveRecord $node
	 * @param int $left The new left value
	 * @param int $right The new right value
	 * @param int $level The tree level
	 * @param int $parentId
	 */
	private function _insertNode(CActiveRecord $node, $left, $right, $level, $parentId) {
		$this->getProperties($colLeft,$colRight,$colLevel, $colParent);
		$node->$colLeft = $left;
		$node->$colRight = $right;
		$node->$colLevel = $level;
		$node->$colParent = $parentId;
		$node->save();
	}

	/**
	 * Inserts node as first child of dest record
	 * @return bool Whether or not the insert was a success
	 */
	public function insertAsFirstChildOf(CActiveRecord $node, CActiveRecord $parentNode) {

		// cannot insert as child of itself
		if ($parentNode === $node) {
			throw new CException("Cannot insert node as first child of itself");
			return false;
		}
		
		$this->getProperties($left,$right,$level);

		$newLeft = $parentNode->$left + 1;
		$newRight = $parentNode->$left + 2;

		try {
			$t = $this->getDb()->beginTransaction();

			$this->_shiftRlValues($newLeft, 2);
			$this->_insertNode($node, $newLeft, $newRight, $parentNode->$level + 1, $parentNode->getPrimaryKey());

			$t->commit();
		} catch (Exception $e) {
			$t->rollback();
			throw $e;
		}

		return true;
	}


	/**
	 * inserts node as last child of $parentNode record
	 *
	 * @return bool
	 * @todo Wrap in transaction
	 */
	public function insertAsLastChildOf(CActiveRecord $node, CActiveRecord $parentNode) {
		// cannot insert a node that has already has a place within the tree
		if ($this->isValidNode($node))
			return false;
		// cannot insert as child of itself
		if ($parentNode === $node) {
			throw new CException("Cannot insert node as last child of itself");
		}

		$this->getProperties($left,$right,$level);
		
		$newLeft = $parentNode->$right;
		$newRight = $parentNode->$right + 1;

		try {
			$t = Yii::app()->getDb()->beginTransaction();

			$this->_shiftRlValues($newLeft, 2);
			$this->_insertNode($node, $newLeft, $newRight, $parentNode->$level + 1, $parentNode->getPrimaryKey());

			$t->commit();
		} catch (Exception $e) {
			$t->rollback();
			throw $e;
		}

		return true;
	}

	public function insertAsLastChild($node){
		return $this->insertAsLastChildOf($node, $this->getOwner());
	}
	
	public function addChild($node){
		return $this->insertAsLastChildOf($node, $this->getOwner());
	}
	
	/**
	 * gets the path to node from root, uses row::__toString() method to get node names, or,
	 * if specified used the $colName of the node object for the string path $node->$colName
	 *
	 * @param CActiveRecord $node the treeRow node to draw the path for
	 * @param string $seperator path seperator
	 * @param string $colName the table column name to use as the string path if null thenthe __tostring method will be used
	 * @param bool $includeNode whether or not to include node at end of path
	 * @param bool $rootNode true to include the root node output at the beginning of the path
	 * @return string string representation of path
	 */
	public function getPath($node, $seperator = ' / ', $colName=null, $includeNode=false, $includeRoot=false) {
		$path = array();
		$ancestors = $node->getAncestors();
		if ($ancestors) {
			foreach ($ancestors as $a) {
				if ($a->isRoot() && !$includeRoot)
					continue;
				$path[] = ($colName) ? $a->$colName : $a->__toString();
			}
		}
		if ($includeNode) {
			$path[] = ($colName) ? $node->$colName : $node->__toString();
		}

		return implode($seperator, $path);
	}

	/**
	 * get a node from its path eg a/c/b/d/w
	 * returns false if the first node in the path does not exist. For example if there is no such node "a"
	 *
	 * Two byRef variables exist to return the progress if some nodes exist
	 * but the node with the full path does not. For example:
	 * if our path is a/b/c/d/e and all nodes up to node c exits, but node d does not,
	 * then the $node variable will contain an array of all nodes up to "c"
	 * and the $latestPath variable will be an array containing a,b,c
	 *
	 * @param $path
	 * @param $colName
	 * @param $nodes
	 * @param $latestPath
	 * @return Newicon_Db_TreeRow or false if no node found
	 */
	public function getNodeWithPath($path, $colName, &$nodes=array(), &$latestPath=array()) {

		$pathBits = explode('/', $path);
		$node = $this->fetchRow("$colName=?", $pathBits[0]);

		if (!$node) {
			return false;
		}

		foreach ($pathBits as $bit) {

			// don't run first loop as we have already found the first node
			if ($bit == $pathBits[0]) {
				continue;
			}

			$nodeRs = $node->getChildrenQuery()->where("$colName=?", $bit)->go();

			$nodes[] = $node;
			$latestPath[] = $node->$colName;

			if (0 == $nodeRs->count()) {
				return false;
			}

			$node = $nodeRs->current();
		}

		$nodes[] = $node;
		$latestPath[] = $node->$colName;

		return $node;
	}

	public function moveInsideNode($node, $refNode) {
		$this->moveAsLastChildOf($node, $refNode);
	}

	/**
	 * moves $node as first child of $parentNode record
	 *
	 * @param $node CActiveRecord
	 * @param $parentNode CActiveRecord
	 * @return boolean
	 * @throws CException
	 */
	public function moveAsFirstChildOf(CActiveRecord $node, CActiveRecord $parentNode) {
		$this->getProperties($colLeft, $colRight, $colLevel, $colParent);
		if ($parentNode === $node || $node->isAncestorOf($parentNode)) {
			throw new CException("Cannot move node as first child of itself or into a descendant");
			return false;
		}
		$oldLevel = $node->$colLevel;
		$node->$colLevel = $parentNode->$colLevel + 1;
		$node->$colParent = $parentNode->getPrimaryKey();
		$node->save();
		$this->_updateNode($node, $parentNode->$colLeft + 1, $node->$colLevel - $oldLevel);

		return true;
	}

	/**
	 * moves node as child of parent record position determines the position within the children
	 * to place the node. A position of 0 is equivelant to the first child. and thus the same as
	 * calling moveAsFistChildOf()
	 *
	 * @param CActiveRecord $node node to move
	 * @param CActiveRecord $parentNode the parent node of the new location
	 * @param int $position the position within the children of $parentNode in which to place the $node
	 * @return boolean
	 * @throws CException
	 */
	public function moveAsChildOf(CActiveRecord $node, CActiveRecord $parentNode, $position) {
		$this->getProperties($colLeft, $colRight, $colLevel, $colParent);
		
		if ($parentNode === $node || $node->isAncestorOf($parentNode)) {
			throw new CException("Cannot move node as first child of itself or into a descendant");
			return false;
		}
		// we should check the position is a sensible one
		if ($position != 0) {
			$children = $parentNode->getChildren();
			// position describes the new position for this node so look at the
			// sibling node above to calculate the new position of this node,
			// the child array is zero based
			$position = $position - 1;
			if (!$children->offsetExists($position))
				throw new CException("No child exists at position $position");

			$newLeft = $children[$position]->$colRight + 1;
		}else {
			// position is zero so insert as first child
			$newLeft = $parentNode->$colLeft + 1;
		}

		$oldLevel = $node->$colLevel;
		$node->$colLevel = $parentNode->$colLevel + 1;
		$node->$colParent = $parentNode->getPrimaryKey();
		$node->save();

		$this->_updateNode($node, $newLeft, $node->$colLevel - $oldLevel);

		return true;
	}

	/**
	 * moves node as last child of $parentNode
	 * 
	 * @param CActiveRecord $node the record that will become the last cild of $parentNode
	 * @param CActiveRecord $parentNode the parent node
	 * @throws CException
	 * @return void
	 */
	public function moveAsLastChildOf(CActiveRecord $node, CActiveRecord $parentNode) {
		$this->getProperties($colLeft, $colRight, $colLevel, $colParent);
		if ($parentNode === $node || $node->isAncestorOf($parentNode)) {
			throw new CException("Cannot move node as last child of itself or into one of its ancestors");
		}

		$oldLevel = $node->$colLevel;
		$node->$colLevel = $parentNode->$colLevel + 1;
		$node->$colParent = $parentNode->getPrimaryKey();
		$node->save();
		$this->_updateNode($node, $parentNode->$colRight, $node->$colLevel - $oldLevel);
	}

	/**
	 * moves $node before $refNode
	 * 
	 * @param CActiveRecord $node the node to move before $refNode
	 * @param CActiveRecord $refNode 
	 * @return void
	 */
	public function moveBeforeNode($node, $refNode) {
		$this->getProperties($colLeft, $colRight, $colLevel, $colParent);
		$oldLevel = $node->$colLevel;
		$node->$colLevel = $refNode->$colLevel;
		$node->$colParent = $refNode->$colParent;
		$node->save();
		$this->_updateNode($node, $refNode->$colLeft, $node->$colLevel - $oldLevel);
	}

	/**
	 * moves $node after the $refNode
	 * 
	 * @param CActiveRecord $node 
	 * @param CActiveRecord $refNode 
	 */
	public function moveAfterNode($node, $refNode) {
		$this->getProperties($colLeft, $colRight, $colLevel, $colParent);
		$oldLevel = $node->$colLevel;
		$node->$colLevel = $refNode->$colLevel;
		$node->$colParent = $refNode->$colParent;
		$node->save();
		$this->_updateNode($node, $refNode->$colRight + 1, $node->$colLevel - $oldLevel);
	}
	
	/**
	 * move node's and its children to location $destLeft and updates rest of tree
	 *
	 * @param int $destLeft destination left value
	 */
	private function _updateNode($node, $destLeft, $levelDiff) {
		$this->getProperties($colLeft, $colRight, $colLevel);
		$left = $node->$colLeft;
		$right = $node->$colRight;

		$treeSize = $right - $left + 1;

		try {
			$t = $this->getDb()->beginTransaction();

			// Make room in the new branch
			$this->_shiftRlValues($destLeft, intval($treeSize));

			if ($left >= $destLeft) { // src was shifted too?
				$left += $treeSize;
				$right += $treeSize;
			}

			// update level for descendants
			$tableName = $this->getOwner()->tableName();
			$sql = "UPDATE `$tableName` SET $colLevel = $colLevel + $levelDiff WHERE $colLeft > $left AND $colRight < $right";
			$this->getDb()->createCommand($sql)->execute();
			
			// NQuery::get($this->getOwner())->update()
			//     ->set('tree_level', "tree_level + $levelDiff", true)
			//     ->where('tree_lft > ?', $left)
			//     ->where('tree_rgt < ?', $right)
			//     ->go();

			// now there's enough room next to target to move the subtree
			$this->_shiftRlRange($left, $right, $destLeft - $left);

			// correct values after source (close gap in old tree)
			$this->_shiftRlValues($right + 1, -$treeSize);

			$t->commit();
		} catch (Exception $e) {
			$t->rollback();
			throw $e;
		}

		return true;
	}

	/**
	 * adds '$delta' to all Left and Right values that are >= '$first'. '$delta' can also be negative.
	 *
	 * Note: This method does not wrap its database queries in a transaction. This should be done
	 * by the invoking code.
	 *
	 * @param int $first First node to be shifted
	 * @param int $delta Value to be shifted by, can be negative
	 */
	public function _shiftRlValues($first, $delta) {

		$this->getProperties($left, $right);

		// shift left columns
		$tableName = $this->getOwner()->tableName();
		$this->getDb()->createCommand("UPDATE `$tableName` SET `$left` = $left + $delta WHERE $left >= $first")->execute();
		$this->getDb()->createCommand("UPDATE `$tableName` SET `$right` = $right + $delta WHERE $right >= $first")->execute();		
	}
	
	/**
	 * get the active db connection
	 * 
	 * @return CDbConnection 
	 */
	public function getDb(){
		return $this->getOwner()->getDbConnection();
	}

	/**
	 * adds '$delta' to all Left and Right values that are >= '$first' and <= '$last'.
	 * '$delta' can also be negative.
	 *
	 * Note: This method does wrap its database queries in a transaction. This should be done
	 * by the invoking code.
	 *
	 * @param int $first First node to be shifted (L value)
	 * @param int $last	Last node to be shifted (L value)
	 * @param int $delta Value to be shifted by, can be negative
	 */
	private function _shiftRlRange($first, $last, $delta) {
		$this->getProperties($left,$right);
		$tableName = $this->getOwner()->tableName();
		$this->getDb()->createCommand("UPDATE `$tableName` SET `$left` = $left + $delta WHERE $left >= $first AND $left <= $last")->execute();
		$this->getDb()->createCommand("UPDATE `$tableName` SET `$right` = $right + $delta WHERE $right >= $first AND $right <= $last")->execute();	
	}

	/**
	 * Recusive *Expensive* function that rebuilds the tree based on the parentId
	 * 
	 * @param CActiveRecord $parent
	 * @param int $left
	 * @param int $level
	 * @return void
	 */
	private function rebuildTree($parent, $left, $level=0) {
		$this->getProperties($colLeft,$colRight,$colLevel,$colParent);
		
		// the right value of this node is the left value + 1
		$right = $left + 1;

		// get all children of this node
		// getChildrenByParentId
		
		
		$children = $this->getOwner()->findAll(array(
			'condition'=>"$colParent=:pid", 
			'params'=>array(':pid'=>$parent->getPrimaryKey()),
			'order'=>$colLeft
		));

		foreach ($children as $node) {
			// recursive execution of this function for each child of this node
			// $right is the current right value, which is
			// incremented by the rebuild_tree function
			$right = $this->rebuildTree($node, $right, $level + 1);
		}

		// we've got the left value, and now that we've processed
		// the children of this node we also know the right value
		$parent->$colLevel = $level;
		$parent->$colLeft = $left;
		$parent->$colRight = $right;
		$parent->save();

		// return the right value of this node + 1
		return $right + 1;
	}

	/**
	 * Checks and settings that should be carried out after a tree table has been created
	 * by default a tree table needs a root node in order to add new nodes.
	 * 
	 * @return void
	 */
	protected function _afterCreateTable() {
		// check we don't already have a root node
		if (count($this->select()->where('tree_lft=?', 0)->limit(1)->go()))
			return;

		// ok, so create a root node
		$row = $this->createRow();
		$row->tree_lft = 0;
		$row->tree_rgt = 1;
		$row->tree_parent = 0;
		$row->tree_level = 0;
		$row->save();
	}



	/**
	 * if the node has children
	 * 
	 * @return boolean 
	 */
	public function hasChildren(){
		$this->getProperties($left, $right);
		$node = $this->getOwner();
		return ($node->$right > ($node->$left + 1)) ? true : false;
	}

	
	/**
	 * Get an array in jstree format representing all nodes within the $rootNode
	 * 
	 * @param CActiveRecord $rootNode the node to start from (typically the root)
	 * @return array 
	 */
	public function generateJstreeArray($rootNode=null){
		$tree= null;
		if($rootNode===null)
			$rootNode = $this->getTreeRoot();
		$this->_generateJstreeArrayRecursive($rootNode, $tree);
		return $tree;
	}
	
	/**
	 * recursive function to generate jstree array
	 * 
	 * @param CActiveRecord $rootNode
	 * @param array $tree 
	 */
	private function _generateJstreeArrayRecursive($rootNode, &$tree=array()){
		// if child
		$myArr = $this->getJstreeNodeArray($rootNode);
		$tree[] =& $myArr;
		
		if($rootNode->hasChildren()){
			$items = array();
			$myArr['children'] =& $items;
			foreach($rootNode->getChildren() as $child) {
				$this->_generateJstreeArrayRecursive($child, $items);
			}
		}
	}
	
	/**
	 * Return the array format for a single jstree node.
	 * This ignores the node's children to complete an entrie array including children
	 * use generateJstreeArray function
	 * 
	 * @param CActiveRecord $node
	 * @return array 
	 */
	public function getJstreeNodeArray($node){
		$ret = array('data'=>$node->name, 'attr'=>array('data-id'=>$node->getPrimaryKey()));
		if($node->hasChildren()){
			$ret['state'] = 'closed';
		}
		return $ret;
	}
	


	/***
	 * MATT WHAT THE FECK IS ALL THIS LOT??
	 * COMMENTS PLEASE, IF NOT USED, FOR THE LOVE OF GOD, DELETE IT!
	 * DOES IT EVEN WORK?
	 */
	
	
	public $displayArray = array();


	private function addDisplayItem($node) {
		$this->getProperties($left, $right, $level);
		$this->displayArray[] = array('name' => $node->name, 'level' => $node->$level, 'type' => $node->type, 'id' => $node->getPrimaryKey());
	}

	private $displayLevel;

	/**
	 *
	 * @param node $rootNode if not specified root assumed
	 * @return <type>
	 */
	public function generateMenuArray($rootNode=null,$webAddress='logic/index',$idVar=null){
		$tree= null;
		if($rootNode===null)
			$rootNode = $this->getTreeRoot();
		$this->_generateMenuArrayRecusive($rootNode, $tree,$webAddress,$idVar);
		return $tree;
	}

	/**
	 *
	 *
	 * @param <type> $rootNode
	 * @param <type> $array
	 */
	protected function _generateMenuArrayRecusive($rootNode, &$tree=array(),$webAddress=null,$idVar=null){

		// if child
		if($webAddress)
			$myArr = array('id'=>$rootNode->getPrimaryKey(), 'name'=>$rootNode->name, 'label'=>$rootNode->name,'url'=>array($webAddress,$idVar=>$rootNode->getPrimaryKey()));
		else{
			$myArr = array('id'=>$rootNode->getPrimaryKey(), 'name'=>$rootNode->name, 'label'=>$rootNode->name);
		}
		$tree[] =& $myArr;
		
		if($rootNode->hasChildren()){
			$items = array();
			$myArr['items'] =& $items;
			foreach($rootNode->getChildren() as $child){
				$this->_generateMenuArrayRecusive($child, $items,$webAddress,$idVar);
			}
		}
	}
	
	
	
	public function getTree($node) {
		if (count($this->displayArray) == null)
			$this->generateLiTree($node);
		return $this->displayArray;
	}

	/**
	 *
	 * @param CActiveRecord $node The node to use as the base for the tree
	 * @param array $options An array of options to use when creating the tree
	 *
	 */
	public function displayTree($node, $nameColumn='name',  $options = array()) {

		//if the display array is not set then generates it.
		if (count($this->displayArray) == 0) {
			$this->generateLiTree($node);
		}
		// Used to contain the data which will be retured to the view.
		$return = null;

		$test = ($this->getTree($node));
		$level = 0;

		foreach ($test as $t) {
			if ($t['level'] > $level) {
				$return .= '<ul style="padding-left:10px;margin-bottom:0px;">';
				$level = $t['level'];
			} else if ($t['level'] < $level) {
				$return .= '</ul>';
				$level = $t['level'];
			}

			$id = $t['id'];
			$name = $t['name'];

			if ($level != 0 ) {
				$return .= print_r($options['itemLink']).'<li style="list-style-type:none;">';
					$return .= $t['type'].'<a href="#">' . $t['name'] . '</a>';
				$return .='</li>';
			}
		}

		echo $return;
	}

	
	public function generateNestedArray($node){
		//Sets properties which are referred to in this function
		$this->getProperties($left, $right, $level);

		// If the level is below the last one then adds its information to the output array
		if ($node->level > $this->displayLevel) {
			$return = $this->addDisplayItem($node);
		}

		// Cycles through every item on the level
		foreach ($node->getChildren() as $item) {
			$nodeChildren = $item->getChildren();

			// Does this level have items below it
			if (!empty($nodeChildren))
				$nodeHasChildren = true;
			else
				$nodeHasChildren = false;

			// The display level needs to be updated to stop infinate looop.
			$this->displayLevel = $node->$level;

			// If the node has children then calls itself again
			if ($nodeHasChildren) {
				$this->generateLiTree($item);
			}

			// If the bottom node then adds the node information to the output array
			if ($node->$level == $this->displayLevel) {
				$this->addDisplayItem($item);
			}
		}

		return $return;
	}

}