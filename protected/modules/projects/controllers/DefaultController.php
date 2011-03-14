<?php

class DefaultController extends NAController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}