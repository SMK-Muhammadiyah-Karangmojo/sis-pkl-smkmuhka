<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Libraries\Validation\SessionValidation;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{

    protected SessionValidation $sessionValidate;

    public function __construct()
    {
        $this->sessionValidate = new SessionValidation();
    }

    public function index(): string|RedirectResponse
    {
        $data = [
            'title' => "login page",
            'data' => $this->users->findAll()
        ];
        $isValidSession = $this->sessionValidate->validSession($this->session);
        if ($isValidSession) {
            return $this->sessionValidate->isValid($this->session->get('role'));
        } else {
            return view('auth/index', $data);
        }
    }

    public function register(): string|RedirectResponse
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
            $this->users->save($data);
            $session->setFlashdata('success', 'Register successfully!!!');
            return redirect()->to("/");
        } else {
            $data['validation'] = $this->validator;
            return view('register', $data);
        }
    }

    public function login(): RedirectResponse
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
                    $this->sessionValidate->isValid($data->role_pkl);
                }
                $this->session->setFlashdata('warning', 'Email is not activation!!!');
            }
            $this->session->setFlashdata('error', 'Password salah!!!');
        } else {
            $this->session->setFlashdata('warning', 'Email not found!!!');
        }
        return redirect()->to("/");
    }

    public function logout(): RedirectResponse
    {
        $this->session->setFlashdata('success', 'Logout successfully!!!');
        $this->session->destroy();
        return redirect()->to("/");
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