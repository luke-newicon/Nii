<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author matthewturner
 */
class IndexController extends NController
{
	public function actions(){
		return array(
			'markdownPreview'=>'modules.nii.widgets.markdown.NMarkdownAction'
		);
	}
}
?>
