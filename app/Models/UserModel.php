<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

	public function FindUser($ident)
	{
		if($data = $this->where('email', $ident)->orWhere('username', $ident)->findAll())
		{
			return $data[0];
		} else {
			return false;
		}
	}

	public function FindUserByID($user_id)
	{
		if($data = $this->where('id', $user_id)->findAll())
		{
			return $data[0];
		} else {
			return false;
		}
	}

	public function GetAllUsers()
	{
		$users = $this->findAll();
		foreach($users as $index => $user)
		{
			unset($users[$index]['password']);
			unset($users[$index]['totp_token']);
		}
		return $users;
	}
	
}
