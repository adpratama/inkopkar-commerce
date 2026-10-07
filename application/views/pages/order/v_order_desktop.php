<div class="d-none d-md-block">
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="card">
                <?php
                if (!empty($keyword) || !empty($status) || !empty($tanggal)) : ?>
                    <div class="card-header">
                        <h4 class="card-title">
                            Search results for
                            <?php
                            $filters = [];
                            if (!empty($keyword)) $filters[] = "keyword <strong>'$keyword'</strong>";
                            if (!empty($status)) $filters[] = "status <strong>'$status'</strong>";
                            if (!empty($tanggal)) $filters[] = "date <strong>'$tanggal'</strong>";

                            echo implode(", ", $filters);
                            ?>
                        </h4>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th class="w-1">#</th>
                                <th class="w-25">No. Orders</th>
                                <th class="w-25">Nama Pemesan</th>
                                <th class="w-1">Total</th>
                                <th class="">Delivery Method</th>
                                <th class="w-1">Status</th>
                                <th class="w-75"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $page = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 1;
                            $no = (($page - 1) * $per_page) + 1;

                            if (!empty($orders)) {
                                foreach ($orders as $c) : ?>
                                    <tr>
                                        <td class="text-end"><?= $no++; ?>.</td>
                                        <td><?= htmlspecialchars($c->no_order) ?></td>
                                        <td><?= htmlspecialchars($c->order_name) ?></td>
                                        <td class="text-end"><?= number_format($c->total) ?></td>
                                        <td><?= ucfirst(htmlspecialchars($c->delivery_method)) ?></td>
                                        <td>
                                            <?php
                                            if ($c->order_status == "belum bayar") {
                                            ?>
                                                <span class="badge bg-yellow text-yellow-fg"><?= ucfirst($c->order_status) ?></span>
                                            <?php
                                            } else if ($c->order_status == "menunggu konfirmasi") {
                                            ?>
                                                <span class="badge bg-lime text-lime-fg"><?= ucfirst($c->order_status) ?></span>
                                            <?php
                                            } else if ($c->order_status == "diproses") {
                                            ?>
                                                <span class="badge bg-info text-info-fg"><?= ucfirst($c->order_status) ?></span>
                                            <?php
                                            } else if ($c->order_status == "selesai") {
                                            ?>
                                                <span class="badge bg-success text-success-fg"><?= ucfirst($c->order_status) ?></span>
                                            <?php
                                            } else if ($c->order_status == "dikirim") { ?>
                                                <span class="badge bg-purple text-purple-fg"><?= ucfirst($c->order_status) ?></span>
                                            <?php } ?>

                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-ghost-primary btn-sm editData" data-id="<?= $c->id ?>" data-nama="<?= $c->no_order ?>">Edit</button>

                                            <button type="button" class="btn btn-info btn-sm viewOrder" data-id="<?= $c->id ?>">
                                                Detail
                                            </button>

                                            <?php if ($c->order_status == "menunggu konfirmasi") { ?>
                                                <button type="button" class="btn btn-success btn-sm processOrder" data-id="<?= $c->id ?>">Proses</button>
                                            <?php }

                                            if ($c->order_status == "diproses" && $c->delivery_method == "antar") { ?>
                                                <button type="button" class="btn btn-success btn-sm btn-send-order" data-id="<?= $c->id ?>" data-noorder="<?= $c->no_order ?>">
                                                    Kirim Pesanan
                                                </button>
                                            <?php } else if ($c->order_status == "diproses" && $c->delivery_method == "pickup") { ?>
                                                <button type="button" class="btn btn-success btn-sm pickupDone" data-id="<?= $c->id ?>">
                                                    Tandai Sudah Diambil
                                                </button>
                                            <?php } ?>


                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6">Tidak ada data yang ditampilkan</td>
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

<script>
    $(document).on('click', '.processOrder', function() {
        let orderId = $(this).data('id');

        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah kamu yakin ingin memproses pesanan ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Proses!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'order/proses_pesanan',
                    type: 'POST',
                    data: {
                        id: orderId
                    },
                    success: function(response) {
                        let result = JSON.parse(response);
                        if (result.status === 'success') {
                            Swal.fire("Berhasil!", "Pesanan telah diproses.", "success").then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Gagal!", "Terjadi kesalahan, coba lagi.", "error");
                        }
                    }
                });
            }
        });
    });
    $(document).on('click', '.pickupDone', function() {
        let orderId = $(this).data('id');
        Swal.fire({
            title: "Konfirmasi",
            text: "Pastikan barang benar-benar sudah diambil customer!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Sudah Diambil"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'order/pesanan_diambil',
                    type: 'POST',
                    data: {
                        id: orderId
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire("Selesai!", "Pesanan telah ditandai selesai.", "success").then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Gagal!", "Terjadi kesalahan.", "error");
                        }
                    }
                });
            }
        });
    });
</script>