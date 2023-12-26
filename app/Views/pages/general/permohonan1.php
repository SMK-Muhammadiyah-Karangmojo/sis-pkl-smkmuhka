<style type="text/css">
    @page {
        margin-top: 20px;
        height: 100%;
    }

    .left {
        text-align: left;
    }

    .right {
        text-align: right;
    }

    .center {
        text-align: center;
    }

    .justify {
        text-align: justify;
    }

    .img {
        margin-top: 0;
    }
</style>
<div class="image">
    <img src="<?= $kop_surat->content; ?>" alt="kop-surat" width="100%">
</div>
<table>
    <thead>
    <tr>
        <th style="text-align:left">Nomor</th>
        <th>:</th>
        <th style="text-align:left"><?= $surat ? $surat->nomor : ''; ?></th>
    </tr>
    <tr>
        <th style="text-align:left">Lampiran</th>
        <th>:</th>
        <th style="text-align:left"><?= $surat ? $surat->lampiran : ''; ?></th>
    </tr>
    <tr>
        <th style="text-align:left">Hal</th>
        <th>:</th>
        <th style="text-align:left"><?= $surat ? $surat->hal : ''; ?></th>
    </tr>
    </thead>
</table>

<p>Kepada<br/>
    Yth.<b><?= $instansi . " " . $iduka->name; ?></b><br/>
    di <?= $iduka->address; ?>
</p>
<p class="justify">
    <i>Assalamu’alaikum wr. wb.</i><br/>
    <?= $surat ? $surat->p1 : ''; ?>
</p>
<table border="1" align="center" cellspacing="0">
    <tr>
        <th>
            <h3 style="text-align:center"><?= $surat ? $surat->detail_tgl : ''; ?></h3>
        </th>
    </tr>
</table>
<p>Adapun peserta PKL adalah sebagai berikut:</p>
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
    <?php
    $i = 1; ?>
    <?php foreach ($master_data as $d) : ?>
        <tr>
            <td style="text-align:center"><?= $i; ?></td>
            <td><?= $d->nis; ?></td>
            <td><?= ucwords(strtolower($d->name)); ?></td>
            <td><?= jk($d->jk); ?></td>
            <td><?= $d->kelas; ?></td>
            <td><?= $d->jurusan; ?></td>
        </tr>
        <?php $i++; ?>
    <?php endforeach; ?>
    </tbody>
</table>

<p class="justify">
    <?= $surat ? $surat->p2 : ''; ?><br/>
    <?= $surat ? $surat->p3 : ''; ?>
</p>
<p><i>Wassalamu’alaikum wr. wb</i></p>

<table>
    <thead>
    <tr>
        <td>
            <p>Mengetahui,</p>
        </td>
        <td width="50%"></td>
        <td>
            Karangmojo, <?= tanggal(date("Y/m/d")); ?>
            <!-- Karangmojo, 02 November 2021 -->
        </td>
    </tr>
    <tr>
        <td>
            <p>Kepala Sekolah</p>
        </td>
        <td width="30%"></td>
        <td>Ketua Kompetensi Keahlian</td>
    </tr>
    <tr>
        <td valign="bottom" height="80px">
<!--            <img src="--><?php //= $_SERVER['app.baseURL']; ?><!--/assets/img/ttd-ks.png" alt="ttd kepsek" width="150px"/>-->
            <p><u><?= $school['kepala_sekolah']; ?></u></p>
        </td>
        <td></td>
        <td valign="bottom">
            <p><u><?= $kajur->name; ?></u></p>
        </td>
    </tr>
    <tr>
        <td>
            <p>NBM. <?= $school['nip']; ?></p>
        </td>
        <td></td>
        <td>
            <p>NBM. <?= $kajur->nbm; ?></p>
        </td>
    </tr>
    </thead>
</table>