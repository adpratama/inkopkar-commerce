<table class="table">
    <tr>
        <th class="w-25">No. Order</th>
        <td class="w-25"><?= $order->no_order ?></td>
        <th rowspan="4">
            <label for="Bukti" class="form-label">Bukti pembayaran</label>
            <img src="<?= base_url('assets/files/bukti-bayar/' . $order->bukti_bayar) ?>" alt="" class="img-fluid">
        </th>
    </tr>
    <tr>
        <th class="w-25">Nama Pemesan</th>
        <td><?= $order->order_name ?></td>
    </tr>
    <tr>
        <th>Metode Pengiriman</th>
        <td><?= ucfirst($order->delivery_method) ?></td>
    </tr>
    <?php if ($order->delivery_method == 'pickup') : ?>
        <tr>
            <th>Pickup Point</th>
            <td><?= $order->pickup_point ?></td>
        </tr>
    <?php else : ?>
        <tr>
            <th>Alamat Pengiriman</th>
            <td><?= $order->address ?></td>
        </tr>
    <?php endif; ?>

    <tr>
        <th>Total</th>
        <td><?= number_format($order->total) ?></td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            <span class="badge bg-<?= ($order->order_status == 'belum bayar') ? 'yellow' : 'lime' ?>">
                <?= ucfirst($order->order_status) ?>
            </span>
        </td>
    </tr>
</table>
<div class="row">
    <div class="col-12 text-end">
        <?php
        if ($order->order_status == "menunggu konfirmasi") { ?>
            <button type="button" class="btn btn-success processOrder" data-id="<?= $order->id ?>">Konfirmasi pembayaran dan proses pesanan</button>
        <?php }

        if ($order->order_status == "diproses" && $order->delivery_method == "antar") { ?>
            <button type="button" class="btn btn-success btn-send-order" data-id="<?= $order->id ?>" data-noorder="<?= $order->no_order ?>">
                Kirim Pesanan
            </button>
        <?php } else if ($order->order_status == "diproses" && $order->delivery_method == "pickup") { ?>
            <button type="button" class="btn btn-success pickupDone" data-id="<?= $order->id ?>">
                Tandai Sudah Diambil
            </button>
        <?php } ?>

    </div>
</div>