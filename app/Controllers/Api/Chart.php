<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

use App\Models\{
	Group as GroupModel,
	Datapoints as DatapointsModel,
	Nodes as NodesModel
};

class Chart extends BaseController
{
	public function index()
	{
		//
	}

	public function node($id, $range = 6)
	{
		$range = strtotime('-' . $range . ' hours');
		$r = [
			'labels' => [],
			'datasets' => [
				[
					'label' => '',
					'borderColor' => '',
					'data' => []
				]
			]
		];
		$this->dpModel = new DatapointsModel;
		$this->nodeModel = new NodesModel;

		$temp_data = $this->dpModel->getDatapointRange($id, $range);
		foreach ($temp_data as $row => $data) {
			array_push($r['labels'], date('Y-m-d H:i', $temp_data[$row]['timestamp']));
			array_push($r['datasets'][0]['data'], $temp_data[$row]['temperature']);
		}

		$r['datasets'][0]['label'] = $this->nodeModel->getinfoAll($id)[0]['name'];
		$r['datasets'][0]['borderColor'] = $this->nodeModel->getinfoAll($id)[0]['color'];

		return $this->response->setJSON(json_encode(['error' => null, 'success' => true, 'body' => $r], (ENVIRONMENT == 'production') ?: JSON_PRETTY_PRINT));
	}

	public function group($id, $range = 6)
	{
		$range = strtotime('-' . $range . ' hours');

		// $r is the template array that will be $returned to the request in JSON format
		$r = [
			'labels' => [],
			'datasets' => [
				[
					'label' => '',
					'borderColor' => '',
					'data' => []
				],
			]
		];



		$tdata = [];
		$this->dpModel = new DatapointsModel;
		$this->nodeModel = new NodesModel;
		$this->GroupModel = new GroupModel;

		// Build $r['labels'] and $stamps array
		// We'll build $stamps first
		$stamps = [];
		$mepoch = microtime(true);

		#$stamps = $this->dpModel->buildTimestamps(time(), $range);

		#log_message('debug', "{env}	| {file} | {line} : mtime: ".$mepoch);

		$nodes = $this->GroupModel->getNodesInGroup($id);

		$c = 0;
		foreach ($nodes as $node) {
			$temp_data = $this->dpModel->getDatapointRange($node, $range);

			foreach ($temp_data as $row => $data) {
				array_push($r['labels'], date('Y-m-d H:i', $temp_data[$row]['timestamp']));
			}

			foreach ($temp_data as $row => $data) {
				array_push($tdata, $temp_data[$row]['temperature']);
			}

			$r['datasets'][$c]['label'] = $this->nodeModel->getinfoAll($node)[0]['name'];
			$r['datasets'][$c]['borderColor'] = $this->nodeModel->getinfoAll($node)[0]['color'];
			$r['datasets'][$c]['data'] = $tdata;
			$tdata = [];
			$c++;
		}

		$r['labels'] = array_unique($r['labels']);

		return $this->response->setJSON(json_encode(['error' => null, 'success' => true, 'body' => $r], (ENVIRONMENT == 'production') ?: JSON_PRETTY_PRINT));
	}
}
