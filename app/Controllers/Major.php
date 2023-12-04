<?php

/**
 * The Major Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\IdukaModel;
use App\Models\MajorModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\YantoDevConfig;

/**
 * @property YantoDevConfig $config
 * @property MajorModel $major
 * @property IdukaModel $iduka
 */
class Major extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->config = new YantoDevConfig();
        $this->major = new MajorModel();
    }

    public function findAllMajor(): \CodeIgniter\HTTP\Response
    {
        $result = $this->config->ApiResponseBuilder($this->major->findAll());
        return $this->respond($result);
    }

    public function detailMajor(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->major->find($this->request->getVar('id'))
            )
        );
    }
}