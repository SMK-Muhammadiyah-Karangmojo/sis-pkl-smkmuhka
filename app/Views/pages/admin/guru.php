<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <div>
                <button class="btn btn-outline-primary" onclick="addGuru()"><i class="fa fa-plus"></i> Tambah Guru
                </button>
            </div>
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>NBM</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>HP</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($guru as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td id="nbm"><?= $d['nbm']; ?></td>
                    <td id="name"><?= $d['nama']; ?></td>
                    <td id="jabatan"><?= $d['jabatan']; ?></td>
                    <td id="hp"><?= $d['hp']; ?></td>
                    <td id="email"><?= $d['email']; ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="updateGuru(<?= $d['id']; ?>)">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm"
                                onclick="deleteGuru('<?= $_SERVER['DELETE_TEACHER']; ?>',<?= $d['id']; ?>)">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>; ?>