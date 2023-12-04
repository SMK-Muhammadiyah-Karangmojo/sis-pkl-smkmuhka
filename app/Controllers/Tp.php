<?php

/**
 * The Tp Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\TpModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\YantoDevConfig;

/**
 * @property $config
 * @property $tp
 */
class Tp extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->config = new YantoDevConfig();
        $this->tp = new TpModel();
    }

    public function addTp(): \CodeIgniter\HTTP\Response
    {
        $data = [
            'name' => $this->request->getVar('name')
        ];
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->tp->insert($data)
            )
        );
    }

    public function findAllTp(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder($this->tp->findAll())
        );
    }

    public function findById(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->tp->find($this->request->getVar('id'))
            )
        );
    }

    public function updateTp(): \CodeIgniter\HTTP\Response
    {
        $data = [
            'name' => $this->request->getVar('name')
        ];
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->tp->update($this->request->getVar('id'), $data)
            )
        );
    }

    public function deleteTp(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->tp->delete($this->request->getVar('id'))
            )
        );
    }
}