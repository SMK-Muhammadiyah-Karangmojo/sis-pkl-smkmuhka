<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <button class="btn btn-primary sm" onclick="addProduct()">Add Product</button>
        </div>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="10px">No</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Detail</th>
                    <th>Product Price</th>
                    <th>Product Netto</th>
                    <th>Nomor POM</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($product as $product) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <img src="<?= $product['product_image']; ?>" alt="product image" width="80px">
                    </td>
                    <td><?= $product['product_name']; ?></td>
                    <td><?= $product['product_detail']; ?></td>
                    <td><?= $product['product_price']; ?></td>
                    <td><?= $product['netto']; ?></td>
                    <td><?= $product['no_pom']; ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm mb-2" onclick="updateCatalog(
                            '<?= $product['id']; ?>',
                            '<?= $product['product_name']; ?>',
                            '<?= $product['product_detail']; ?>',
                            '<?= $product['product_price']; ?>',
                            '<?= $product['product_image']; ?>',
                            '<?= $product['netto']; ?>',
                            '<?= $product['no_pom']; ?>',
                            '<?= $product['product_category_id']; ?>'
                        )">Edit</button>
                        <button class="btn btn-danger btn-sm"
                            onclick="deleteCatalog('<?= $product['id'];?>')">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<?= $this->endSection(); ?>