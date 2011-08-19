<?php

/**
 * NAttributeWidget class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * The NAttributeWidget is a special widget that communicates with a coupled database table
 * The widget must be used within the context of the Nii module, as it is loosely coupled to the nii installation function, 
 * in that the NiiModule installation will be responsible for installing the database.  (This could be updated into the 
 * future and the wigets could be given their own install function and the widgets used could be managed through a 
 * generic config.  But this sounds like a pain to configure. Generally nii assumes you want all these widgets cause 
 * they are awesome, worst case scenario you end up with a few empty tables in your database).
 * 
 * Use:
 * ----
 * The NAttribute widget is used as a base class for a widget that manages a set of specific attributes attached to any model.
 * Good example: A notes widget. The widget enables notes to be Created, Read, Updated and Deleted a self contained CRUD system.
 * All this from one line that adds the widet and passes in the model related.
 * 
 * Principles of use:
 * ------------------
 * The related database table will contain the following columns that this widget understands
 * model     : the associated yii model class name, this class must implement the CActiveRecord::model($className) function
 * model_id  : the id of the associated model 
 * type : a category that can further specify the data, this allows multiple widgets per model, 
 *             for example: a product model may require:
 *             - PDF attahments for Certificates of compliance 
 *             - PDF attachments for installation instructions, 
 *             - additional image attachments.
 *             to achieve this you add three of the same attachments widget and pass in the related category 
 *             i.e 'certificates' | 'installation', | 'images'
 * 
 * Typical useage:
 * ---------------
 * 
 * <h2>Installation Documents</h2>
 * $this->widget('nii.widgets.attributes.NAttachements', array('model'=>$product, 'type'=>'installation', 'fileTypes'=>array('pdf')))
 * 
 * <h2>Certificates of Compliance</h2>
 * $this->widget('nii.widgets.attributes.NAttachements', array('model'=>$product, 'type'=>'certificates', 'canEdit'=>false, 'fileTypes'=>array('pdf')))
 * 
 * <h2>Additional Images</h2>
 * $this->widget('nii.widgets.attributes.NAttachements', array('model'=>$product, 'type'=>'images', 'fileTypes'=>array('png', 'jpg')))
 *
 * The main consistent properties managed, understood amd required by this class are "model" and "model_cat"
 * 
 * 
 * Gotchas & TODOs:
 * ----------------
 * The principles these widgets are based upon assume the model data is linked 
 * to is an CActiveRecord model that has ONE column as the primary key.
 * 
 * In other words it is not yet possible to use these widgets on tables with 
 * joint primary keys. If there is an efficient way to store a joint primary key
 * in one column (the model_id) then i would like to know. Ideally it would 
 * still be easy to write SQL queries to link the data. PHP solution that would 
 * work would be to store a unique indexed string with the column and index of all joint keys. e.g:
 * model_id = 'some_id:13,some_other_id:23' the model_id could then be split and placed into a customer query related to 
 * a joint primary key, the disadvantage is that this would make it difficult to write custom SQL but it would work for 90% of 
 * the functionality of the widget.
 * 
 * 
 * @author steve
 */
class NAttributeWidget extends CWidget 
{
	
	/**
	 * The CActiveRecord to join the attributes to.
	 * @var CActiveRecord 
	 */
	public $model;
	
	/**
	 * tghe type used to categorise the attribute widget, useful when using multiple on a page etc
	 * @var string 
	 */
	public $type = '';
	
	/**
	 * get the model class name for the passed in $this->model
	 * 
	 * @return type 
	 */
	public function getModelClass(){
		return get_class($this->model);
	}
	
	/**
	 * will return a id for widget based on the type text and model associated 
	 * with it.
	 * To apply multiple widgets to the same model the "type" property allows
	 */
	public function getId(){
		$id = $this->model->getPrimaryKey();
		$widget = get_class($this);
		return "$widget-$id-{$this->type}";
	}
	
}