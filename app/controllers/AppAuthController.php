<?php

namespace app\controllers;


use \system\controllers\Controller;
use \app\models\User;
use \app\libs\Auth;
use \Firebase\JWT\JWT;


/**
* 
*/
class AppAuthController extends Controller
{
	public function __construct()
	{
		header('Content-Type: application/json');
	}
	/**
	* Request POST
	*/
	public function register() {
		if($this->isPost()) {
			return $this->registerUser();
		}
		echo json_encode(['success' => false, 'message' => 'Check method type!']);
	}

	/**
	* Request POST
	*/
	public function login() {
		
		if($this->isPost()) {
			return $this->loginUser();
		}
		echo json_encode(['success' => false, 'message' =>'Check method type!']);

	}

	/**
	* Request POST
	*/
	public function forgot() {
		if($this->isPost()) {
			return $this->forgotUser();
		}
		echo json_encode(['success' => false, 'message' =>'Check method type!']);

	}

	public function registerUser()
	{
		$this->startValidator();
		$validate = $this->validator;

		$name = $this->post('name');
		$mobile = $this->post('mobile');
		$password = $this->post('password');
		$confirm_password = $this->post('confirm_password');
		$captcha = $this->post('captcha');
		$match_captcha = isset($_SESSION['captcha']) ? $_SESSION['captcha'] : time();

		if(
			$validate->validate($name, 'required')
			&& $validate->validate($mobile, 'required|length=10')
			&& $validate->validate($password, 'required')
			&& $validate->validate($confirm_password, 'required|matches='.$password.'')
		) 
		// if($this->isPost())
		{
			//Register user now

			

			$userModel = new User;

			$data = [
				'name' => $name,
				'mobile' => $mobile,
				'password' => password_hash($password, PASSWORD_BCRYPT),
			];


			if(!$validate->validate($mobile, 'required|unique=mobile')) {
				echo json_encode(['success' => false, 'message' => 'Mobile number or already registered.', $data]);
				return false;
			}


			if($user = $userModel::create($data)) {
				$json = [
					'success' => true,
					'message' => 'Input Validated. User Registered'
				];

				unset($_SESSION['captcha']);
				Auth::login($user);


			} else {

				$json = [
					'success' => false,
					'message' => 'Error. Unable to save in database',
				];
			}

			echo json_encode($json);

		} else {
			echo json_encode(['success' => false, 'message' => 'Validation Error.']);
		}

	}

	public function loginUser()
	{
		$validate = new \app\libs\Validation;

		$mobile = $this->post('mobile');
		$password = $this->post('password');
		$captcha = $this->post('captcha');

		// if($captcha == $_SESSION['captcha']) 
		if($this->isPost())
		{
			// unset($_SESSION['captcha']);
			$user = User::where('mobile', $mobile)->first();

			if(!$user) $user = User::where('mobile', $mobile)->first();

			if($user && password_verify($password, $user->password)) {

				$token['user'] = $user; 
				$json = [
					'success' => true,
					'message' => 'Logged in',
					'user' => $user->toArray(),
					'token' => JWT::encode($token, JWT_SECRET)
				];

				Auth::login($user);

				// $this->AuthMiddleware->toPanel();

				//Need a middleware to reditect user to particular database

				// header("Location: /admin");		

			} else {
				$json = [
					'success' => false,
					'message' => 'Wrong credentials',
				];

				// return view('auth/login.tpl', ['error' => 1]);
				// header("Location: /admin");	

				// echo 'Error';	

			}
		} else {
			
			// return view('auth/login.tpl', ['error' => 2, 'message' => 'Wrong Captcha']);

		}

		

		echo json_encode($json);

		//user login logic
	}


	/* Forgot Password Execution */

	public function forgotUser()
	{
		$email = $this->post('email');
		$captcha = $this->post('captcha');

		// if($captcha == $_SESSION['captcha'])
		if($this->isPost())
		 {
			if(User::where('email', $email)->count() > 0) {
				//Send Email
				$userId = User::where('email', $email)->first()['id'];

				if(PasswordReset::where('user_id', $userId)->count() > 0) {
					//Edit Old Reset entry
					$passwordReset = PasswordReset::where('user_id', $userId)->first();

					$passwordReset->hash = md5( $userId.md5(time()) );

					$passwordReset->save();
				} else {
					//create new Reset entry

					$passwordReset = new PasswordReset;

					$passwordReset->user_id = $userId;
					$passwordReset->hash = md5( $userId.md5(time()) );

					$passwordReset->save();
				}

				// Send Email Now

				Mail::sendResetPassword(['email' => $email, 'hash' => md5($passwordReset->hash)]);
				$data['success'] = true;

				echo json_encode($data);

			}
			elseif (User::where('mobile', $email)->count() > 0) {
				//Send Message

				$userId = User::where('mobile', $email)->first()['id'];

				if(PasswordReset::where('user_id', $userId)->count() > 0) {
					//Edit Old Reset entry
					$passwordReset = PasswordReset::where('user_id', $userId)->first();

					$passwordReset->hash = md5( $userId.md5(time()) );

					$passwordReset->save();
				} else {
					//create new Reset entry
					
					$passwordReset = new PasswordReset;

					$passwordReset->user_id = $userId;
					$passwordReset->hash = md5( $userId.md5(time()) );

					$passwordReset->save();
				}

				//Send Sms Now
			}
			else {
				$data['success'] = false;
				echo json_encode($data); 
			}
		} 
		else {
			$data['success'] = false;
			echo json_encode($data);
		}

		// return view('auth/forgot.tpl', $data);
	}
}