<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index($id)
    {
        $data = [
            "title" => "Detail Siswa",
            'data' => $this->masterData->findByUserNis($id)
        ];
        return view('home/detail-siswa', $data);
    }
}
