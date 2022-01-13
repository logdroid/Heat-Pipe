<?php

namespace App\Models;

use CodeIgniter\Model;

class Nodes extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'nodes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
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

	public function getinfoAll($id)
	{
		return $this->where('id', $id)->findall();
	}

	public function getinfoName($id)
	{
		return $this->where('id', $id)->
		select('name')->
		findall();
	}

	public function getinfoColor($id)
	{
		return $this->where('id', $id)->
		select('color')->
		findall();
	}

	public function getinfoStatus($id)
	{
		return $this->where('id', $id)->
		select('status')->
		findall();
	}


}
