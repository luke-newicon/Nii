<?php

class NFormInputElement extends CFormInputElement
{

	public $layout="{label}\n<div class=\"controls\">\n{input}\n{hint}\n{error}</div>";
	
	/**
	 * Renders the label for this input.
	 * The default implementation returns the result of {@link CHtml activeLabelEx}.
	 * @return string the rendering result
	 */
	public function renderLabel()
	{
		$options = array(
			'label'=>$this->getLabel(),
			'required'=>$this->getRequired(),
			'class'=>'control-label',
		);

		if(!empty($this->attributes['id']))
        {
            $options['for'] = $this->attributes['id'];
        }

		return CHtml::activeLabel($this->getParent()->getModel(), $this->name, $options);
	}

	/**
	 * Renders the hint text for this input.
	 * The default implementation returns the {@link hint} property enclosed in a paragraph HTML tag.
	 * @return string the rendering result.
	 */
	public function renderHint()
	{
		return $this->hint===null ? '' : '<div class="hint help-block">'.$this->hint.'</div>';
	}
}
