<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\{
	UserModel,
};

class Users extends BaseController
{
	public function __construct()
	{
		$this->UserModel = new UserModel();
	}

    public function index()
    {
		$session = session(); // Start session
		if(!isset($_SESSION['is_loggedin'])) // check for valid login
		{
			return redirect()->to(site_url('/login')); // get outa here
		}

        echo '<pre>';
		print_r($this->UserModel->GetAllUsers());
    }
}
