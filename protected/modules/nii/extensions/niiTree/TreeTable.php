<?php

/**
 * The Nii tree table plugin
 * Should move to components
 *
 * @version 0.1
 */
class TreeTable extends CActiveRecordBehavior {

	/**
	 * The left column name
	 * @var string
	 */
	public $left;
	/**
	 * The right column name
	 * @var string
	 */
	public $right;
	/**
	 * The tree level
	 * @var string
	 */
	public $level;

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
	public function getProperties(&$left=null, &$right=null, &$level=null) {
		$left = $this->left;
		$right = $this->right;
		$level = $this->level;
	}

	/**
	 * Returns all the nodes in a tree
	 * @return <type>
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

	public function getTree_lft() {
		
	}

	public function getTree_right(){

	}

	/**
	 * @return array of CActiveRecord
	 */
	public function getDescendents() {
		return $this->getDescendentsOf($this->getOwner());
	}

	/**
	 * Get all ancestors of a given node
	 * @param CActiveRecord $node The node to get all the ancestors on
	 * @return CActiveRecord
	 */
	public function getAncestorsOf(CActiveRecord $node) {
		$left = $this->left;
		$right = $this->right;

		$ancestors = $this->getOwner()->findAll(array(
					'condition' => "$left < :lft AND $right > :rgt",
					'params' => array(':lft' => $node->$left, ':rgt' => $node->$right),
					'order' => "$left ASC"
				));

		return $ancestors;
	}

	public function getAcestors() {
		return $this->getAncestorsOf($this->getOwner());
	}

	/**
	 * returns a Newicon_Db_TreeRow or boolean false
	 * @param Newicon_Db_TreeRow $node
	 * @return Newicon_Db_TreeRow
	 */
	public function getParentOf(CActiveRecord $node) {
		$left = $this->left;
		$right = $this->right;
		$level = $this->level;

		$res = $this->getOwner()->find(array(
					'condition' => "$left < :left AND $right > :right AND $level > :level",
					'params' => array(':left' => $node->$left, ':right' => $node->$right, ':level' => $node->$level - 1)
				));

		if ($res->count() <= 0) {
			return false;
		}
		return $res->first[0];
	}

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
	 * gets a query object to perform a node children select query
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
			Yii::app()->db->startTransaction();
			//TODO: add the setting whether or not to delete descendants or relocate children

			$this->getOwner()->deleteAll(array(
				'condition' => "$left >= :left AND <= :right",
				'params' => array(':left' => $node->$left, ':right' => $node->$right)));

			$first = $node->$left + 1;
			$delta = $node->$right - $node->$left - 1;

			$this->_shiftRLValues($first, $delta);

			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollBack();
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

	public function addNodeToRoot($node) {

		//get root node
		$parentNode = $this->getTreeRoot();

		$this->insertAsLastChildOf($node, $parentNode);
	}

