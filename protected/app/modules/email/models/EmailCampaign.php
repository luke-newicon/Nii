<?php

/**
 * This is the model class for table "email_template".
 *
*/
class EmailCampaign extends NActiveRecord {

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
		return '{{email_campaign}}';
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
			array('template_id, content, subject, recipients, status', 'safe'),
			array('template_id, content, subject, recipients, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'template' => array(self::BELONGS_TO, 'EmailCampaignTemplate', 'template_id'),
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
			'template_id' => 'Select a Campaign',
			'recipients' => 'Recipients',
			'content' => 'Email Content',
			'status' => 'Status',
			'numberRecipients' => '# Recipients',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('subject', $this->subject, true);
		$criteria->compare('status', $this->status);
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
			array(
				'name' => 'subject',
				'type' => 'raw',
				'value' => '$data->viewLink',
				'exportValue' => '$data->name',
			),
			array(
				'name' => 'template_id',
				'header' => 'Campaign Template',
				'type' => 'raw',
				'value' => '$data->viewTemplateLink',
				'exportValue' => '$data->viewTemplateName',
			),
			array(
				'name' => 'status',
				'filter' => NHtml::enumItem($this, 'status'),
			),
			array(
				'name' => 'numberRecipients',
				'type' => 'raw',
				'value' => '$data->countRecipients()',
				'filter' => false,
			),
			array(
				'name' => 'created_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->created_date, "d M Y, H:i")',
			),
			array(
				'name' => 'updated_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->updated_date, "d M Y, H:i")',
			),
			array(
				'name' => 'editLink',
				'type' => 'raw',
				'value' => '$data->editLink',
				'export' => false,
				'filter' => false,
			),
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
				'created_date' => "datetime",
				'updated_date' => "datetime",
				'status' => "ENUM('Created','Compiled','Sending','Sent') NOT NULL DEFAULT 'Created'",
			),
			'keys' => array());
	}
	
	public function getEditLink() {
		if ($this->status == 'Created')
			return NHtml::link('Edit', array('/email/index/create', 'id'=>$this->id));
	}
	
	public function getViewLink() {
		return NHtml::link($this->subject, array('/email/index/preview', 'id'=>$this->id));
	}
	
	public function getViewTemplateLink() {
		if ($this->template)
			return NHtml::link($this->template->name, array('/email/manage/view', 'id'=>$this->template->id));
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
						CKEDITOR.instances.EmailCampaign_content.setData(response.content);
						$("#EmailCampaign_subject").val(response.subject);
						if (response.recipients) {
							//jQuery("#EmailCampaign_recipients").tokenInput("clear");
							jQuery("#EmailCampaign_recipients").tokenInput("remove",response.recipients);
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
				CKEDITOR.instances.EmailCampaign_content.setData("");
				$("#EmailCampaign_subject").val("");
				//jQuery("#EmailCampaign_recipients").tokenInput("clear");
			}
			return false;
		})';
	}
	
	public function explodeRecipients() {
		if ($this->recipients) :
			$recipients = explode(',',$this->recipients);
			foreach($recipients as $r) :
				// Email addresses
				if (strstr($r,'@')) :
					$recipientArray[] = array('id'=>$r, 'name'=>$r);
				else :
					switch(substr($r,0,2)) :
						case "g_" :
							$g = ContactGroup::getGroup(substr($r,2));
							$recipientArray[] = $g;
							break;
						case "c_" :
							$c = Contact::model()->findByPk(substr($r,2));
							$recipientArray[] = array('id'=>'c_'.$c->id, 'name'=>$c->name);
							break;
					endswitch;
				endif;
			endforeach;
			return $recipientArray;				
		endif;
	}
	
	public function listRecipients() {
		if ($this->recipients) :
			$recipients = explode(',',$this->recipients);
			foreach($recipients as $r) :
				// Email addresses
				if (strstr($r,'@')) :
					$recipientArray[] = NHtml::link($r,'mailto:'.$r);
				else :
					switch(substr($r,0,2)) :
						case "g_" :
							$g = ContactGroup::model()->findByPk(substr($r,2));
							$recipientArray[] = NHtml::link($g->name,array('/email/group/view','id'=>$g->id));
							FB::log($g->groupContacts, 'Contacts');
							break;
						case "c_" :
							$c = Contact::model()->findByPk(substr($r,2));
							$recipientArray[] = NHtml::link($c->name, array('/contact/admin/view','id'=>$c->id));
							break;
					endswitch;
				endif;
			endforeach;
			return implode('; ',$recipientArray);				
		endif;
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function getTemplatedContent($contact=null) {
		if ($this->template)
			$template = EmailTemplate::model()->findByPk($this->template->design_template_id);
		if ($template)
			$content = str_replace('[content]',$this->content,$template->content);
		else
			$content = $this->content;
		if ($contact) {
			$tags = new StringTags;
			$content = $tags->replaceTags($content, $contact);
		}
		return $content;
	}
	
	public function countRecipients() {
		$count = 0;
		
		if ($this->recipients) :
			$recipients = explode(',',$this->recipients);
			foreach($recipients as $r) :
				if (strstr($r,'@')) :
					$count++;
				else :
					switch(substr($r,0,2)) :
						case "g_" :
							$g = NActiveRecord::model('ContactGroup')->findByPk(substr($r,2));
							$count = $count + $g->countGroupContacts();
							break;
						case "c_" :
							$count++;
							break;
					endswitch;
				endif;
			endforeach;		
		endif;
		
		return $count;		
	}
	
}