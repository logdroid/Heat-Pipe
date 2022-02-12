<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

use App\Models\{
	UserModel,
	AuthTokenModel
};

class User extends BaseController
{

	public function __construct()
	{
		$this->UserModel = new UserModel();
		$this->AuthTokenModel = new AuthTokenModel();

	}

    public function index()
    {
		$session = session(); // Start session
		if(!isset($_SESSION['is_loggedin'])) // check for valid login
		{
			return redirect()->to(site_url('/login'));
		}


		echo '<pre>';
		print_r($_SESSION);
		echo '<br>';
		#print_r($_COOKIE['__HP_auth']);
		$auth = explode('.', $_COOKIE['__HP_auth']);
    }

	public function login()
	{
		$session = session(); // Start session
		helper('cookie');

		if(isset($_COOKIE['__HP_auth']))
		{
			return redirect()->to(site_url('/user/attempt_login'))->withCookies(); 
		}

		$data = [];
		if(isset($_SESSION['error_mesasage']))
		{
			$data['error_mesasage'] = $_SESSION['error_mesasage'];
		}
		return view('user/login', $data);
	}

	public function attempt_login()
	{
		$session = session(); // Start session
		helper('cookie');



		if(isset($_COOKIE['__HP_auth']))
		{
			$auth = explode('.', $_COOKIE['__HP_auth']);
			if($user_id = $this->AuthTokenModel->GetRememberToken($auth[0], $auth[1]))
			{
				if(!$db = $this->UserModel->FindUserByID($user_id))
				{
					$session->setFlashdata('error_message', 'Invalid username or password');
					return redirect()->to(site_url('/logout')); 
				}
				$validator = bin2hex(openssl_random_pseudo_bytes(24));
				$this->AuthTokenModel->RekeyToken($auth[0], $validator);
				$cookie_data = "{$auth[0]}.{$validator}";
				$this->response->setCookie('__HP_auth', $cookie_data, 1209600);
				$session->set([
					'username' => $db['username'],
					'name' => $db['name'],
					'user_id' => $db['id'],
					'is_loggedin' => true
				]);
				if(isset($_SESSION['_ci_previous_url']))
				{
					return redirect()->to($_SESSION['_ci_previous_url'])->withCookies();
				}
				return redirect()->to(site_url('/user'))->withCookies();
			}
		}

		if(!empty($_POST))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];

		// Check for existing user based on email or username | Done by UserModel
		if(!$db = $this->UserModel->FindUser($username))
		{
			$session->setFlashdata('error_message', 'Invalid username or password');
			return redirect()->to(site_url('/login')); 
		}

		// Verify password if user is found by previous step
		if(!password_verify($password, $db['password']))
		{
			$session->setFlashdata('error_message', 'Invalid username or password');
			return redirect()->to(site_url('/login')); 
		}

		if(isset($_POST['remember']))
		{
			#helper('cookie');
			$selector = bin2hex(openssl_random_pseudo_bytes(24));
			$validator = bin2hex(openssl_random_pseudo_bytes(24));
			$expire = new Time('+14 day');
			$this->AuthTokenModel->AddRememberToken($db['id'], $selector, $validator, strtotime($expire));
			$cookie_data = "{$selector}.{$validator}";
			$this->response->setCookie('__HP_auth', $cookie_data, 1209600);
		}

		$session->set([
			'username' => $db['username'],
			'name' => $db['name'],
			'user_id' => $db['id'],
			'is_loggedin' => true
		]);
		return redirect()->to(site_url('/user'))->withCookies();
		}
		#return redirect()->to(site_url('/login'));
	}

	public function logout()
	{
		$session = session(); // load session library
		$session->destroy(); // destroy users session
		if(isset($_COOKIE['__HP_auth'])) // check if long auth cookie is set
		{
			$auth = explode('.', $_COOKIE['__HP_auth']); // split selector from validator 
			$this->AuthTokenModel->DeleteRememberToken($auth[0]); // delete token from database
		}
		helper('cookie'); // load cookie library
		delete_cookie('__HP_auth'); // delete long login cookie
		return redirect()->to(site_url('/login'))->withCookies(); // send back to login page
	}


/*
	public function test()
	{
		$session = session(); // Start session
		if(!isset($_SESSION['is_loggedin'])) // check for valid login
		{
			$_SESSION['return_url'] = current_url();
			return redirect()->to(site_url('/login'));
		}
	}
*/


}
