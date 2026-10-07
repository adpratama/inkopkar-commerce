<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <?= ($this->session->userdata('role_id') == '3') ? 'My ' : '' ?><?= $title ?>s
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 d-none d-sm-inline-block">
                        <form action="<?= base_url('booking') ?>" method="post" autocomplete="off" novalidate>
                            <?php $this->load->view('pages/layouts/_search') ?>
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
                        <a href="<?= base_url('dashboard/reset/booking') ?>" class="btn btn-warning d-none d-sm-inline-block" aria-label="Reset search keyword" title="Reset search" data-bs-toggle="tooltip" data-bs-placement="top">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                            </svg>
                            Reset</a>
                        <a href="<?= base_url('dashboard/reset/booking') ?>" class="btn btn-warning d-sm-none btn-icon" aria-label="Reset search keyword" title="Reset search" data-bs-toggle="tooltip" data-bs-placement="top">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                            </svg>
                        </a>
                    <?php
                    } ?>
                    <a href="#" class="btn btn-green d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#download-excel">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-excel">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                            <path d="M10 12l4 5" />
                            <path d="M10 17l4 -5" />
                        </svg>
                        Rekap booking
                    </a>
                    <a href="#" class="btn btn-green d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#download-excel" aria-label="Rekap booking" title="Rekap booking">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-excel">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                            <path d="M10 12l4 5" />
                            <path d="M10 17l4 -5" />
                        </svg>
                    </a>
                    <?php
                    if ($this->session->userdata('role_id') == '3') {
                    ?>
                        <a href="<?= base_url('booking/create_booking') ?>" class="btn btn-primary d-none d-sm-inline-block" aria-label="Create new booking" title="Create new booking">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new</a>
                        <a href="<?= base_url('booking/create_booking') ?>" class="btn btn-primary d-sm-none btn-icon" aria-label="Create new booking" title="Create new booking">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
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
        <?= $this->session->flashdata('message_warning'); ?>
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
                                    <th class="">No. Resi</th>
                                    <?php
                                    if ($this->session->userdata('role_id') == '2' or $this->session->userdata('username') == 'krx0005') {
                                    ?>
                                        <th class="w-1">AWB</th>
                                        <th class="">Customer</th>
                                    <?php
                                    } ?>
                                    <th class="w-1">Origin</th>
                                    <th class="w-1">Dest</th>
                                    <th class="w-1">Qty</th>
                                    <th class="w-1">Chwt</th>
                                    <th class="w-1">Total</th>
                                    <th class="w-1">Payment</th>
                                    <th class="w-1">Pickup</th>
                                    <th>Status</th>
                                    <?php
                                    if ($this->session->userdata('role_id') == '2' or $this->session->userdata('username') == 'krx0005') {
                                    ?>
                                        <th class="w-1">Warehouse</th>
                                        <th class="w-1">Arr.</th>
                                    <?php
                                    } ?>
                                    <th class=""></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($bookings) {
                                    $no = 1;

                                    foreach ($bookings as $b) :

                                        $checked = ($b->status_bayar == '1') ? 'checked' : '';
                                        $checked_warehouse = ($b->confirm_arr_warehouse == '1') ? 'checked' : '';
                                        $checked_destination = ($b->confirm_arrival == '1') ? 'checked' : '';
                                        $checked_pickup = ($b->confirm_pickup == '1') ? 'checked' : '';
                                        $disabled_check_payment = ($this->session->userdata('partner_id') == $b->partner_id) ? '' : 'disabled'; ?>

                                        <tr>
                                            <td class="text-end"><?= $no++; ?>.</td>
                                            <td><?= $b->no_resi ?></td>
                                            <?php
                                            if ($this->session->userdata('role_id') == '2' or $this->session->userdata('username') == 'krx0005') {
                                            ?>
                                                <td><?= ($b->awb) ? $b->awb : "-" ?></td>
                                                <td><?= $b->nama_pendaftar ?></td>
                                            <?php
                                            } ?>
                                            <td><?= $b->origin ?></td>
                                            <td><?= $b->destination ?></td>
                                            <!-- <td><?= $b->commodity ?></td> -->
                                            <td class="text-end"><?= number_format($b->qty) ?></td>
                                            <td class="text-end"><?= number_format($b->chargeable) ?></td>
                                            <td class="text-end"><?= number_format($b->nominal) ?></td>
                                            <td>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input check_payment" type="checkbox" id='checkbox_<?= $b->no_resi ?>' <?= $checked . ' ' . $disabled_check_payment ?> />
                                                    <span class="form-check-label"><?= ($b->status_bayar == '1') ? 'Paid' : 'Unpaid' ?></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input check_pickup" type="checkbox" id='pickup_<?= $b->no_resi ?>' <?= $checked_pickup ?> />
                                                    <span class="form-check-label"><?= ($b->confirm_pickup == '1') ? 'Sudah' : 'Belum' ?></span>
                                                </label>
                                            </td>

                                            <td class="text-center">
                                                <?php
                                                $status_badges = [
                                                    '4' => ['text' => 'Sudah tiba di tujuan', 'color' => 'bg-lime'],
                                                    '3' => ['text' => 'Menuju tujuan pengiriman', 'color' => 'bg-orange'],
                                                    '2' => ['text' => 'Pengantaran ke gudang', 'color' => 'bg-cyan'],
                                                    '0' => ['text' => 'Dalam proses', 'color' => 'bg-yellow'],
                                                ];

                                                if (isset($status_badges[$b->status_tracking])) {
                                                    $status = $status_badges[$b->status_tracking];
                                                ?>
                                                    <span class="badge <?= $status['color']; ?> w-100"><?= $status['text']; ?></span>
                                                <?php
                                                }
                                                ?>
                                            </td>

                                            <?php
                                            if ($this->session->userdata('role_id') == '2' or $this->session->userdata('username') == 'krx0005') {
                                            ?>
                                                <td>
                                                    <label class="form-check form-switch">
                                                        <input class="form-check-input check_warehouse" data-agent_id="<?= $b->agent_id ?>" type="checkbox" id='arrWarehouse_<?= $b->no_resi ?>' <?= $checked_warehouse ?> />
                                                        <span class="form-check-label"><?= ($b->confirm_arr_warehouse == '1') ? 'Sudah' : 'Belum' ?></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="form-check form-switch">
                                                        <input class="form-check-input check_destination" data-arr_warehouse="<?= $b->confirm_arr_warehouse ?>" type="checkbox" id='arrDestination_<?= $b->no_resi ?>' <?= $checked_destination ?> />
                                                        <span class="form-check-label"><?= ($b->confirm_arrival == '1') ? 'Sudah' : 'Belum' ?></span>
                                                    </label>
                                                </td>
                                            <?php
                                            }
                                            ?>
                                            <td class="">
                                                <a href="<?= base_url('booking/print_resi/' . $b->no_resi) ?>" target="_blank" class="btn btn-primary btn-sm ms-auto mb-1">Print</a>
                                                <?php
                                                if ($this->session->userdata('role_id') == '2' or $this->session->userdata('username') == 'krx0005') {
                                                ?>
                                                    <a href="<?= base_url('booking/detailResi/') . $b->no_resi ?>" class="btn btn-primary btn-sm ms-auto mb-1">Detail</a>
                                                    <button href="#" class="btn btn-danger btn-sm ms-auto mb-1">Void</button>
                                                    <?php
                                                } else {
                                                    if ($b->status_bayar == '0') {
                                                    ?>
                                                        <a href="<?= base_url('booking/editResi/' . $b->no_resi) ?>" class="btn btn-warning btn-sm ms-auto mb-1">Edit</a>
                                                        <button href="#" class="btn btn-danger btn-sm ms-auto mb-1">Void</button>
                                                <?php
                                                    }
                                                } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="<?= ($this->session->userdata('role_id') == '3') ? '11' : '13' ?>">Tidak ada data yang ditampilkan.</td>
                                    </tr>
                                <?php
                                } ?>
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
                <form action="<?= base_url('booking') ?>" method="post" autocomplete="off" novalidate>
                    <div class="input-group">
                        <input type="text" value="<?= $keyword ?>" class="form-control" name="keyword" placeholder="Search…" aria-label="Search">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="download-excel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unduh excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url('booking/downloadRekapExcel') ?>" autocomplete="off" novalidate>
                    <div class="row">
                        <?php
                        if ($this->session->userdata('role_id') == '2') {
                        ?>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="date_from" class="form-label">Mitra</label>
                                    <select name="partner_id" id="partner_id" class="form-control select2">
                                        <option value="">:: Pilih mitra</option>
                                        <?php
                                        foreach ($partners as $p) :
                                        ?>
                                            <option value="<?= $p->Id ?>"><?= $p->nama_pendaftar . ' - ' . $p->kode_gerai ?></option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php
                        } ?>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="date_from" class="form-label">Dari</label>
                                <input type="date" name="date_from" id="date_from" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="date_to" class="form-label">Sampai</label>
                                <input type="date" name="date_to" id="date_to" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer text-end">
                        <button type="submit" class="btn btn-primary ms-auto">Unduh</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('change', '.check_payment', function() {
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
                        url: '<?= base_url("booking/updateStatusBayar/") ?>', // Ganti dengan URL endpoint Anda
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
        $(document).on('change', '.check_pickup', function() {
            let checkbox = $(this);
            let id = checkbox.attr('id').replace('pickup_', '');
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
                title: 'Konfirmasi penjemputan',
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
                        url: '<?= base_url("booking/confirmPickup/") ?>', // Ganti dengan URL endpoint Anda
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
        $(document).on('change', '.check_warehouse', function() {
            let checkbox = $(this);
            let id = checkbox.attr('id').replace('arrWarehouse_', '');
            let status = checkbox.is(':checked') ? '1' : '0';
            let agent_id = checkbox.data('agent_id');

            // Validasi agent_id sebelum melanjutkan
            if (!agent_id || agent_id === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Agent tujuan belum dipilih!',
                });
                // Batalkan perubahan checkbox
                checkbox.prop('checked', !checkbox.is(':checked'));
                return; // Berhenti jika agent_id tidak valid
            }

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
                title: 'Konfirmasi tiba di gudang',
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
                        url: '<?= base_url("booking/confirmWarehouse/") ?>', // Ganti dengan URL endpoint Anda
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
        $(document).on('change', '.check_destination', function() {
            let checkbox = $(this);
            let id = checkbox.attr('id').replace('arrDestination_', '');
            let status = checkbox.is(':checked') ? '1' : '0';
            let arr_warehouse = checkbox.data('arr_warehouse');

            // Validasi arr_warehouse sebelum melanjutkan
            if (!arr_warehouse || arr_warehouse === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Resi belum dikonfirmasi tiba di gudang!',
                });
                // Batalkan perubahan checkbox
                checkbox.prop('checked', !checkbox.is(':checked'));
                return; // Berhenti jika arr_warehouse tidak valid
            }

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
                title: 'Konfirmasi tiba di alamat penerima',
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
                        url: '<?= base_url("booking/confirmArrDestination/") ?>', // Ganti dengan URL endpoint Anda
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
</script>