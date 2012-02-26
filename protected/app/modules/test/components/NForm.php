<?php

class NForm extends CForm {
	
	public $activeForm=array('class'=>'nii.widgets.NActiveForm');
	public $active = false;
	
	public $inputElementClass='NFormInputElement';
	
	/**
	 * Renders the body content of this form.
	 * This method mainly renders {@link elements} and {@link buttons}.
	 * If {@link title} or {@link description} is specified, they will be rendered as well.
	 * And if the associated model contains error, the error summary may also be displayed.
	 * The form tag will not be rendered. Please call {@link renderBegin} and {@link renderEnd}
	 * to render the open and close tags of the form.
	 * You may override this method to customize the rendering of the form.
	 * @return string the rendering result
	 */
	public function renderBody()
	{
		$output='';
		
		if(!$this->getParent() instanceof self)
		{
			$output.="<div class=\"tabbable tabs-left\">\n<ul class=\"nav nav-tabs\">\n";
			foreach($this->getElements() as $element){
				if($element instanceof self){
					$output.="<li".($element->active?' class="active"':'')."><a href=\"#".$element->name."\" data-toggle=\"tab\">".$element->title."</a></li>";
				}
			}
			$output.="</ul>\n<div class=\"tab-content\">\n";
		}
		
		if($this->title!==null)
		{
			if($this->getParent() instanceof self)
			{
				$attributes=$this->attributes;
				unset($attributes['name'],$attributes['type']);
				$output.="<div class=\"tab-pane".($this->active?' active':'')."\" id=\"".$this->name."\">\n".CHtml::openTag('fieldset', $attributes)."<legend>".$this->title."</legend>\n";
			}
			else
				$output.="<fieldset>\n<legend>".$this->title."</legend>\n";
		}

		if($this->description!==null)
			$output.="<div class=\"description\">\n".$this->description."</div>\n";

		if($this->showErrorSummary && ($model=$this->getModel(false))!==null)
			$output.=$this->getActiveFormWidget()->errorSummary($model)."\n";

		$output.=$this->renderElements()."\n";

		if($this->title!==null)
			$output.="</fieldset>\n</div>\n";

		if(!$this->getParent() instanceof self)
			$output.="</div>\n</div>\n";
		
		$output.=$this->renderButtons()."\n";
		
		return $output;
	}
	
	/**
	 * Renders the {@link buttons} in this form.
	 * @return string the rendering result
	 */
	public function renderButtons()
	{
		$output='';
		foreach($this->getButtons() as $button)
			$output.=$this->renderElement($button);
		return $output!=='' ? "<div class=\"form-actions\">".$output."</div>\n" : '';
	}
	
	/**
	 * Renders a single element which could be an input element, a sub-form, a string, or a button.
	 * @param mixed $element the form element to be rendered. This can be either a {@link CFormElement} instance
	 * or a string representing the name of the form element.
	 * @return string the rendering result
	 */
	public function renderElement($element)
	{
		if(is_string($element))
		{
			if(($e=$this[$element])===null && ($e=$this->getButtons()->itemAt($element))===null)
				return $element;
			else
				$element=$e;
		}
		if($element->getVisible())
		{
			if($element instanceof CFormInputElement)
			{
				if($element->type==='hidden')
					return "<div style=\"visibility:hidden\">\n".$element->render()."</div>\n";
				else
					return "<div class=\"control-group\">\n".$element->render()."</div>\n";
//					return "<div class=\"field_{$element->name}\">\n".$element->render()."</div>\n";
			}
			else if($element instanceof CFormButtonElement)
				return $element->render()."\n";
			else
				return $element->render();
		}
		return '';
	}
}