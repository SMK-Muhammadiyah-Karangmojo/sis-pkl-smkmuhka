<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\APIResponseBuilder;
use Config\YantoDevConfig;

/**
 * @property YantoDevConfig $config
 * @property UsersModel $user
 * @property APIResponseBuilder $ResponseBuilder
 */
class User extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->config = new YantoDevConfig();
        $this->user = new UsersModel();
    }

    /**
     * @throws \ReflectionException
     */
    public function addUser(): \CodeIgniter\HTTP\Response
    {
        $request = [
            'role_pkl' => $this->request->getVar('role'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'image' => "default.png",
            'is_active' => $this->request->getVar('isActive')
        ];
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->user->insert($request)
            )
        );
    }

    public function userActivation(): \CodeIgniter\HTTP\Response
    {
        $response = $this->user->getWhere([
                'email' => $this->request->getVar('email'),
                'role_pkl' => $this->request->getVar('role'),
            ]
        )->getRow();
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->user->update(
                    $response->id,
                    [
                        'is_active' => 1,
                        'role_pkl' => $this->request->getVar('role')
                    ]))
        );
    }

    public function getUserByEmail(): \CodeIgniter\HTTP\Response
    {
        $email = $this->request->getVar('email');
        $result = $this->user->getWhere(['email' => $email])->getRow();
        $data = [
            'id' => $result->id,
            'name' => $result->name,
            'email' => $result->email,
        ];
        try {
            if (is_null($result)) {
                $response = $this->ResponseBuilder->noContent('data with email ' . $email . ' not found');
            }
            $response = $this->ResponseBuilder->ok($data);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function teacher(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder($this->user->findAllTeacher())
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function updateUserRole(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->user->update(
                    $this->request->getVar('id'),
                    ['role_pkl' => $this->request->getVar('role')]
                )
            )
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function resetPasswordUser(): \CodeIgniter\HTTP\Response
    {
        $password = $this->request->getVar('password');
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->user->update(
                    $this->request->getVar('id'),
                    ['password' => password_hash($password)]
                )
            )
        );
    }
}