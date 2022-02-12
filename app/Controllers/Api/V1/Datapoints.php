<?php

namespace App\Controllers\Api\V1;

use App\Models\{
	DatapointModel,
	NodekeysModel
};
use CodeIgniter\RESTful\ResourceController;

class Datapoints extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
		$return = [
			'success' => false,
			'error' => [
				'message' => 'No data avaiable though this, please use an endpoint'
			]
		];
		return $this->response->setJSON(json_encode($return, ENVIRONMENT == "production" ?: JSON_PRETTY_PRINT));
    }

	    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function capture()
    {
		$return['success'] = true;
		$this->DatapointModel = new DatapointModel();
		$this->NodekeysModel = new NodekeysModel();

		try {
			$data = json_decode(file_get_contents('php://input'), true);
			if(!$this->NodekeysModel->validateKey($data['id'], getallheaders()['Authorization']))
			{
				throw new \Exception('Invalid or expired access token');
			}
			if(!$this->DatapointModel->create($data['id'], $data['temp'], $data['time']))
			{
				throw new \Exception('The server is unable to handel your request at this time');
			}
		} catch (\Exception $e)
		{
			$return['node ID'] = $data['id'];
			$return['success'] = false;
			$return['error']['message'] = $e->getMessage();
			log_message('debug', json_encode($return, ENVIRONMENT == "production" ?: JSON_PRETTY_PRINT));
		}

		return $this->response->setJSON(json_encode($return, ENVIRONMENT == "production" ?: JSON_PRETTY_PRINT));
	}

	public function key($node_id)
	{
		$this->NodekeysModel = new NodekeysModel();

		$return['key'] = $this->NodekeysModel->createKey($node_id);
		
		return $this->response->setJSON(json_encode($return, ENVIRONMENT == "production" ?: JSON_PRETTY_PRINT));
	}

	// eaf223dbf83e00655d9457c27b4942e7

}
