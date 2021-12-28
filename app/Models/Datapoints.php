<?php

namespace App\Models;

use CodeIgniter\Model;

class Datapoints extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'datapoints';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
		'id',
		'node_id',
		'temperature',
		'timestamp'
	];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'timestamp';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = true;
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

	/**
	 * Save node datapoint to database
	 *
	 * @param mixed $data array data captured from node
	 * @return mixed
	 * @throws conditon
	 **/
	public function createDatapoint(array $data)
	{
		$db_array = [
			'node_id' => $data['id'],
			'temperature' => $data['temp'],
			'timestamp' => $data['time']
		];
		return $this->insert($db_array);
	}

		/**
	 * Save node datapoint to database
	 *
	 * @param mixed $data array data captured from node
	 * @return bool
	 * @throws conditon
	 **/
	public function getDatapointRange($node_id, $range)
	{
		$this->where('node_id', $node_id);
		$this->where('timestamp >=', $range);
		return $this->findAll();
	}

}
