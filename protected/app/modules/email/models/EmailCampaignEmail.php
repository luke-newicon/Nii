<?php

/**
 * This is the model class for table "email_campaign_email".
 *
*/
class EmailCampaignEmail extends NActiveRecord {

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
		return '{{email_campaign_email}}';
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
			array('campaign_id', 'required'),
			array('contact_id, email_address, sent_date, opened_date', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
		);

		return $relations;
	}	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'template_id' => 'Select a Campaign',
			'recipients' => 'Recipients',
			'content' => 'Email Content',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('template.name', $this->template_id, true);

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
			'id',
			'template_id',
		);
	}


	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'template_id' => "int(11)",
				'recipients' => "text",
				'subject' => "text",
				'content' => "text",
			),
			'keys' => array());
	}
	
//	function behaviors() {
//		return array(
//			'trash'=>array(
//				'class'=>'nii.components.behaviors.ETrashBinBehavior',
//				'trashFlagField'=>$this->getTableAlias(false, false).'.trashed',
//			),
//			'tag'=>array(
//               'class'=>'nii.components.behaviors.NTaggable'
//           )
//		);
//	}
	
	public function selectTemplateFromDropdown() {
		return 'jQuery(function($){
			var template_id = $("#EmailCampaign_template_id").val();
			if (template_id>0 && template_id !="") {
				var contentUrl = "' . Yii::app()->baseUrl . '/email/template/getContents/id/"+template_id;
				$.ajax({
					url: contentUrl,
					type: "get",
					dataType: "json",
					success: function(response){ 
						$(".email-campaign-details").show();
						CKEDITOR.instances.content.setData(response.content);
						$("#EmailCampaign_subject").val(response.subject);
						if (response.recipients) {
							jQuery("#EmailCampaign_recipients").tokenInput("clear");
							jQuery("#EmailCampaign_recipients").tokenInput("add",response.recipients);
						}
					},
					error: function() {
						alert ("JSON failed to return a valid response");
					}
				}); 
			} else {
				if (template_id=="0") {
					$(".email-campaign-details").show();
				} else {
					$(".email-campaign-details").hide();
				}
				CKEDITOR.instances.content.setData("");
				$("#EmailCampaign_subject").val("");
				jQuery("#EmailCampaign_recipients").tokenInput("clear");
			}
			return false;
		})';
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
}