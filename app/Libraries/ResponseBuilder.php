<?php
/**
 * @Author : yantodev
 * mailto: ekocahyanto007@gmail.com
 * link : http://yantodev.github.io/
 */

namespace App\Libraries;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\HTTP\RedirectResponse;

class ResponseBuilder extends BaseConfig
{

    protected IApplicationConstant $applicationConstant;
    private string|array|bool|int|null|object|float $session;

    public function __construct()
    {
        $this->applicationConstant = new IApplicationConstant();
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

    public function paginationResult($resultData, $totalPage, $totalData, $code = 200, $message = "success"): array
    {
       return [
            "result" => $resultData,
            "responseData" => [
                "code" => $code,
                "message" => $message
            ],
            "metaData" => [
                "totalPage" => $totalPage,
                "totalData" => $totalData
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

    public function ReturnViewValidation($session, $url, $data): string|RedirectResponse
    {
        if (!$session->get('logged_in')) {
            return redirect()->to($this->applicationConstant->auth);
        }
        $i = $session->get('role');
        if ($i == 2 || $i == 1) {
            return view($url, $data);
        } else {
            return redirect()->to($this->applicationConstant->authError);
        }
    }

    public function ReturnViewValidationTeacher($session, $url, $data): string|RedirectResponse
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->applicationConstant->auth);
        }
        if ($this->session->get('role') != 2) {
            return redirect()->to($this->applicationConstant->authError);
        }
        return view($url, $data);
    }

    public function ReturnViewValidationStudent($session, $url, $data): string|RedirectResponse
    {
        if (!$session->get('logged_in')) {
            return redirect()->to($this->applicationConstant->auth);
        }
        if ($session->get('role') != 3) {
            return redirect()->to($this->applicationConstant->authError);
        }
        return view($url, $data);
    }
}