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
    //put your code here


	public function actions(){
		return array(
			'markdownPreview'=>'application.modules.nii.widgets.NMarkdown.NMarkdownAction'
		);
	}
	

}
?>
