<?php

namespace app\models;

use system\models\Model;


/**
* 
*/
class TestCost extends Model
{
	protected $guarded = [
		'id'
	];

	public function lab()
	{
		return $this->belongsTo('app\models\Lab');
	}

	public function test()
	{
		return $this->belongsTo('app\models\Test');
	}
}