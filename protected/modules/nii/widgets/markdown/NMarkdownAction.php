<?php

/**
 * Returns the preview window for the markdown widget
 * @author Matt Turner
 * @version 0.2
 */
class NMarkdownAction extends CAction {

	public function run() {
		$text = null;

		// Only runs transform if text is supplied.
		if (isset($_REQUEST['text'])){
			$text = $_REQUEST['text'];
			$markdown = new NMarkdown();
			echo $markdown->transform($text);
		}
	}
}