	/**
	 * inserts node as parent of dest record
	 *
	 * @return bool
	 * @todo Wrap in transaction
	 */
//	public function insertAsParentOf(Newicon_Db_TreeRow $insertNode, Newicon_Db_TreeRow $refNode) {
//		$this->getProperties($left, $right, $level);
//
//		// cannot insert a node that has already has a place within the tree
//		if ($this->isValidNode($insertNode))
//			return false;
//
//		// cannot insert as parent of root
//		if ($refNode->$left == 0)
//			return false;
//
//		// cannot insert as parent of itself
//		if ($refNode === $insertNode) {
//			throw new Doctrine_Tree_Exception("Cannot insert node as parent of itself");
//			return false;
//		}
//
//		$newLeft = $refNode->$left;
//		$newRight = $refNode->$right + 2;
//		$newLevel = $refNode->$level;
//
//		try {
//			$this->getDb()->startTransaction();
//
//			// Make space for new node
//			$this->_shiftRlValues($refNode->$right + 1, 2);
//
//			// Slide child nodes over one and down one to allow new parent to wrap them
//			$this->queryUpdate()
//					->set('tree_lft', 'tree_lft + 1', true)
//					->set('tree_rgt', 'tree_rgt + 1', true)
//					->set('tree_level', 'tree_level + 1', true)
//					->set('tree_parent', $insertNode->id())
//					->where('tree_lft >= ?', $newLeft)
//					->where('tree_rgt <= ?', $newRight)
//					->go();
//
//			$this->getOwner()->updateAll(
//					array(
//						$left = $left + 1,
//						$right = $right + 1,
//						$level = $level + 1,
//					)
//			);
//
//			$this->_insertNode($insertNode, $newLeft, $newRight, $refNode->tree_level, $refNode->tree_parent);
//
//			$this->getDb()->commit();
//		} catch (Exception $e) {
//			$this->getDb()->rollback();
//			throw $e;
//		}
//
//		return true;
//	}

//
//	/**
//	 * inserts node as previous sibling of dest record
//	 *
//	 * @return bool
//	 * @todo Wrap in transaction
//	 */
//	public function insertBeforeNode(Newicon_Db_TreeRow $insertNode, Newicon_Db_TreeRow $refNode) {
//		// cannot insert a node that has already has a place within the tree
//		if ($this->isValidNode($insertNode))
//			return false;
//		// cannot insert as sibling of itself
//		if ($insertNode === $refNode) {
//			throw Newicon_Exception("Cannot insert node as previous sibling of itself");
//			return false;
//		}
//
//		$newLeft = $refNode->tree_lft;
//		$newRight = $refNode->tree_lft + 1;
//
//		try {
//			$this->getDb()->startTransaction();
//
//			$this->_shiftRlValues($newLeft, 2);
//
//			$this->_insertNode($insertNode, $newLeft, $newRight,
//					$refNode->tree_level, $refNode->tree_parent);
//
//			$this->getDb()->commit();
//		} catch (Exception $e) {
//			$this->getDb()->rollback();
//			throw $e;
//		}
//
//		return true;
//	}
//
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

		$newLeft = $refNode->tree_rgt + 1;
		$newRight = $refNode->tree_rgt + 2;

		try {
			$transaction = Yii::app()->getDb()->beginTransaction();

			$this->_shiftRlValues($newLeft, 2);
			$this->_insertNode($insertNode, $newLeft, $newRight, $refNode->tree_level, $refNode->tree_parent);

			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollback();
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
		$left = $this->left;
		$right = $this->right;
		$level = $this->level;

		$node = $this->getOwner();
		$node->$left = $left;
		$node->$right = $right;
		$node->$level = $level;
		$node->tree_parent = $parentId;
		$node->save();
	}

