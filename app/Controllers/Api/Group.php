<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\{
	Group as GroupModel,
	Datapoints as DatapointsModel
};
class Group extends BaseController
{
    public function index()
    {
        //
    }

	public function list($group_id)
	{
		$this->groupModel = new GroupModel;
		return $this->response->setJSON(json_encode($this->groupModel->getNodeInGroup($group_id), JSON_PRETTY_PRINT));
	}

	public function get($group_id, $range =1)
	{

		$return_array = [];

		$this->groupModel = new GroupModel;
		$this->dpModel = new DatapointsModel;
		$range = strtotime('-' . $range . ' minutes'); // change back to hours

		$nodes = $this->groupModel->getNodesInGroup($group_id);
		foreach($nodes as $node_id)
		{
			$return_array = [
				$node_id => $this->dpModel->getDatapointRange($node_id, $range)
			];
		}

		return $this->response->setJSON(json_encode($return_array, JSON_PRETTY_PRINT));

	}
}
