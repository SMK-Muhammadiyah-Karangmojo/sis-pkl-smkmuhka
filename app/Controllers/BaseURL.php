<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\YantoDevConfig;

/**
 * @property YantoDevConfig $config
 */
class BaseURL extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->config = new YantoDevConfig();
    }

    public function url(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        $result = $this->config->baseUrl(getenv($id));
        return $this->respond($result);
    }
}