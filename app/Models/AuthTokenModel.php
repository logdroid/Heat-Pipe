<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthTokenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'auth_tokens';
    #protected $primaryKey       = 'id';
    #protected $useAutoIncrement = true;
    #protected $insertID         = 0;
    protected $returnType       = 'array';
    #protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
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

	public function AddRememberToken(int $user_id, string $selector, string $validator, int $expire)
	{
		return $this->builder('auth_tokens')->insert([
			'user_id' => $user_id,
			'selector' => $selector,
			'hashedValidator' => hash('sha3-256', $validator),
			'expires' => $expire
		]);
	}

	public function GetRememberToken(string $selector, string $validator)
	{
		$data = $this->where('selector', $selector)->findAll();
		if(!empty($data))
		{
			if($data[0]['hashedValidator'] === hash('sha3-256', $validator))
			{
				return $data[0]['user_id'];
			}
		}
		return false;
	}

	public function RekeyToken(string $selector, string $validator)
	{
		return $this->builder()->where('selector', $selector)->set('hashedValidator', hash('sha3-256', $validator))->update();
	}

	public function DeleteRememberToken(string $selector)
	{
		return $this->where('selector', $selector)->delete();
	}
}
