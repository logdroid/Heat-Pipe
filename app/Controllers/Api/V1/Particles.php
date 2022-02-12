<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;

class Particles extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $template = json_decode(file_get_contents(WRITEPATH.'particlesjs-config.json'),1);
		$template['particles']['color']['value'] = '#fff';
		$template['particles']['line_linked']['color'] = '#990000';

		return $this->response->setJSON(json_encode($template, ENVIRONMENT == "production" ?: JSON_PRETTY_PRINT));
    }
}