	/**
	 * Inserts node as first child of dest record
	 * @return bool Whether or not the insert was a success
	 */
	public function insertAsFirstChildOf(CActiveRecord $node, CActiveRecord $parentNode) {

		// cannot insert as child of itself
		if ($parentNode === $node) {
			throw new Newicon_Exception("Cannot insert node as first child of itself");
			return false;
		}

		$newLeft = $parentNode->tree_lft + 1;
		$newRight = $parentNode->tree_lft + 2;

		try {
			$t = Yii::app()->getDb()->beginTransaction();

			$this->_shiftRlValues($newLeft, 2);

			$this->_insertNode($node, $newLeft, $newRight,
					$parentNode->tree_level + 1, $parentNode->id());

			$t->commit();
		} catch (Exception $e) {
			$t->rollback();
			throw $e;
		}

		return true;
	}

//
//	/**
//	 * inserts node as last child of dest record
//	 *
//	 * @return bool
//	 * @todo Wrap in transaction
//	 */
//	public function insertAsLastChildOf(Newicon_Db_TreeRow $node, Newicon_Db_TreeRow $parentNode) {
//		// cannot insert a node that has already has a place within the tree
//		if ($this->isValidNode($node))
//			return false;
//		// cannot insert as child of itself
//		if ($parentNode === $node) {
//			throw new Newicon_Exception("Cannot insert node as last child of itself");
//		}
//
//		$newLeft = $parentNode->tree_rgt;
//		$newRight = $parentNode->tree_rgt + 1;
//
//		try {
//			$this->getDb()->startTransaction();
//
//			$this->_shiftRlValues($newLeft, 2);
//
//			$this->_insertNode($node, $newLeft, $newRight, $parentNode->tree_level + 1, $parentNode->id());
//
//			$this->getDb()->commit();
//		} catch (Exception $e) {
//			$this->getDb()->rollback();
//
//			throw $e;
//		}
//
//		return true;
//	}
//
//	/**
//	 * gets the path to node from root, uses row::__toString() method to get node names, or,
//	 * if specified used the $colName of the node object for the string path $node->$colName
//	 *
//	 * @param Newicon_Db_TreeRow $node the treeRow node to draw the path for
//	 * @param string $seperator path seperator
//	 * @param string $colName the table column name to use as the string path if null thenthe __tostring method will be used
//	 * @param bool $includeNode whether or not to include node at end of path
//	 * @param bool $rootNode true to include the root node output at the beginning of the path
//	 * @return string string representation of path
//	 */
//	public function getPath($node, $seperator = ' / ', $colName=null, $includeNode=false, $includeRoot=false) {
//		$path = array();
//		$ancestors = $node->getAncestors();
//		if ($ancestors) {
//			foreach ($ancestors as $a) {
//				if ($a->isRoot() && !$includeRoot)
//					continue;
//				$path[] = ($colName) ? $a->$colName : $a->__toString();
//			}
//		}
//		if ($includeNode) {
//			$path[] = ($colName) ? $node->$colName : $node->__toString();
//		}
//
//		return implode($seperator, $path);
//	}
//
//	/**
//	 * get a node from its path eg a/c/b/d/w
//	 * returns false if the first node in the path does not exist. For example if there is no such node "a"
//	 *
//	 * Two byRef variables exist to return the progress if some nodes exist
//	 * but the node with the full path does not. For example:
//	 * if our path is a/b/c/d/e and all nodes up to node c exits, but node d does not,
//	 * then the $node variable will contain an array of all nodes up to "c"
//	 * and the $latestPath variable will be an array containing a,b,c
//	 *
//	 * @param $path
//	 * @param $colName
//	 * @param $nodes
//	 * @param $latestPath
//	 * @return Newicon_Db_TreeRow or false if no node found
//	 */
//	public function getNodeWithPath($path, $colName, &$nodes=array(), &$latestPath=array()) {
//
//		$pathBits = explode('/', $path);
//		$node = $this->fetchRow("$colName=?", $pathBits[0]);
//
//		if (!$node) {
//			return false;
//		}
//
//		foreach ($pathBits as $bit) {
//
//			// don't run first loop as we have already found the first node
//			if ($bit == $pathBits[0]) {
//				continue;
//			}
//
//			$nodeRs = $node->getChildrenQuery()->where("$colName=?", $bit)->go();
//
//			$nodes[] = $node;
//			$latestPath[] = $node->$colName;
//
//			if (0 == $nodeRs->count()) {
//				return false;
//			}
//
//			$node = $nodeRs->current();
//		}
//
//		$nodes[] = $node;
//		$latestPath[] = $node->$colName;
//
//		return $node;
//	}
//
//	public function moveInsideNode($node, $refNode) {
//		$this->moveAsLastChildOf($node, $refNode);
//	}
//
//	/**
//	 * moves node as first child of dest record
//	 *
//	 * @return boolean
//	 * @throws Newicon_Exception
//	 */
//	public function moveAsFirstChildOf(Newicon_Db_TreeRow $node, Newicon_Db_TreeRow $parentNode) {
//		if ($parentNode === $node || $node->isAncestorOf($parentNode)) {
//			throw new Newicon_Exception("Cannot move node as first child of itself or into a descendant");
//			return false;
//		}
//		$oldLevel = $node->tree_level;
//		$node->tree_level = $parentNode->tree_level + 1;
//		$node->tree_parent = $parentNode->id();
//		$node->save();
//		$this->_updateNode($node, $parentNode->tree_lft + 1, $node->tree_level - $oldLevel);
//
//		return true;
//	}
//
//	/**
//	 * moves node as child of parent record position determines the position within the children
//	 * to place the node. A position of 0 is equivelant to the first child. and thus the same as
//	 * calling moveAsFistChildOf()
//	 *
//	 * @param Newicon_Db_TreeRow $node node to move
//	 * @param Newicon_Db_TreeRow $parentNode the parent node of the new location
//	 * @param int $position the position within the children of $parentNode in which to place the $node
//	 * @return boolean
//	 * @throws Newicon_Exception
//	 */
//	public function moveAsChildOf(Newicon_Db_TreeRow $node, Newicon_Db_TreeRow $parentNode, $position) {
//		if ($parentNode === $node || $node->isAncestorOf($parentNode)) {
//			throw new Newicon_Exception("Cannot move node as first child of itself or into a descendant");
//			return false;
//		}
//		//we should check the position is a sensible one
//		if ($position != 0) {
//			$children = $parentNode->getChildren();
//			//position describes the new position for this node so look at the
//			//sibling node above to calculate the new position of this node,
//			//the child array is zero based
//			$position = $position - 1;
//			if (!$children->offsetExists($position))
//				throw new Newicon_Exception("No child exists at position $position");
//
//			$newLeft = $children[$position]->tree_rgt + 1;
//		}else {
//			// position is zero so insert as first child
//			$newLeft = $parentNode->tree_lft + 1;
//		}
//
//		//implement check here
//		$oldLevel = $node->tree_level;
//		$node->tree_level = $parentNode->tree_level + 1;
//		$node->tree_parent = $parentNode->id();
//		$node->save();
//
//		$this->_updateNode($node, $newLeft, $node->tree_level - $oldLevel);
//
//		return true;
//	}
//
//	/**
//	 * moves node as last child of $parentNode
//	 * @throws Newicon_Exception
//	 * @return boolean true on success
//	 */
//	public function moveAsLastChildOf(Newicon_Db_TreeRow $node, Newicon_Db_TreeRow $parentNode) {
//		if ($parentNode === $node || $node->isAncestorOf($parentNode)) {
//			throw new Newicon_Exception("Cannot move node as last child of itself or into one of its ancestors");
//		}
//
//		$oldLevel = $node->tree_level;
//		$node->tree_level = $parentNode->tree_level + 1;
//		$node->tree_parent = $parentNode->id();
//		$node->save();
//		$this->_updateNode($node, $parentNode->tree_rgt, $node->tree_level - $oldLevel);
//		return true;
//	}
//
//	public function moveBeforeNode($node, $refNode) {
//		$oldLevel = $node->tree_level;
//		$node->tree_level = $refNode->tree_level;
//		$node->tree_parent = $refNode->tree_parent;
//		$node->save();
//		$this->_updateNode($node, $refNode->tree_lft, $node->tree_level - $oldLevel);
//	}
//
//	public function moveAfterNode($node, $refNode) {
//		$oldLevel = $node->tree_level;
//		$node->tree_level = $refNode->tree_level;
//		$node->tree_parent = $refNode->tree_parent;
//		$node->save();
//		$this->_updateNode($node, $refNode->tree_rgt + 1, $node->tree_level - $oldLevel);
//	}
//
//	/**
//	 * move node's and its children to location $destLeft and updates rest of tree
//	 *
//	 * @param int $destLeft destination left value
//	 */
//	private function _updateNode($node, $destLeft, $levelDiff) {
//		$left = $node->tree_lft;
//		$right = $node->tree_rgt;
//
//		$treeSize = $right - $left + 1;
//
//		try {
//			$this->getDb()->startTransaction();
//
//			// Make room in the new branch
//			$this->_shiftRlValues($destLeft, intval($treeSize));
//
//			if ($left >= $destLeft) { // src was shifted too?
//				$left += $treeSize;
//				$right += $treeSize;
//			}
//
//			// update level for descendants
//			$this->queryUpdate()
//					->set('tree_level', "tree_level + $levelDiff", true)
//					->where('tree_lft > ?', $left)
//					->where('tree_rgt < ?', $right)
//					->go();
//
//			// now there's enough room next to target to move the subtree
//			$this->_shiftRlRange($left, $right, $destLeft - $left);
//
//			// correct values after source (close gap in old tree)
//			$this->_shiftRlValues($right + 1, -$treeSize);
//
//			$this->getDb()->commit();
//		} catch (Exception $e) {
//			$this->getDb()->rollback();
//			throw $e;
//		}
//
//		return true;
//	}

