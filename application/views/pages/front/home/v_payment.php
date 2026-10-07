<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?> - Inkopkar</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="<?= base_url() ?>assets/logo/logo.gif" rel="icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/front/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/front/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

</head>

<body>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_success') ?>"></div>
    <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('message_error') ?>"></div>
    <div class="flash-data-warning" data-flashdata="<?= $this->session->flashdata('message_warning') ?>"></div>
    <div class="error-page content-light d-flex align-items-center" style="height: 100vh; background: url(<?= base_url('assets/front/images/background-pattern.jpg'); ?>);">
        <div class="container">
            <div class="page-content text-center">
                <img src="<?= base_url('assets/logo/logo.gif') ?>" alt="Logo Inkopkar" class="w-10 mb-5">
                <?php if ($order) { ?>
                    <h1>Payment for Order</h1>
                    <h5>#<?= $order['no_order']; ?></h5>
                    <p>Please proceed with the payment for your order.</p>
                    <p class="fw-bold">Mohon untuk transfer ke rekening <strong>BNI 1148254122</strong> sebesar</p>
                    <h3><strong id="totalAmount">Rp <?= number_format($order['total']); ?></strong><button class="btn btn-sm btn-outline-secondary ms-2" id="copyAmount" title="Copy Nominal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                            </svg>
                        </button></h3>

                    <p>
                        <small id="copyMessage" class="text-success d-none">Nominal berhasil disalin!</small>
                    </p>

                    <?php if ($order['order_status'] == "pending") { ?>
                        <button class="btn btn-primary btn-lg text-uppercase mt-3" data-bs-toggle="modal" data-bs-target="#modalUploadBukti">Upload bukti bayar</button>

                        <div class="modal fade" id="modalUploadBukti" tabindex="-1" aria-labelledby="modalUploadBuktiLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow-lg border-0 rounded-4">
                                    <div class="modal-body p-5 rounded-4">
                                        <img src="<?= base_url('assets/logo/logo.gif') ?>" alt="Logo Inkopkar" class="w-25 mb-3">
                                        <h5 class="text-uppercase mb-4">Upload bukti bayar</h5>

                                        <form id="uploadForm" class="form-group flex-wrap" method="POST" action="<?= base_url('order/upload_bukti/' . $order_id) ?>" enctype="multipart/form-data">
                                            <div class="col-12 pb-3">
                                                <input type="file" class="form-control" name="file" id="file" accept="image/*" required>
                                            </div>
                                            <div class="col-12 text-center mb-3">
                                                <img id="previewImage" src="#" alt="Preview Bukti Bayar" class="d-none rounded-3 shadow-sm" style="max-width: 100%; height: auto;">
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" name="submit" class="btn btn-primary text-uppercase w-100">Upload</button>
                                            </div>
                                        </form>

                                        <div id="loginMessage" class="mt-3 text-center text-danger"></div>

                                        <div class="text-center mt-4">
                                            <button type="button" class="btn-close btn-close-black rounded-5 text-center p-3 border border-black" data-bs-dismiss="modal" aria-label="Close" title="Close modal"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <h1 class="">Order Tidak Ditemukan</h1>
                    <p>Order yang Anda cari mungkin sudah diproses, dihapus, atau nomor order tidak valid.</p>
                    <a href="<?= base_url('orders/history') ?>" class="btn btn-secondary btn-lg text-uppercase mt-3">Cek Riwayat Order</a>
                    <a href="<?= base_url() ?>" class="btn btn-primary btn-lg text-uppercase mt-3">Kembali ke Beranda</a>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/front/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/front/js/plugins.js"></script>
    <script src="<?= base_url() ?>assets/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/front/js/script.js"></script>
    <script>
        document.getElementById('file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none'); // Tampilkan gambar
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.classList.add('d-none'); // Sembunyikan gambar jika tidak ada file
            }
        });

        // Fungsi untuk copy nominal pembayaran
        document.getElementById("copyAmount").addEventListener("click", function() {
            var totalAmount = document.getElementById("totalAmount").innerText.trim();
            var tempInput = document.createElement("input");
            document.body.appendChild(tempInput);
            tempInput.value = totalAmount.replace("Rp ", "").replace(/,/g, ''); // Hilangkan Rp dan format angka
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            // Tampilkan pesan sukses
            var copyMessage = document.getElementById("copyMessage");
            copyMessage.classList.remove("d-none");
            setTimeout(() => {
                copyMessage.classList.add("d-none");
            }, 2000);
        });
    </script>
</body>