<?php

namespace App\Libraries\Validation;

use CodeIgniter\HTTP\RedirectResponse;

class SessionValidation
{

    public function validSession($sessionData): bool
    {
        if (!$sessionData->get('logged_in')) {
            return false;
        } else {
            return true;
        }
    }

    public function isValid($role): RedirectResponse
    {
        switch ($role) {
            case 1:
                return redirect()->to('/admin');
            case 2:
                return redirect()->to('/teacher');
            case 3:
                return redirect()->to('/student');
            default:
                return redirect()->to('/');
        }
    }
}