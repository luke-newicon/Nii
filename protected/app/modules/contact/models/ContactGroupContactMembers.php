<?php

class ContactGroupContactMembers extends ContactGroupContact 
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}		
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'contact_id' => 'Contact',
			'group_id' => 'Group',
			'contact_name' => 'Contact Name',
			'delete' => 'Delete',
		);
	}
	
	public $delete;
	
	public function columns() {
		return array(
			array(
				'name'=>'name',
				'type' => 'raw',
				'value' => '$data->contactLink',
				'exportValue' => '$data->contactName',
			),
			array(
				'name'=>'email',
				'type' => 'raw',
				'value' => '$data->emailLink',
				'exportValue' => '$data->contactEmail',
			),
			array(
				'name'=>'delete',
				'type' => 'raw',
				'value' => '$this->grid->filter->deleteContactLink($data->id)',
				'export' => false,
				'filter' => false,
				'htmlOptions' => array('width' => '40px'),
			),
		);
	}
	
	public $groupId;
	
	public function deleteContactLink($id) {
		$cgc = NActiveRecord::model('ContactGroupContact')->findByAttributes(array('group_id'=>$this->groupId, 'contact_id'=>$id));
		
		$url = NHtml::url(array('/contact/group/deleteMember', 'id'=>$cgc->id));

		if (isset($cgc))
			return NHtml::btnLink('Delete','#', null,
				array(
					'onclick'=> '
						var answer = confirm("Are you sure you wish to delete this member from the group?");
						if(!answer) { return; }
						$.ajax({
							url: "'.$url.'",
							dataType: "json",
							type: "get",
							success: function(response){ 
								if (response.success) {
									$.fn.yiiGridView.update("ContactGroupContactsGrid");
									$(".members_count").html(response.count);
									$("#totalMembersCount").html(response.countTotal);
									if (response.count > 0) {
										$(".members_count").addClass("notice");
									} else {
										$(".members_count").removeClass("notice");
									}
								}
								return false;
							},
							error: function(response) {
								alert ("JSON failed to return a valid response...");
							}
						}); 
					',
//					'class'=>'trash-link btn danger'
				)
			);
	}
	
}