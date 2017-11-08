<?php

namespace app\models;

use system\models\Model;


/**
* 
*/
class LabAppointment extends Model
{
	protected $guarded = [
		'id'
	];

	public function lab()
	{
		return $this->belongsTo('app\models\Lab');
	}

	public function user()
	{
		return $this->belongsTo('app\models\User');
	}
}