	/**
	 * adds '$delta' to all Left and Right values that are >= '$first'. '$delta' can also be negative.
	 *
	 * Note: This method does wrap its database queries in a transaction. This should be done
	 * by the invoking code.
	 *
	 * @param int $first First node to be shifted
	 * @param int $delta Value to be shifted by, can be negative
	 */
	public function _shiftRlValues($first, $delta) {

		$this->getProperties($left, $right);

		// shift left columns
		$this->getOwner()->updateAll(
				array("$left" => "$left + $delta"),
				array(
					'condition' => "$left >=:treeLeft",
					'params' => array(':treeLeft' => $first)
				)
		);

		$this->getOwner()->updateAll(
				array("$right" => "$right + $delta"),
				array(
					'condition' => "$right >=:treeRight",
					'params' => array(':treeRight' => $first)
				)
		);
	}

	/**
	 * adds '$delta' to all Left and Right values that are >= '$first' and <= '$last'.
	 * '$delta' can also be negative.
	 *
	 * Note: This method does wrap its database queries in a transaction. This should be done
	 * by the invoking code.
	 *
	 * @param int $first		 First node to be shifted (L value)
	 * @param int $last		 Last node to be shifted (L value)
	 * @param int $delta				 Value to be shifted by, can be negative
	 */
	private function _shiftRlRange($first, $last, $delta) {

		// shift left column values
		$this->getOwner()->updateAll(
				array(
					$this->left = $this->left + $delta
				),
				array(
					'condition' => "$this->left >=:treeLeft AND $this->left <= :treeLast",
					'params' => array('treeLeft' => $first, 'treeLast' => $last)));

		$this->getOwner()->updateAll(
				array(
					$this->right = $this->right + $delta
				),
				array(
					'condition' => "$this->right >=:treeRight AND $this->right <= :treeLast",
					'params' => array('treeRight' => $first, 'treeLast' => $last)));
	}

