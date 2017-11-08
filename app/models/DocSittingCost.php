<?php

namespace app\models;

use system\models\Model;


/**
* 
*/
class DoctorSittingCost extends Model
{
	protected $guarded = [
		'id'
	];

	public function doctor()
	{
		return $this->belongsTo('app\models\Doctor');
	}

	public function docsitting()
	{
		return $this->belongsTo('app\models\DocSitting');
	}
}