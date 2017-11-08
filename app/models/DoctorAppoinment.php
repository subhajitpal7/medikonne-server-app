<?php

namespace app\models;

use system\models\Model;


/**
* 
*/
class DoctorAppointment extends Model
{
	protected $guarded = [
		'id'
	];

	public function doctor()
	{
		return $this->belongsTo('app\models\Doctor');
	}

	public function user()
	{
		return $this->belongsTo('app\models\User');
	}
}