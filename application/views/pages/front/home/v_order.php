<section class="py-5 mb-5">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1 class="page-title pb-2">My Orders</h1>
            <nav class="breadcrumb fs-6">
                <a class="breadcrumb-item nav-link" href="#">Home</a>
                <span class="breadcrumb-item active" aria-current="page">My Order</span>
            </nav>
        </div>
    </div>
</section>
<section class="my-5">
    <div class="container-fluid">

        <div class="row my-3">
            <!-- Tampilan Tabel untuk Desktop -->
            <div class="d-none d-md-block">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Order #</th>
                            <th scope="col">Date</th>
                            <th scope="col">Total</th>
                            <th scope="col">Delivery Method</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($orders as $o) : ?>
                            <tr>
                                <td><?= $o->no_order ?></td>
                                <td><?= format_indo($o->created_at) ?></td>
                                <td class="text-end">Rp <?= number_format($o->total) ?></td>
                                <td><?= ucwords($o->delivery_method) ?></td>
                                <td><span class="badge bg-primary"><?= ucwords($o->order_status) ?></span></td>
                                <td>
                                    <?php if ($o->order_status == 'dikirim' && $o->delivery_method == 'antar') { ?>
                                        <form method="POST" action="<?= base_url('order/confirm_received') ?>">
                                            <input type="hidden" name="order_id" value="<?= $o->id ?>">
                                            <button type="submit" class="btn btn-success btn-sm btn-confirm">Pesanan Diterima</button>
                                        </form>
                                    <?php } ?>

                                </td>
                            </tr>
                        <?php
                        endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tampilan Card untuk Mobile -->
            <div class="d-block d-md-none">
                <?php
                foreach ($orders as $o) : ?>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="w-75 p-1" colspan="2">
                                            <strong><?= $o->no_order ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-1"><?= format_indo($o->created_at) ?></td>
                                        <td class="text-end p-1"><span class="badge bg-primary"><?= ucwords($o->order_status) ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="p-1"><strong>Rp <?= number_format($o->total) ?></strong></td>
                                        <td class="text-end p-1">
                                            <a href="#" class="btn btn-dark btn-sm">View Details</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php
                endforeach; ?>
            </div>
        </div>
    </div>
</section>