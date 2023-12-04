<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card col-lg">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Email</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td id="email"><?= $d->email; ?></td>
                    <td id="name"><?= $d->name; ?></td>
                    <td id="role"><?= $d->role; ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs" onclick="editUser(<?= $d->id; ?>)">
                            Edit Role
                        </button>
                        <button class="btn btn-danger btn-xs" onclick="resetPasswordUser(<?= $d->id; ?>)">
                            Reset Password
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.card-body -->

<?= $this->endSection() ?>; ?>