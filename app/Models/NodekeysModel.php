<?php

namespace App\Models;

use CodeIgniter\Model;

class NodekeysModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'node_keys';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
		'id', 'node_id', 'token', 'status',
		'token_expiry',
		'created_at', 'updated_at', 'deleted_at'
	];

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

	public function createKey($node_id)
	{
		$key = bin2hex(openssl_random_pseudo_bytes('32'));
		$data = [
			'node_id' => $node_id,
			'token' => $key,
			'status' => 'active',
		];
		try
		{
			$return['id'] = $this->insert($data);
			$return['key'] = $key;
			return $return;
		} catch (\Exception $e) {
			return $e;
		}

	}

	public function validateKey($node_id, $key)
	{
		$key = explode('Bearer ', $key)[1];
		return $this->where('node_id', $node_id)->where('token', $key)->findAll();
	}

}
