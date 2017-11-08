<?php

namespace app\controllers;

use system\controllers\Controller;
use app\models\TestCost;
use app\models\Test;
use app\models\Lab;
use app\models\LabAppointment;
use \Firebase\JWT\JWT;
use app\libs\Auth;


/**
* AppLabController
*/
class AppLabController extends Controller
{
	public function __construct() {
		if(!Auth::isTokenCorrect($this->get('token'))) {
			echo json_encode(['success' => false, 'data' => 'Auth token incorrect']);
			exit;
			return 0;
		} else {
			//Auth token correct!
		}
	}

	public function testApi()
	{
		echo json_encode(['success'=>true, 'data'=>Test::all()]);
	}

	public function labApi()
	{
		echo json_encode(['success'=>true, 'data'=>Lab::where('test_id', $this->get('test_id'))]);
	}

	public function testCostApi()
	{
		echo json_encode(['success'=>true, 'data'=>TestCost::where('test_id', $this->get('test_id'))->first()->with('lab')->get()]);
	}

	public function registerLabAppointmentApi()
	{
		$data = [
			'lab_id' => $this->post('lab_id'),
			'user_id' => $this->post('user_id'),
		];

		if($labAppointment = LabAppointment::create($data)) {
			$json = [
				'success' => true,
				'message' => 'Appointment fixed',
				'data' => $labAppointment
			];
		} else {
			$json = [
				'success' => false,
				'message' => 'Error while storing in database'
			];
		}
		echo json_encode($json);
	}

	public function labAppointmentsApi()
	{
		echo json_encode(['success'=>true, 'data'=>LabAppointment::where('user_id', $this->get('user_id'))->first()->with(['user', 'lab'])->get()]);
	}
}