	/**
	 * Rebuilds the tree
	 * @param <type> $parent
	 * @param <type> $left
	 * @param <type> $level
	 * @return <type>
	 */
	private function rebuildTree($parent, $left, $level=0) {
		// the right value of this node is the left value + 1
		$right = $left + 1;

		// get all children of this node
		// getChildrenByParentId
		$children = $this->select()
						->where('tree_parent=?', $parent->id())
						->order('tree_lft')
						->go();

		foreach ($children as $node) {
			// recursive execution of this function for each child of this node
			// $right is the current right value, which is
			// incremented by the rebuild_tree function
			$right = $this->rebuildTree($node, $right, $level + 1);
		}

		// we've got the left value, and now that we've processed
		// the children of this node we also know the right value
		$parent->tree_level = $level;
		$parent->tree_lft = $left;
		$parent->tree_rgt = $right;
		$parent->save();

		// return the right value of this node + 1
		return $right + 1;
	}

	/**
	 * Checks that should be carried out after a tree table has been created
	 * @return <type>
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

	public $displayArray = array();

//	private function addDisplayItem($node) {
//		$this->getProperties($left, $right, $level);
//		$this->displayArray[] = array('name' => $node->name, 'level' => $node->$level, 'type' => $node->type, 'id' => $node->id);
//	}

	private function addDisplayItem($node) {
		$this->getProperties($left, $right, $level);
		$this->displayArray[] = array('name' => $node->name, 'level' => $node->$level, 'type' => $node->type, 'id' => $node->id);
	}

	private $displayLevel;

//	function generateLiTree($node) {
//		//Sets properties which are referred to in this function
//		$this->getProperties($left, $right, $level);
//
//		// If the level is below the last one then adds its information to the output array
//		if($node->level > $this->displayLevel){
//			$this->addDisplayItem($node, true);
//		}
//
//		// Cycles through every item on the level
//		foreach ($node->getChildren() as $item) {
//			$nodeChildren = $item->getChildren();
//
//
//			// Does this level have items below it
//			if (!empty($nodeChildren))
//				$nodeHasChildren = true;
//			else
//				$nodeHasChildren = false;
//
//			// The display level needs to be updated to stop infinate looop.
//			// $this->displayLevel = $node->$level;
//			['items'][0]['label']='root';
//			['items'][0]['items'][0]['label'] = 'yesy';
//			['items'][0]['items'][0]['items'][0]['label'] = 'test';
//
//			$test = array(
//			// If the node has children then calls itself again
//			// if ($nodeHasChildren){
//				'items'=>
//					$this->generateLiTree($item)
//				);
//			//}
//
//			// If the bottom node then adds the node information to the output array
//			if ($node->$level == $this->displayLevel)
//				$this->addDisplayItem($item);
//		}
//	}


	public function hasChildren(){
		$this->getProperties($left, $right);
		$node = $this->getOwner();
		return ($node->$right > ($node->$left + 1)) ? true : false;
	}


	public $menu;


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
			$myArr = array('id'=>$rootNode->id, 'name'=>$rootNode->name, 'label'=>$rootNode->name,'url'=>array($webAddress,$idVar=>$rootNode->id));
		else{
			$myArr = array('id'=>$rootNode->id, 'name'=>$rootNode->name, 'label'=>$rootNode->name);
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