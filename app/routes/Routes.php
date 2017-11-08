<?php

namespace app\routes;


class Routes
{
	public function setRoutes()
	{
		$this->routes = [
			'/' => ['uses' => 'Welcome@welcomeToSurface'],

			'app.register' => ['uses' => 'AppAuthController@register'],
			'app.login' => ['uses' => 'AppAuthController@login'],

			'app.test.cost' => ['uses' => 'AppLabController@testCostApi'],
			'app.tests' => ['uses' => 'AppLabController@testApi'],
			'app.labs' => ['uses' => 'AppLabController@labApi'],
            'app.lab.appointments' => ['uses' => 'AppLabController@labAppointmentsApi'],
			'app.doctor.appointments' => ['uses' => 'AppDoctorController@doctorAppointmentsApi'],
            'app.docsitting.cost' => ['uses' => 'AppDoctorController@docSittingCostApi'],
			'app.docsittings' => ['uses' => 'AppDoctorController@docsittingApi'],
			'app.doctors' => ['uses' => 'AppDoctorController@doctorApi'],
		];

		return $this->routes;
	}

	public function getUriSegment($int=0)
	{
		if(isset(explode('/', trim($_SERVER['REQUEST_URI'], '/'))[$int]))
		{
			return explode('/', trim($_SERVER['REQUEST_URI'], '/'))[$int];
		}
		else return null;
	}


}