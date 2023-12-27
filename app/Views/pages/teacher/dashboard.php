<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3>Welcome, <b><?= $data->name; ?></b></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3" style="text-align: center">
                                <img src="<?= base_url('/assets/img/users/' . $data->image); ?>"
                                     class="img-circle elevation-2"
                                     alt="User Image" width="150px">
                            </div>
                            <div class="col-lg-9">
                                <?php if ($tutor): ?>
                                    <h4>
                                        Saat ini anda terdaftar sebagai pendamping di :
                                        <?php foreach ($tutor as $t): ?>
                                            <?php
                                            $db = db_connect();
                                            $dataStudent = $db->query("
                                            select ud.name,
                                                   ud.user_id as nis,
                                                   i.name     as iduka,
                                                   ud.jk,
                                                   m.name     as jurusan,
                                                   c.name     as kelas,
                                                   di.address as alamat
                                            from master_data md
                                                    inner join user_details as ud on md.nis = ud.user_id
                                                    inner join iduka i on md.iduka_id = i.id
                                                    inner join major m on i.major_id = m.id
                                                    left join class c on ud.class_id = c.id
                                                    left join detail_iduka di on di.id_iduka = i.id
                                            where md.deleted_at is null
                                                and ud.user_public_id is not null
                                                and md.iduka_id =  $t->id_iduka 
                                                and md.tp_id = $t->tp_id
                                            ")->getResult(); ?>
                                            <ul>
                                                <li><strong><?= $t->iduka; ?></strong></li>
                                                Daftar Siswa:
                                                <ol>
                                                    <?php if ($dataStudent): ?>
                                                        <?php foreach ($dataStudent as $s): ?>
                                                            <li><?= $s->name; ?></li>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>

                                                    <?php endif; ?>
                                                </ol>
                                            </ul>
                                        <?php endforeach; ?>
                                    </h4>
                                <?php else: ?>
                                    <h4>Saat ini anda tidak terdaftar sebagai pendamping</h4>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>