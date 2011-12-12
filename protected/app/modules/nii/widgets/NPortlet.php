<?php

Yii::import('zii.widgets.CPortlet');

class NPortlet extends CPortlet {
	/**
	 * @var string the footer of the portlet. Defaults to null.
	 * When this is not set, the footer will not be displayed.
	 * Note that the footer will not be HTML-encoded when rendering.
	 */
	public $footer;
	/**
	 * @var string the CSS class for the portlet title tag. Defaults to 'portlet-header'.
	 */
	public $titleCssClass='portlet-header';
	/**
	 * @var string the CSS class for the content container tag. Defaults to 'portlet-body.
	 */
	public $contentCssClass='portlet-body';
	/**
	 * @var string the CSS class for the portlet footer tag. Defaults to 'portlet-footer'.
	 */
	public $footerCssClass='portlet-footer';

	/**
	 * Renders the decoration for the portlet.
	 * The default implementation will render the title if it is set.
	 */
	protected function renderDecoration() {
		if ($this->title !== null) {
			echo "<div class=\"{$this->titleCssClass}\">{$this->title}</div>\n";
		}
	}
	
	/**
	 * Renders the footer for the portlet.
	 * The default implementation will render the footer if it is set.
	 */
	protected function renderFooter() {
		if ($this->footer !== null) {
			echo "<div class=\"{$this->footerCssClass}\">{$this->footer}</div>\n";
		}
	}

}