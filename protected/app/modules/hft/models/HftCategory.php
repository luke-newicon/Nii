<?php

/**
 * Description of HftContact
 *
 * @author robinwilliams
 */
//Yii::import('nii.models.NTag.php');
class HftCategory extends NTag
{
	
	public $_numberInCategory;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'numberInCategory' => '# in Category',
		);
	}
	
	
	public function rules() {
		$rules = Contact::model()->rules();
		return array_merge($rules, array(
			array('name', 'safe'),
			array('name, numberInCategory', 'safe','on'=>'search'),
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->getDbCriteria();
		
		$criteria->compare('name', $this->name, true);
		$criteria->compare('numberInCategory', $this->numberInCategory);

		
		$sort = new CSort;
		$sort->defaultOrder = 't.name ASC';		
		
		return new NActiveDataProvider($this, array(
			'criteria'=>$criteria,	
			'sort' => $sort,
			'pagination'=>array(
				'pageSize'=>20,
            ),
		));
	}
	
	public function columns() {
		
		return array(
			array(
				'name' => 'id',
				'htmlOptions'=>array('width'=>'50px'),
			),
			array(
				'name' => 'name',
				'type' => 'raw',
				'value' => '$data->nameLink',
			),
			array(
				'name' => 'numberInCategory',
				'htmlOptions'=>array('width'=>'100px'),
			),
			array(
				'name' => 'deleteLink',
				'header' => 'Delete',
				'type' => 'raw',
				'value' => '$data->deleteLink',
				'filter' => false,
				'sortable' => false,
				'htmlOptions'=>array('width'=>'30px'),
				'export'=>false,
			),
		);
	}
	
	public function getNumberInCategory() {
		if ($this->id)
			return NActiveRecord::model('NTagLink')->countByAttributes(array('tag_id'=>$this->id));
	}
	
	public function setNumberInCategory($value) {
		if ($value)
			$this->numberInCategory = $value;
	}
	
	public function getNameLink() {
		return NHtml::link($this->name, array('/hft/category/edit', 'id'=>$this->id));
	}

	public function getDeleteLink() {
		return NHtml::link('Delete', '#', array(
			'onclick' => "js:$(function(){ 
				var answer = confirm('Are you sure you wish to delete this category?');
				if (!answer) {
					return;
				} 
				$.ajax({
					url: '".NHtml::url(array('/hft/category/delete', 'id'=>$this->id))."',
					dataType: 'json',
					type: 'get',
					success: function(response){ 
						if (response.success) {
							$.fn.yiiGridView.update('CategoryAllGrid');
							nii.showMessage(response.success);
							return false;
						}
					}
				}); 
			});"
		));
	}
	
	public static function getCategoryIds($searchValue) {
		$criteria = new CDbCriteria;
		$criteria->addCondition("name LIKE '".$searchValue."%'");
		$criteria->select = 'id';
		
		$tag = new NTag;

		$c = Yii::app()->db->commandBuilder->createFindCommand($tag->tableName(),$criteria)->queryAll();
		$ids=array();
		foreach ($c as $v)
			$ids[] = $v['id'];
		return $ids;
	}
	
	public static function getCategoriesArray() {
		$category = NActiveRecord::model('NTag')->findAll(array('order'=>'name ASC'));
		$categories=array();
		foreach ($category as $c)
			$categories[$c->id] = $c->name;
		return $categories;
	}
	
}