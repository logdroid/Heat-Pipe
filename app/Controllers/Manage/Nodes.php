<?php

namespace App\Controllers\Manage;

use App\Controllers\BaseController;

use App\Models\{
	UserModel,
	NodeModel
};

class Nodes extends BaseController
{

	public function __construct()
	{
		$this->UserModel = new UserModel();
		$this->NodeModel = new NodeModel();

	}

    public function index()
    {
		$session = session(); // Start session
		if(!isset($_SESSION['is_loggedin'])) // check for valid login
		{
			return redirect()->to(site_url('/login')); // get outa here
		}

		#echo '<pre>';
		#print_r($this->NodeModel->GetAllByOwner($_SESSION['user_id']));

		


    }
}
