<?php

/**
 * Extends the base CActiveRecordBehavior to add additional events when used with an NActiveRecord class
 *
 * @author steve
 */
class NActiveRecordBehavior extends CActiveRecordBehavior
{
	/**
	 * Adds the additional afterInstal event that is raised after the table has been installed
	 * @return array events (array keys) and the corresponding event handler methods (array values).
	 * @see CActiveRecordBehavior::events
	 */
	public function events()
	{
		return array_merge(parent::events(), array(
			'onAfterInstall'=>'afterInstall',
		));
	}
	
	/**
	 * Responds to {@link NActiveRecord::onAfterInstall} event.
	 * Override this method if you want to handle the corresponding event of the {@link NActiveRecordBehavior::owner owner}.
	 * @param CEvent $event event parameter
	 */
	public function afterInstall($event)
	{
	}
}

