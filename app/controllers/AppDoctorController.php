<?php

namespace app\controllers;

use system\controllers\Controller;
use app\models\DocSittingCost;
use app\models\DocSitting;
use app\models\Doctor;
use app\models\DoctorAppointment;
use \Firebase\JWT\JWT;
use app\libs\Auth;


/**
* AppLabController
*/
class AppDoctorController extends Controller
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

	public function docsittingApi()
	{
		echo json_encode(['success'=>true, 'data'=>DocSitting::all()]);
	}

	public function doctorApi()
	{
		echo json_encode(['success'=>true, 'data'=>Doctor::where('docsitting_id', $this->get('docsitting_id'))]);
	}

	public function docSittingCostApi()
	{
		echo json_encode(['success'=>true, 'data'=>DocSittingCost::where('docsitting_id', $this->get('docsitting_id'))->first()->with('doctor')->get()]);
	}

	public function registerDoctorAppointmentApi()
	{
		$data = [
			'doctor_id' => $this->post('doctor_id'),
			'user_id' => $this->post('user_id'),
		];

		if($doctorAppointment = DoctorAppointment::create($data)) {
			$json = [
				'success' => true,
				'message' => 'Appointment fixed',
				'data' => $doctorAppointment
			];
		} else {
			$json = [
				'success' => false,
				'message' => 'Error while storing in database'
			];
		}
		echo json_encode($json);
	}

	public function doctorAppointmentsApi()
	{
		echo json_encode(['success'=>true, 'data'=>DoctorAppointment::where('user_id', $this->get('user_id'))->first()->with(['user', 'doctor'])->get()]);
	}
}