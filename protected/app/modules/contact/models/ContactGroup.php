<?php

class ContactGroup extends NActiveRecord 
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{contact_group}}';
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'filterScopes' => 'Rules',
			'editLink' => 'Edit',
		);
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('description, rules', 'safe'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('filterScopes', $this->filterScopes, true);

		$sort = new CSort;
		$sort->defaultOrder = 'id DESC';

		return new NActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => $sort,
			'pagination' => array(
				'pageSize' => 20,
			),
		));
	}
	
	public function columns() {
		return array(
			array(
				'name'=>'name',
				'type' => 'raw',
				'value' => '$data->viewLink',
				'exportValue' => '$data->name',
			),
			array(
				'name'=>'description',
				'type' => 'html',
			),
			array(
				'name'=>'filterScopes',
				'type'=>'raw',
				'value'=>'$data->ruleDescriptions'
			),
//			array(
//				'name' => 'editLink',
//				'type' => 'raw',
//				'value' => '$data->editLink',
//				'filter' => false,
//				'sortable' => false,
//				'htmlOptions'=>array('width'=>'30px'),
//				'export'=>false,
//			),
		);
	}


	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'name' => "varchar(255)",
				'description' => "text",
				'filterScopes' => "text",
			),
			'keys' => array());
	}
	
	/**
	 *	Get groups as array to use in drop down lists
	 * @return array - [id]=>name 
	 */
	public static function getGroups() {
		$g=array();
		$groups = self::model()->findAll();
		foreach ($groups as $group) {
			$g[$group->id] = $group->name;
		}
		return $g;
	}
	
	/**
	 *	Search groups based on a term and return a ContactGroup model, if there are results
	 * @param string $term
	 * @return model ContactGroup 
	 */
	public static function searchGroups($term) {
		return ContactGroup::model()->findAll(
			array(
				'condition'=>"name LIKE '%".$term."%'",
				'limit'=>30,
			)
		);
	}
	
	public static function getGroup($id) {
		$group = self::model()->findByPk($id);
		if ($group) {
			return array(
				'id'=>'g_'.$id,
				'name'=>$group->name,
			);
		}
	}
	
	/**
	 *	Get contacts for a specific group. Returns contact IDs
	 * @return array - contact IDs 
	 */
	public function getGroupContacts($type=null) {
		// @todo: Finish getGroupContacts function
		
		$contacts = array();
		$contactModel  = Yii::app()->getModule('contact')->contactModel;
		
		if ($type=='user_defined' || $type==null) {
			// First: get contacts from ContactGroupContact
			$cgcs = NActiveRecord::model('ContactGroupContact')->findAllByAttributes(array('group_id'=>$this->id));
			foreach ($cgcs as $cgc)
				$contacts[$cgc->contact_id] = $cgc->contact->name;
		}
		
		if ($type=='rule_based' || $type==null) {

			// Next: get contacts from dynamic scopes on the model - trickier...
			if ($this->filterScopes) {
				$fs = CJSON::decode($this->filterScopes);
				if (isset($fs)){
					$criteria = NActiveRecord::model('ContactGroupContact')->groupRulesCriteria($fs);
				} else {
					$criteria = NActiveRecord::model($contactModel)->{$this->filterScopes}();
				}
				
				$criteria->addCondition("email <> '' AND email IS NOT NULL");
				$criteria->select = 'id';
				
				$c = Yii::app()->db->commandBuilder->createFindCommand($contact->tableName(),$criteria)->queryAll();
				
				foreach ($c as $value)
					$contacts[$value['id']] = $value['id'];
			}
			
		}
		// Last: return contacts
		return $contacts;
	}
	
	/**
	 *	Gets contacts for the group and returns them as a comma-separated list
	 * @return string
	 */
	public function getGroupContactsList() {
		$contacts = $this->groupContacts;
		if ($contacts)
			return implode(',',$contacts);
	}
	
	/**
	 *	Gets contacts, makes them into links and returns them as a list
	 * @return string 
	 */
	
	public function getGroupContactsLinks() {
		$contacts = $this->groupContacts;
		if ($contacts) {
			foreach ($contacts as $k =>$contact)
				$c[] = NHtml::link($contact, array('/contact/admin/view', 'id'=>$k));
			return implode('; ',$c);
		}
	}
	
	/**
	 *	Return a count of the contacts in a group
	 * @return int 
	 */
	public function countGroupContacts($type=null) {
		
		$count=0;
		$contactModel  = Yii::app()->getModule('contact')->contactModel;
		
		if ($type=='user_defined' || $type==null) {
			// First: get contacts from ContactGroupContact
			$count += NActiveRecord::model('ContactGroupContact')->countByAttributes(array('group_id'=>$this->id));
		}
		
		if ($type=='rule_based' || $type==null) {

			// Next: get contacts from dynamic scopes on the model - trickier...
			if ($this->filterScopes) {
				$fs = CJSON::decode($this->filterScopes);
				if ($this->filterScopes) {
					$fs = CJSON::decode($this->filterScopes);
					if (isset($fs)){
						$criteria = NActiveRecord::model('ContactGroupContact')->groupRulesCriteria($fs);
					} else {
						$criteria = NActiveRecord::model($contactModel)->{$this->filterScopes}();
					}

					$criteria->addCondition("email <> '' AND email IS NOT NULL");
					$count += NActiveRecord::model($contactModel)->count($criteria);
				}
			}
		}
		// Last: return contacts
		return $count;
	}
	
	/**
	 *	Return the edit link for a group
	 * @return string 
	 */
	public function getEditLink() {
		if ($this->id)
			return NHtml::link('Edit', array('edit', 'id'=>$this->id));
	}
	
	/**
	 *	Return the edit link for a group
	 * @return string 
	 */
	public function getViewLink() {
		if ($this->id)
			return NHtml::link($this->name, array('view', 'id'=>$this->id));
	}
	
	public function getRuleDescriptions() {
		$fields = CJSON::decode($this->filterScopes);
		if (isset($fields)) {
			$cgr = new ContactGroupRule;
			foreach ($fields['rule'] as $rule) {
				$method = '';
				foreach ($cgr->searchMethods as $sm) {
					if ($sm['value'] == $rule['searchMethod'])
						$method = $sm['label'];
				}
				$rules[] = "'".$this->getAttributeLabel($rule['field'])."'" . " " . $method . " '" . $rule['value']."'";
				
				return implode(' <small>AND</small> ', $rules);
			}
		} else {
			return $this->filterScopes;
		}
	}
	
	public function getTabs() {
		/* Default tabs */
		$tabs['Members'] = array('ajax' => array('viewContacts', 'id' => $this->id), 'id' => 'members', 'count' => $this->countGroupContacts('user_defined'));
		$tabs['Rules'] = array('ajax' => array('viewRules', 'id' => $this->id()), 'id' => 'rules', 'count' => $this->countGroupContacts('rule_based'));

		return $tabs;
	}
	
	/**
	 *	Array of rule fields, to be used in contact group rules
	 * @return array - assoc. array of grouped fields. See Contacts group below as an example
	 */
	public static function groupRuleFields() {
		return array(
			'Contacts' => array(
				'model' => Yii::app()->getModule('contact')->contactModel,
				'fields' => array(
					'newsletter' => array(
						'label' => 'Receives Newsletter',
						'type' => 'bool',
					),
					'country' => array(
						'label' => 'Country',
						'type' => 'select',
						'filter' => NData::countries(),
					),
				),
			)
		);
	}
	
}