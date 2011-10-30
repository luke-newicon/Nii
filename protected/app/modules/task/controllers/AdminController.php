<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Class AdminController extends AController
{
	public function actionIndex(){
		$this->render('index');
	}
	
	public function actionActions(){
		$this->render('actions');
	}
}
