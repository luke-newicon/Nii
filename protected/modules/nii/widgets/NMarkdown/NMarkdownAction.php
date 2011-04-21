<?php

/**
 * Returns the preview window for the NtextareaMarkdown widget
 * @author Matt Turner
 * @version 0.1
 */
class NMarkdownAction extends CAction {

	public function run() {
		$text = null;
		if (isset($_REQUEST['text']))
			$text = $_REQUEST['text'];

		$markdown = new NMarkdown();
		echo $markdown->transform($text);
	}
}