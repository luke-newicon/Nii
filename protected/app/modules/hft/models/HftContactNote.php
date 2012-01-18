<?php

/**
 * This is the model class for table "note".
 *
 * The followings are the available columns in table 'note':
 * @property string $id
 * @property string $user_id
 * @property string $added
 * @property string $area
 * @property integer $item_id
 * @property string $note
 */
class HftContactNote extends NNote
{
	
    /**
     * Returns the static model of the specified AR class.
     * @return Note the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = NNote::model()->relations();
		return array_merge($relations, array(
			'contact'=>array(self::BELONGS_TO, 'HftContact', 'model_id'),
			'donation'=>array(self::BELONGS_TO, 'HftDonation', 'model_id'),
			'event'=>array(self::BELONGS_TO, 'HftEvent', 'model_id'),
		));
	}

}