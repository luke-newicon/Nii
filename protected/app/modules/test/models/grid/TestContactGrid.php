<?php

class TestContactGrid extends TestContact {

	public function relations() {
		return array(
			'extra' => array(self::BELONGS_TO, 'TestExtra', 'id'),
		);
	}

	public function columns() {
		return array(
			'name',
			'extra.comments',
			'extra.number',
		);
	}
}