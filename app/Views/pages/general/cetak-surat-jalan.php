<style>
    @page {
        margin-top: 20px;
        height: 100%;
    }

    #body {
        height: 100%;
    }
</style>
<?php foreach ($iduka as $idk): ?>
    <?php
    $db = db_connect();
    $data = $db->table('master_data md')
        ->select(
            'md.id, md.status, ud.name, i.id as idukaId, i.name as idukaName,
                ud.user_id as nis,ud.jk, class.name as kelas, m.name as majorName,
               tp.name as tpName')
        ->join('tp', 'tp.id = md.tp_id')
        ->join('iduka i', 'i.id = md.iduka_id')
        ->join('major m', 'm.id = i.major_id')
        ->join('user_details ud', 'ud.user_public_id = md.user_public_id')
        ->join('class', 'class.id = ud.class_id', 'left')
        ->where('md.tp_id', $tp)
        ->where('md.iduka_id', $idk->id)
        ->where('md.deleted_at', null)
        ->orderBy('ud.user_id', 'ASC')
        ->orderBy('i.name', 'ASC')
        ->get()->getResult();
    ?>
    <div id="body">
        <?= $kop_surat->content; ?>
        <h3 align="center">
            <u>SURAT JALAN</u>
            <br/>Nomor : <?= $nomor->nomor; ?></h3>
        <p>Kepala SMK Muhammadiyah Karangmojo menerangkan dengan sesungguhnya bahwa siswa tersebut di bawah ini :
        </p>
        <table border="1" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>No.</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>L/P</th>
                <th>Kelas</th>
                <th>Kompetensi Keahlian</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            <?php foreach ($data as $d) : ?>
                <tr>
                    <td style="text-align:center"><?= $i; ?></td>
                    <td><?= $d->nis; ?></td>
                    <td><?= ucwords(strtolower($d->name)); ?></td>
                    <td><?= jk($d->jk); ?></td>
                    <td><?= $d->kelas; ?></td>
                    <td><?= $d->majorName; ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p>Adalah peserta praktik Kerja Lapangan dalam rangka Pendidikan Sistem Ganda (PSG), pada :</p>
        <table class="table">
            <tbody>
            <tr>
                <td width="50px"></td>
                <td>Tempat Praktik</td>
                <td>:
                    <strong>
                        <?= $idk->name; ?>
                    </strong>
                </td>
            </tr>
            <tr>
                <td width="50px"></td>
                <td>Lama Praktik</td>
                <td>: <strong>3 (tiga) Bulan</strong></td>
            </tr>
            <tr>
                <td width="50px"></td>
                <td>Waktu</td>
                <td>: <strong><?= $nomor->detail_tanggal; ?></strong></td>
            </tr>
            </tbody>
        </table>
        <br/>
        <table class="table">
            <tbody>
            <tr>
                <td width="400px" rowspan="5"></td>
                <td>Karangmojo, <?= tanggal($nomor->tanggal); ?></td>
            </tr>
            <tr>
                <td>Kepala Sekolah,</td>
            </tr>
            <tr>
                <td>
                    <?= $school['ttd']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $school['kepala_sekolah']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    NBM. <?= $school['nip']; ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>