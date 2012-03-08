<?php

class LFormInputElement extends CFormInputElement
{
	
	public $type='text';
	
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
	
	/**
	 * Renders the input field.
	 * The default implementation returns the result of the appropriate CHtml method or the widget.
	 * @return string the rendering result
	 */
	public function renderInput()
	{
		if($this->type){
			if(isset(self::$coreTypes[$this->type]))
			{
				$method=self::$coreTypes[$this->type];
				if(strpos($method,'List')!==false)
					return CHtml::$method($this->getParent()->getModel(), $this->name, $this->items, $this->attributes);
				else
					return CHtml::$method($this->getParent()->getModel(), $this->name, $this->attributes);
			}
			else
			{
				$attributes=$this->attributes;
				$attributes['model']=$this->getParent()->getModel();
				$attributes['attribute']=$this->name;
				ob_start();
				$this->getParent()->getOwner()->widget($this->type, $attributes);
				return ob_get_clean();
			}
		} else {
			return LHtml::activeField($this->getParent()->getModel(), $this->name, $this->attributes);
		}
	}
}
