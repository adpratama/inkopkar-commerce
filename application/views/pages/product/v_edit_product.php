<form method="POST" action="<?= base_url('product/store') ?>" enctype="multipart/form-data" autocomplete="off" novalidate>
    <div class="row">
        <!-- Nama Produk -->
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label for="nama_product" class="form-label">Nama Produk</label>
                <input type="text" name="nama_product" id="nama_product" class="form-control" placeholder="Masukkan nama produk..." value="<?= $detail['name'] ?>" required>
            </div>
        </div>

        <!-- Kategori -->
        <div class="col-md-6 col-sm-12">
            <div class="mb-3">
                <label for="category_ids" class="form-label">Kategori Produk</label>
                <select name="category_ids" id="category_ids" class="form-select" required>
                    <option value="">Select a category...</option>
                    <?php foreach ($categories as $cat) : ?>
                        <option <?= ($detail['category'] == $cat->id) ? "selected" : "" ?> value="<?= $cat->id ?>"><?= $cat->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="col-md-12">
            <div class="mb-3">
                <label for="descriptions" class="form-label">Deskripsi Produk</label>
                <textarea name="descriptions" id="descriptions" class="form-control" rows="4" placeholder="Tulis deskripsi lengkap produk..."><?= $detail['descriptions'] ?></textarea>
            </div>
        </div>

        <!-- Variasi Produk -->
        <div class="col-md-12">
            <label class="form-label">Varian Produk</label>
            <div id="variant-container">
                <?php
                if ($variants) {
                    foreach ($variants as $v) : ?>
                        <div class="row variant-item mb-2">
                            <div class="col-md-4">
                                <input type="text" name="variant_name[]" class="form-control" placeholder="Warna / Jenis" value="<?= $v->variant_name ?>" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="variant_price[]" class="form-control" placeholder="Harga" value="<?= $v->variant_price ?>" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="variant_stock[]" class="form-control" placeholder="Stok" value="<?= $v->stock ?>" readonly required>
                            </div>
                            <!-- <div class="col-md-3">
                                <input type="file" name="variant_image[]" class="form-control" accept="image/*">
                            </div> -->
                            <div class="col-md-1 d-flex align-items-center">
                                <button type="button" class="btn btn-sm btn-danger remove-variant">&times;</button>
                            </div>
                        </div>
                <?php
                    endforeach;
                } ?>
            </div>

            <button type="button" class="btn btn-sm btn-success mt-2" id="add-variant-edit">+ Tambah Varian</button>
        </div>
    </div>

    <!-- Tombol Submit -->
    <div class="form-footer mt-4">
        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </div>
</form>