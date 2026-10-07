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
                    <button class="btn" onclick="document.location=<?= base_url('order') ?>">
                        Menunggu konfirmasi
                        <span class="badge bg-lime text-lime-fg ms-2" id="notif-count">0</span>
                    </button>

                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterSearchModal">
                        <i class="fas fa-search"></i> Cari & Filter
                    </a>

                    <?php
                    if (!empty($keyword) || !empty($status) || !empty($tanggal)) {
                    ?>
                        <a href="<?= base_url('dashboard/reset/order') ?>" class="btn btn-warning d-none d-sm-inline-block" aria-label="Reset search keyword" title="Reset search" data-bs-toggle="tooltip" data-bs-placement="top">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                            </svg>
                        </a>
                        <a href="<?= base_url('dashboard/reset/order') ?>" class="btn btn-warning d-sm-none btn-icon" aria-label="Reset search keyword" title="Reset search" data-bs-toggle="tooltip" data-bs-placement="top">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                            </svg>
                        </a>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div id="orderContainer">
            <?php $this->load->view('pages/order/v_order_desktop', $orders); ?>
        </div>
    </div>
</div>

<!-- Modal Pencarian -->
<!-- Modal Filter & Search -->
<div class="modal fade" id="filterSearchModal" tabindex="-1" aria-labelledby="filterSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterSearchModalLabel">Cari & Filter Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('order') ?>" method="post">
                    <!-- Search Input -->
                    <div class="mb-3">
                        <label for="keyword" class="form-label">Cari Pesanan</label>
                        <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Masukkan kata kunci..." value="<?= isset($keyword) ? $keyword : '' ?>">
                    </div>

                    <!-- Filter Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="belum bayar" <?= (isset($status) && $status == 'belum bayar') ? 'selected' : '' ?>>Belum Bayar</option>
                            <option value="menunggu konfirmasi" <?= (isset($status) && $status == 'menunggu konfirmasi') ? 'selected' : '' ?>>Menunggu Konfirmasi</option>
                        </select>
                    </div>

                    <!-- Filter Tanggal -->
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= isset($tanggal) ? $tanggal : '' ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="editData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
<div class="modal modal-blur fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="orderDetailContent"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modalSendOrder" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formSendOrder">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Pesanan - <span id="sendOrderNo"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="sendOrderId">
                    <div class="mb-3">
                        <label for="courier">Kurir</label>
                        <input type="text" class="form-control" name="courier" required>
                    </div>
                    <div class="mb-3">
                        <label for="resi">No Resi</label>
                        <input type="text" class="form-control" name="resi" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan & Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
    });

    $(document).on('click', '.viewOrder', function() {
        var orderId = $(this).data('id');

        $.ajax({
            url: "<?= site_url('order/getOrderDetail') ?>",
            type: "POST",
            data: {
                id: orderId
            },
            success: function(response) {
                $('#orderDetailContent').html(response);
                $('#orderDetailModal').modal('show');
            },
            error: function() {
                alert("Gagal mengambil data pesanan");
            }
        });
    });

    $(document).on('click', '.btn-send-order', function() {
        $('#sendOrderId').val($(this).data('id'));
        $('#sendOrderNo').text($(this).data('noorder'));
        $('#modalSendOrder').modal('show');
    });

    $('#formSendOrder').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: base_url + 'order/kirim_pesanan',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status === 'success') {
                    Swal.fire("Berhasil!", "Pesanan dikirim ke alamat customer.", "success").then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire("Gagal!", "Gagal mengirim pesanan.", "error");
                }
            }
        });
    });


    setInterval(function() {
        $.ajax({
            url: "<?= site_url('order/checkNewOrders') ?>",
            success: function(response) {
                if (response > 0) {
                    $('#notif-icon').addClass('bg-danger');
                    $('#notif-count').text(response);
                }
            }
        });
    }, 5000);
</script>

<script>
    $(document).ready(function() {
        function checkScreen() {
            var mode = window.innerWidth < 768 ? 'mobile' : 'desktop';

            // Cek apakah mode berubah atau pertama kali akses
            if (mode !== localStorage.getItem("viewMode") || !localStorage.getItem("viewMode")) {
                localStorage.setItem("viewMode", mode);
                loadOrders(mode);
            }
        }

        function loadOrders(mode) {
            $.ajax({
                url: "<?= base_url('order/load_data') ?>",
                type: "GET",
                data: {
                    mode: mode
                },
                beforeSend: function() {
                    $("#orderContainer").html(`
                        <div class="page page-center">
                            <div class="container container-slim py-4">
                                <div class="text-center">
                                    <div class="mb-3">
                                        
                                        <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?= base_url() ?>assets/logo/logo.gif" height="100" alt=""></a>
                                    </div>
                                    <div class="text-secondary mb-3">Preparing data</div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar progress-bar-indeterminate"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                },
                success: function(response) {
                    $("#orderContainer").html(response);
                },
                error: function() {
                    $("#orderContainer").html("<p>Error loading data</p>");
                }
            });
        }

        // Jalankan saat pertama kali halaman dimuat
        var initialMode = window.innerWidth < 768 ? 'mobile' : 'desktop';
        localStorage.setItem("viewMode", initialMode);
        loadOrders(initialMode);

        $(window).resize(function() {
            checkScreen();
        });
    });
</script>