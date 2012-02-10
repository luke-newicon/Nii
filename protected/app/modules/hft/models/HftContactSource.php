<?php

/**
 * Description of HftContactSources
 *
 * @author robinwilliams
 */
class HftContactSource extends NActiveRecord {
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contact_source';
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'name' => "varchar(255) NOT NULL",
			),
			'keys' => array(),
		);
	}
	
	public function rules() {
		return array(
			array('name', 'safe'),
			array('name, numberWithSource', 'safe','on'=>'search'),
		);
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
		$criteria->compare('numberWithSource', $this->numberWithSource);

		
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
				'value' => '$data->editLink',
			),
			array(
				'name' => 'numberWithSource',
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
	
	public function getNumberWithSource() {
		if ($this->id)
			return NActiveRecord::model('HftContact')->countByAttributes(array('source_id'=>$this->id));
	}
	
	public function setNumberWithSource($value) {
		if ($value)
			$this->numberWithSource = $value;
	}
	
	public function getEditLink() {
		return NHtml::link($this->name, '#', array('class'=>'edit-source', 'data-model-id'=>$this->id, 'data-name'=>$this->name));
	}
	
	public function getDeleteLink() {
		return NHtml::link('Delete', '#', array(
			'onclick' => "js:$(function(){ 
				var answer = confirm('Are you sure you wish to delete this source?');
				if (!answer) {
					return;
				} 
				$.ajax({
					url: '".NHtml::url(array('/hft/source/delete', 'id'=>$this->id))."',
					dataType: 'json',
					type: 'get',
					success: function(response){ 
						if (response.success) {
							$.fn.yiiGridView.update('SourceAllGrid');
							nii.showMessage(response.success);
							return false;
						}
					}
				}); 
			});"
		));
	}
	
	public static function getSourcesArray() {
		$model = new HftContactSource;
		$source = $model->findAll(array('order'=>'name'));
		$sources = array();
		
		foreach ($source as $s) {
			$sources[$s->id] = $s->name;
		}
		
		return $sources;
	}
	
}