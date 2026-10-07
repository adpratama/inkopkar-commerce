<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <?= $title ?>s
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 d-none d-sm-inline-block">
                        <form action="<?= base_url('product') ?>" method="post" autocomplete="off" novalidate>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                </span>
                                <input type="text" value="<?= $keyword ?>" class="form-control" name="keyword" placeholder="Search…" aria-label="Search in website">
                            </div>
                        </form>
                    </div>
                    <!-- Tombol Search untuk mobile -->
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Search">
                        <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                            <path d="M21 21l-6 -6" />
                        </svg>
                    </a>

                    <?php
                    if ($keyword) {
                    ?>
                        <a href="<?= base_url('dashboard/reset/product') ?>" class="btn btn-warning d-none d-sm-inline-block" aria-label="Reset search keyword" title="Reset search" data-bs-toggle="tooltip" data-bs-placement="top">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                            </svg>
                            Reset</a>
                        <a href="<?= base_url('dashboard/reset/product') ?>" class="btn btn-warning d-sm-none btn-icon" aria-label="Reset search keyword" title="Reset search" data-bs-toggle="tooltip" data-bs-placement="top">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                            </svg>
                        </a>
                    <?php
                    } ?>
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#addNewproduct">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add new
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#addNewproduct" aria-label="Create new report">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <?php
                    if ($keyword) {
                    ?>
                        <div class="card-header">
                            <h4 class="card-title">Search results for the keyword <strong>'<?= (isset($keyword)) ? $keyword : ''; ?>'</strong></h4>
                        </div>
                    <?php
                    } ?>

                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th class="w-25">SKU</th>
                                    <th class="w-25">Nama</th>
                                    <th class="w-1">Stok</th>
                                    <th class="w-1">Is Active</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = ($this->uri->segment(3)) ? ((($this->uri->segment(3) - 1) * $per_page) + 1) : '1';
                                if ($products) {
                                    foreach ($products as $c) :
                                        $checked = ($c->is_active == '1') ? 'checked' : ''; ?>

                                        <tr>
                                            <td class="text-end"><?= $no++; ?>.</td>
                                            <td><?= $c->sku ?></td>
                                            <td><?= $c->name ?></td>
                                            <td class="text-end"><?= number_format($c->stock) ?> pc(s)</td>
                                            <td>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input check_is_active" type="checkbox" id='checkbox_<?= $c->id ?>' <?= $checked ?> />
                                                    <span class="form-check-label"><?= ($c->is_active == '1') ? 'Publish' : 'Non-published' ?></span>
                                                </label>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-ghost-primary btn-sm editData" data-id="<?= $c->slug ?>" data-nama="<?= $c->name ?>">Edit</button>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">Tidak ada data yang ditampilkan</td>
                                    </tr>
                                <?php
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php $this->load->view('pages/layouts/_pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pencarian -->
<div class="modal modal-blur fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('product') ?>" method="post" autocomplete="off" novalidate>
                    <div class="input-group">
                        <input type="text" value="<?= $keyword ?>" class="form-control" name="keyword" placeholder="Search…" aria-label="Search">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="editData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="addNewproduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url('product/store') ?>" enctype="multipart/form-data" autocomplete="off" novalidate>
                    <div class="row">
                        <!-- Nama Produk -->
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label for="nama_product" class="form-label">Nama Produk</label>
                                <input type="text" name="nama_product" id="nama_product" class="form-control" placeholder="Masukkan nama produk..." required>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label for="category_ids" class="form-label">Kategori Produk</label>
                                <select name="category_ids" id="category_ids" class="form-select" required>
                                    <option value="">Select a category...</option>
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="descriptions" class="form-label">Deskripsi Produk</label>
                                <textarea name="descriptions" id="descriptions" class="form-control" rows="4" placeholder="Tulis deskripsi lengkap produk..."></textarea>
                            </div>
                        </div>

                        <!-- Upload Banyak Gambar -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="images" class="form-label">Gambar Produk</label>
                                <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                                <small class="form-text text-muted">Pilih beberapa gambar jika perlu.</small>
                            </div>
                            <div class="row" id="preview-images"></div>
                        </div>

                        <!-- Variasi Produk -->
                        <div class="col-md-12">
                            <label class="form-label">Varian Produk</label>
                            <div id="variant-container">
                                <div class="row variant-item mb-2">
                                    <div class="col-md-4">
                                        <input type="text" name="variant_name[]" class="form-control" placeholder="Warna / Jenis" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="variant_price[]" class="form-control" placeholder="Harga" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="variant_stock[]" class="form-control" placeholder="Stok" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="file" name="variant_image[]" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-danger remove-variant">&times;</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-success mt-2" id="add-variant">+ Tambah Varian</button>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-footer mt-4">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.editData', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            $('#editData .modal-title').text('Edit data ' + nama);

            $.ajax({
                url: "<?= site_url('product/formEdit') ?>",
                type: "POST",
                data: {
                    id: id,
                },
                success: function(data) {
                    $('#editData .modal-body').html(data);
                    $('#editData').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: "Error!! ",
                        text: 'Gagal mengambil data',
                        type: "error",
                        icon: "error",
                    });
                }
            });
        });
        $(document).on('click', '#add-variant', function() {
            $('#variant-container').append(`
            <div class="row variant-item mb-2">
                <div class="col-md-4">
                    <input type="text" name="variant_name[]" class="form-control" placeholder="Warna / Jenis">
                </div>
                <div class="col-md-2">
                    <input type="text" name="variant_price[]" class="form-control" placeholder="Harga (opsional)">
                </div>
                <div class="col-md-2">
                    <input type="text" name="variant_stock[]" class="form-control" placeholder="Stok">
                </div>
                <div class="col-md-3">
                    <input type="file" name="variant_image[]" class="form-control" accept="image/*">
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-danger remove-variant">&times;</button>
                </div>
            </div>
            `);
        });
        $(document).on('click', '#add-variant-edit', function() {
            $('#variant-container').append(`
            <div class="row variant-item mb-2">
                <div class="col-md-4">
                    <input type="text" name="variant_name[]" class="form-control" placeholder="Warna / Jenis">
                </div>
                <div class="col-md-4">
                    <input type="text" name="variant_price[]" class="form-control" placeholder="Harga (opsional)">
                </div>
                <div class="col-md-3">
                    <input type="text" name="variant_stock[]" class="form-control" placeholder="Stok">
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-danger remove-variant">&times;</button>
                </div>
            </div>
            `);
        });

        $(document).on('click', '.remove-variant', function() {
            $(this).closest('.variant-item').remove();
        });

        $('#addNewproduct').on('shown.bs.modal', function() {
            new TomSelect("#category_ids", {
                // create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        });
        $('#editData').on('shown.bs.modal', function() {
            new TomSelect("#category_ids", {
                // create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        });

        $(document).on('change', '.check_is_active', function() {
            let checkbox = $(this);
            let id = checkbox.attr('id').replace('checkbox_', '');
            let status = checkbox.is(':checked') ? '1' : '0';

            // Fungsi untuk generate kode acak
            function generateRandomCode(length) {
                let code = '';
                let characters = '0123456789';
                let charactersLength = characters.length;
                for (let i = 0; i < length; i++) {
                    code += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return code;
            }

            // Generate kode acak dengan panjang 6 digit
            let randomCode = generateRandomCode(6);

            // Tampilkan modal konfirmasi dengan kode acak
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                html: `Masukkan kode konfirmasi berikut untuk melanjutkan: <strong>${randomCode}</strong>`, // Tampilkan kode acak di modal
                input: 'text',
                inputPlaceholder: 'Masukkan kode konfirmasi',
                showCancelButton: true,
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Batal',
                preConfirm: (inputValue) => {
                    // Validasi input
                    if (!inputValue) {
                        Swal.showValidationMessage('Kode konfirmasi tidak boleh kosong!');
                    } else if (inputValue !== randomCode) {
                        Swal.showValidationMessage('Kode konfirmasi salah!');
                    } else {
                        return inputValue; // Kembalikan nilai input jika valid
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading Swal
                    Swal.fire({
                        title: "Loading...",
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    // Kirimkan status baru ke server
                    $.ajax({
                        url: '<?= base_url("product/updateStatusProduct/") ?>', // Ganti dengan URL endpoint Anda
                        method: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function(response) {
                            Swal.close(); // Tutup loading Swal
                            if (response.success) {
                                Swal.fire({
                                    title: "Success!!",
                                    text: response.message,
                                    icon: "success",
                                }).then(function() {
                                    // Reload halaman setelah sukses
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!!",
                                    text: 'Gagal memperbarui status!',
                                    icon: "error",
                                }).then(function() {
                                    // Reload halaman setelah gagal
                                    window.location.reload();
                                });
                            }
                        },
                        error: function() {
                            Swal.close(); // Tutup loading Swal jika terjadi kesalahan
                            Swal.fire({
                                title: "Error!!",
                                text: 'Terjadi kesalahan saat menghubungi server.',
                                icon: "error",
                            }).then(function() {
                                // Reload halaman jika terjadi error
                                window.location.reload();
                            });
                        }
                    });
                } else {
                    // Jika modal dibatalkan, kembalikan status checkbox ke semula
                    checkbox.prop('checked', !checkbox.is(':checked'));
                }
            });
        });
    });

    document.getElementById('images').addEventListener('change', function(event) {
        let container = document.getElementById('preview-images');
        container.innerHTML = '';
        Array.from(event.target.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(e) {
                let col = document.createElement('div');
                col.classList.add('col-md-2', 'mb-2');
                col.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded">`;
                container.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });
</script>