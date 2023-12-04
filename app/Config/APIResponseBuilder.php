<?php
/**
 * @Author : yantodev
 * mailto: ekocahyanto007@gmail.com
 * link : http://yantodev.github.io/
 */

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * @property IApplicationConstantConfig $IApplicationConstant
 * @property \CodeIgniter\Session\Session|mixed|null $session
 */
class APIResponseBuilder extends BaseConfig
{

    public function __construct()
    {
        $this->IApplicationConstant = new IApplicationConstantConfig();
        $this->session = session();
    }

    public function ok($result): array
    {
        return [
            'result' => $result,
            'responseData' => $this->cekResponseData($result),
            'metaData' => [
                'total_data' => $this->cekData($result)
            ]
        ];
    }

    public function cekResponseData($data): array
    {
        return match ($data) {
            $data === [] => [
                'responseCode' => 204,
                'responseMsg' => 'no content'
            ],
            default => ['responseCode' => 200,
                'responseMsg' => "success"],
        };
    }

    public function cekData($data): int
    {
        if (is_object($data)) {
            return 1;
        } elseif (is_array($data)) {
            return sizeof($data);
        } else {
            return 0;
        }
    }

    public function noContent($message): array
    {
        return [
            'result' => '',
            'responseData' => [
                'responseCode' => 404,
                'responseMsg' => $message
            ],
            'metaData' => [
                'total_data' => is_array($message) ? sizeof($message) : 0
            ]
        ];
    }

    public function internalServerError(string $message): array
    {
        return [
            'result' => '',
            'responseData' => [
                'responseCode' => 500,
                'responseMsg' => $message
            ],
            'metaData' => [
                'total_data' => 0
            ]
        ];
    }

    public function ReturnViewValidation($session, $url, $data): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (!$session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        $i = $session->get('role');
        if ($i == 2 || $i == 3 || $i == 1) {
            return view($url, $data);
        } else {
            return redirect()->to($this->IApplicationConstant->authError);
        }
    }

    public function ReturnViewValidationTeacher($session, $url, $data): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 2) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view($url, $data);
    }

    public function ReturnViewValidationStudent($session, $url, $data): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (!$session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($session->get('role') != 3) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view($url, $data);
    }
}