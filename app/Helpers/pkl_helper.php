<?php

if (!function_exists('format_indo')) {
    function format_indo($date)
    {
        date_default_timezone_set('Asia/Jakarta');
        // array hari dan bulan
        $Hari = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];
        $Bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        // pemisahan tahun, bulan, hari, dan waktu
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 5);
        $hari = date('w', strtotime($date));
        $result =
            $Hari[$hari] .
            ', ' .
            $tgl .
            ' ' .
            $Bulan[(int)$bulan - 1] .
            ' ' .
            $tahun .
            ' ' .
            $waktu;
        // $result = $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;

        return $result;
    }
}
if (!function_exists('tanggal')) {
    function tanggal($date)
    {
        date_default_timezone_set('Asia/Jakarta');
        // array hari dan bulan
        $Hari = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];
        $Bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        // pemisahan tahun, bulan, hari, dan waktu
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 5);
        $hari = date('w', strtotime($date));
        // $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;
        $result =
            $tgl . ' ' . $Bulan[(int)$bulan - 1] . ' ' . $tahun . ' ' . $waktu;

        return $result;
    }
}
if (!function_exists('tgl')) {
    function tgl($date)
    {
        date_default_timezone_set('Asia/Jakarta');
        // array hari dan bulan
        $Hari = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];
        $Bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        // pemisahan tahun, bulan, hari, dan waktu
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 5);
        $hari = date('w', strtotime($date));
        // $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;
        $result =
            $Hari[$hari] .
            ', ' .
            $tgl .
            ' ' .
            $Bulan[(int)$bulan - 1] .
            ' ' .
            $tahun;

        return $result;
    }
}

if (!function_exists('tgl2')) {
    function tgl2($date)
    {
        date_default_timezone_set('Asia/Jakarta');
        // array hari dan bulan
        $Hari = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];
        $Bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        // pemisahan tahun, bulan, hari, dan waktu
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 5);
        $hari = date('w', strtotime($date));
        // $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;
        $result = $tgl . ' ' . $Bulan[(int)$bulan - 1] . ' ' . $tahun;

        return $result;
    }
}
if (!function_exists('bulan')) {
    function bulan($bulan)
    {
        switch ($bulan) {
            case 1:
                $bulan = 'Januari';
                break;
            case 2:
                $bulan = 'Februari';
                break;
            case 3:
                $bulan = 'Maret';
                break;
            case 4:
                $bulan = 'April';
                break;
            case 5:
                $bulan = 'Mei';
                break;
            case 6:
                $bulan = 'Juni';
                break;
            case 7:
                $bulan = 'Juli';
                break;
            case 8:
                $bulan = 'Agustus';
                break;
            case 9:
                $bulan = 'September';
                break;
            case 10:
                $bulan = 'Oktober';
                break;
            case 11:
                $bulan = 'November';
                break;
            case 12:
                $bulan = 'Desember';
                break;
        }
        return $bulan;
    }

    function allbulan($m = 0)
    {
        $bulan_arr = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        if ($m !== 0) {
            return $bulan_arr[$m];
        }
        return $bulan_arr;
    }

    function hari($d = 0)
    {
        $hari_arr = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jum\'at',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        if ($d !== 0) {
            return $hari_arr[$d];
        }
        return $hari_arr;
    }

    function hari_bulan($bulan, $tahun)
    {
        $kalender = CAL_GREGORIAN;
        $jml_hari = cal_days_in_month($kalender, $bulan, $tahun);
        $hari_tgl = [];

        for ($i = 1; $i <= $jml_hari; $i++) {
            $tgl = $tahun . '-' . $bulan . '-' . $i;
            $hari_tgl[] = [
                'hari' => hari(date('l', strtotime($tgl))),
                'tgl' => date('Y-m-d', strtotime($tgl)),
            ];
        }
        return $hari_tgl;
    }

    function is_weekend($tgl = false)
    {
        $tgl = @$tgl ? $tgl : date('Y-m-d');
        return in_array(date('l', strtotime($tgl)), ['Saturday', 'Sunday']);
    }

    function hari_ini()
    {
        $hari = date("D");

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }
        return $hari_ini;
    }

    function baseUrl($data)
    {
        switch ($data) {
            case 1:
                $url = "testtt";
                break;
            default:
                break;
        }
    }

    function jk($data): string
    {
        if ($data == 1) {
            return 'Laki-laki';
        } elseif ($data == 2) {
            return 'Perempuan';
        } else {
            return "";
        }
    }

    function statusPKL($data): string
    {
        if ($data == 1) {
            return "<badge class='badge badge-success'> <em class='fas fa-check-circle'></em> VERIFIKASI</badge>";
        } elseif ($data == 2) {
            return "<badge class='badge badge-danger'><em class='fas fa-times-circle'></em> REJECTED</badge>";
        } else {
            return "<badge class='badge badge-warning'><em class='fas fa-question-circle'></em> BELUM VERIFIKASI</badge>";
        }
    }

    function statusPKLExcel($data): string
    {
        if ($data == 1) {
            return "VERIFIKASI";
        } elseif ($data == 2) {
            return "REJECTED";
        } else {
            return "BELUM VERIFIKASI";
        }
    }

    function numberWA($data): string
    {
        if (!$data) {
            return "";
        }
        // kadang ada penulisan no hp 0811 239 345
        $data = str_replace(" ", "", $data);
        // kadang ada penulisan no hp (0274) 778787
        $data = str_replace("(", "", $data);
        // kadang ada penulisan no hp (0274) 778787
        $data = str_replace(")", "", $data);
        // kadang ada penulisan no hp 0811.239.345
        $data = str_replace(".", "", $data);
        // cek apakah no hp mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($data))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($data), 0, 3) == '+62') {
                $result = trim($data);
                // cek apakah no hp karakter 1 adalah 0
            } elseif (substr(trim($data), 0, 1) == '0') {
                $result = '62' . substr(trim($data), 1);
            } elseif (substr(trim($data), 0, 1) == '8') {
                $result = '628' . substr(trim($data), 1);
            }
        }
        return $result;
    }

    function getJurusan($kelas)
    {
        switch ($kelas) {
            case 'TKRO':
                return 'Teknik Kendaraan Ringan Otomotif';
                break;
            case 'TBSM':
                return 'Teknik dan Bisnis Sepeda Motor';
                break;
            case 'AKL':
                return 'Akuntansi dan Keuangan Lembaga';
                break;
            case 'OTKP':
                return 'Otomatisasi Tata Kelola Perkantoran';
                break;
            case 'BDP':
                return 'Bisnis Daring dan Pemasaran';
                break;
            default:
                break;
        }
    }

    function getMaster()
    {
        return [
            "content" => "Sertifikasi diselenggarakan berdasarkan Pedoman Direktur Jenderal Pendidikan Vokasi Pementerian Pendidikan dan Kebudayaan Tentang Penyelenggaraan Uji Kompetensi Keahlian Tahun Pelajaran 2021/2022 Tanggal 08 Maret 2022."
        ];
    }

    function cekImage($image): string
    {
        $file = base_url('assets/img/logo/' . $image . '.png');
        if (@GetImageSize($file)) {
            $image = "<img src='$file' height='80px' alt='logo iduka'>";
        } else {
            $image = "";
        }
        return $image;
    }
}