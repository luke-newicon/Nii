<?php

class NForm extends CForm {
	
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
					return "<div class=\"field_{$element->name}\">\n".$element->render()."</div>\n";
			}
			else if($element instanceof CFormButtonElement)
				return $element->render()."\n";
			else
				return $element->render();
		}
		return '';
	}
}