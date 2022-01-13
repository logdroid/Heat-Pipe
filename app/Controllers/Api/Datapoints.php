<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\{
	Datapoints as DatapointsModel
};
class Datapoints extends BaseController
{
    public function index()
    {
        // list nodes avalible to user
    }

	public function post($node_id)
	{
		$this->dpModel = new DatapointsModel;
		$data = json_decode(file_get_contents('php://input'), true);
		$this->dpModel->createDatapoint($data);

	}

	public function get($node_id, $range = 6)
	{
		$this->dpModel = new DatapointsModel;
		$range = strtotime('-' . $range . ' hours');
		return $this->response->setJSON(json_encode($this->dpModel->getDatapointRange($node_id, $range), JSON_PRETTY_PRINT));
	}
}
