<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <button class="btn btn-primary sm" onclick="addCategory()">Add Category</button>
        </div>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Category Image</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($category as $category) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <img src="<?= $category['category_image']; ?>" alt="product category image" width="50px">
                    </td>
                    <td><?= $category['category_name']; ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                                onclick="updateCategory(
                                <?= $category['id']; ?>,
                                        '<?= $category['category_name']; ?>',
                                        '<?= $category['category_image']; ?>')">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCategory(<?= $category['id']; ?>)">Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<script type="text/javascript">

</script>

<?= $this->endSection(); ?>

