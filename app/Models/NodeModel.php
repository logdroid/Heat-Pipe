<?php

namespace App\Models;

use CodeIgniter\Model;

class NodeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'nodes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
		'id', 'name', 'owner', 'color', 'status',
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

	public function getNameByID($id)
	{

	}

	public function getStatusByID($id)
	{

	}

	public function getAllByID($id)
	{
		return $this->where('id', $id)->findAll();
	}

	public function GetAllByOwner($user_id)
	{
		return $this->where('owner', $user_id)->findAll();
	}

}
