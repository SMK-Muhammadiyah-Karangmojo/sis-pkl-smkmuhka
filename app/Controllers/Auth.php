<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.github.io/
 */

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Session\Session;
use ReflectionException;

/**
 * @property UsersModel $users
 * @property Session|mixed|null $session
 */
class Auth extends BaseController
{

    public function __construct()
    {
        $this->session = session();
    }

    public function index(): string
    {
        $data = [
            'title' => "login page",
            'data' => $this->users->findAll()
        ];
        return view('auth/index', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function register()
    {
        //include helper form
        helper(['form']);
        //set rules validation form
        $session = session();
        $rules = [
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[6]|max_length[200]'
        ];

        if ($this->validate($rules)) {
            $data = [
                'role_id' => $this->request->getVar('role'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'image' => "default.png",
                'is_active' => 1
            ];
            $this->usersModel->save($data);
            $session->setFlashdata('success', 'Register successfully!!!');
            return redirect()->to("/auth");
        } else {
            $data['validation'] = $this->validator;
            echo view('register', $data);
        }
    }

    public function login(): \CodeIgniter\HTTP\RedirectResponse
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $this->users->getWhere(['email' => $email])->getFirstRow();
        if ($data) {
            $pass = $data->password;
            $verifyPass = password_verify($password, $pass);
            if ($verifyPass) {
                $sesData = [
                    'id' => $data->id,
                    'email' => $data->email,
                    'role' => $data->role_pkl,
                    'logged_in' => true
                ];
                $this->session->set($sesData);
                $this->session->setFlashdata('login', $data->email);
                if ($data->is_active) {
                    switch ($data->role_pkl) {
                        case 1:
                            return redirect()->to('/admin');
                        case 2:
                            return redirect()->to('/teacher');
                        case 3:
                            return redirect()->to('/student');
                        default:
                            return redirect()->to('/auth');
                    }
                }
                $this->session->setFlashdata('warning', 'Email is not activation!!!');
            }
            $this->session->setFlashdata('error', 'Password salah!!!');
        } else {
            $this->session->setFlashdata('warning', 'Email not found!!!');
        }
        return redirect()->to("auth");
    }

    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->session->setFlashdata('success', 'Logout successfully!!!');
        $this->session->destroy();
        return redirect()->to("/auth");
    }

    public function error(): string
    {
        $data = [
            'title' => "error page",
            'data' => $this->users->findAll()
        ];
        return view('auth/error', $data);
    }
}