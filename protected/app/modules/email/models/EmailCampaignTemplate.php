<?php

/**
 * This is the model class for table "email_campaign_template".
 *
*/
class EmailCampaignTemplate extends NActiveRecord {

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
		return '{{email_campaign_template}}';
	}

	public function getModule() {
		return Yii::app()->getModule('email');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name', 'required'),
			array('content, subject, default_group_id, design_template_id', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'design' => array(self::BELONGS_TO, 'EmailTemplate', 'design_template_id'),
			'group' => array(self::BELONGS_TO, 'ContactGroup', 'default_group_id'),
		);

//		foreach ($this->relations as $name => $relation) {
//			if (isset($relation['relation']))
//				$relations[$name] = $relation['relation']; 
//		}
		return $relations;
	}	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'subject' => 'Email Subject',
			'content' => 'Email Content',
			'default_group_id' => 'Default Group',
			'design_template_id' => 'Design Template',
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
		$criteria->compare('subject', $this->subject, true);

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
				'type'=>'raw',
				'value'=>'$data->viewLink',
				'exportValue'=>'$data->name',
			),
			array(
				'name'=>'description',
			),
			array(
				'name'=>'subject',
			),
			array(
				'name'=>'default_group_id',
				'type'=>'raw',
				'value'=>'$data->defaultGroupLink',
				'exportValue'=>'$data->defaultGroupName',
			),
			array(
				'name'=>'design_template_id',
				'type'=>'raw',
				'value'=>'$data->designTemplateLink',
				'exportValue'=>'$data->designTemplateName',
			),
		);
	}


	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'name' => "varchar(255)",
				'description' => "text",
				'subject' => "text",
				'content' => "text",
				'design_template_id' => "int(11)",
				'default_group_id' => "int(11)",
			),
			'keys' => array());
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public static function getTemplatesArray() {
		$templates = self::model()->findAll();
		$t = array();
		$t[0] = '--> Create New';
		foreach ($templates as $template)
			$t[$template->id] = $template->name;
		return $t;
	}
	
	public function getViewLink() {
		return NHtml::link($this->name, array('/email/manage/viewSavedCampaign', 'id'=>$this->id));
	}
	
	public function getDesignTemplateName() {
		if ($this->design)
			return $this->design->name;
	}
	
	public function getDesignTemplateLink() {
		if ($this->design)
			return NHtml::link($this->designTemplateName, array('/email/template/view', 'id'=>$this->design->id));
		else
			return '<span class="noData">No template assigned</span>';
	}
	
	public function getDefaultGroupName() {
		if ($this->group)
			return $this->group->name;
	}
	
	public function getDefaultGroupLink() {
		if ($this->group)
			return NHtml::link($this->defaultGroupName, array('/email/group/view', 'id'=>$this->group->id));
		else
			return '<span class="noData">No group assigned</span>';
	}
	
}