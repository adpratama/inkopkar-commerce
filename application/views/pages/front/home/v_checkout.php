<section class="py-5 mb-5">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1 class="page-title pb-2">Checkout</h1>
            <nav class="breadcrumb fs-6">
                <a class="breadcrumb-item nav-link" href="#">Home</a>
                <span class="breadcrumb-item active" aria-current="page">Checkout</span>
            </nav>
        </div>
    </div>
</section>
<section class="shopify-cart checkout-wrap py-5">
    <div class="container-fluid">
        <form method="POST" action="<?= base_url('order/process_order'); ?>">
            <div class="row d-flex flex-wrap">
                <div class="col-lg-6">
                    <h4 class="text-dark pb-4">Billing Details</h4>
                    <div class="billing-details">
                        <label for="fname">Name*</label>
                        <input type="text" id="fname" name="firstname" class="form-control mt-2 mb-4 ps-3" value="<?= $this->session->userdata('full_name') ?>">
                        <label for="phone">Phone *</label>
                        <input type="text" id="phone" name="phone" class="form-control mt-2 mb-4 ps-3" value="<?= $this->session->userdata('phone') ?>">
                        <label for="email">Email address *</label>
                        <input type="text" id="email" name="email" class="form-control mt-2 mb-4 ps-3" value="<?= $this->session->userdata('email') ?>">
                    </div>
                    <h4 class="text-dark pb-4">Additional Information</h4>
                    <div class="billing-details">
                        <label for="notes">Order notes (optional)</label>
                        <textarea name="notes" class="form-control pt-3 pb-3 ps-3 mt-2" placeholder="Notes about your order. Like special notes for delivery."></textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="your-order">
                        <h4 class="text-dark pb-4">Delivery Method</h4>
                        <div class="billing-details delivery-methods">
                            <div id="delivery-address">
                                <label for="">Metode</label>
                                <div class="row mt-3 mb-4">
                                    <div class="col-6">
                                        <label class="list-group-item d-flex gap-2 border-0">
                                            <input class="form-check-input" type="radio" name="delivery_method" value="antar" checked>
                                            Antar ke Alamat
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="list-group-item d-flex gap-2 border-0">
                                            <input class="form-check-input" type="radio" name="delivery_method" value="pickup">
                                            Ambil di Tempat
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="pickup-location" style="display:none;">
                                <label for="pickup_point">Pilih lokasi pengambilan:</label>
                                <select name="pickup_point" id="pickup_point" class="form-control mt-2 mb-4 ps-3">
                                    <option value="store_1">Inkopkar - Tebet</option>
                                </select>
                            </div>

                            <!-- Bungkus label & textarea dalam satu div -->
                            <div id="address-group">
                                <label for="address">Alamat Pengiriman</label>
                                <textarea name="address" class="form-control mt-2 mb-4 ps-3" placeholder="Masukkan alamat lengkap"></textarea>
                            </div>
                        </div>

                        <h4 class="display-7 text-dark pb-4">Cart Totals</h4>
                        <div class="total-price">
                            <table cellspacing="0" class="table">
                                <tbody>
                                    <tr class="subtotal border-top border-bottom pt-2 pb-2 text-uppercase">
                                        <th>Subtotal</th>
                                        <td data-title="Subtotal" class="text-end">
                                            <span class="price-amount amount ps-5">
                                                <bdi>
                                                    <span class="price-currency-symbol">Rp</span><bdi><?= number_format($subtotal, 2) ?></bdi>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="subtotal border-top border-bottom pt-2 pb-2 text-uppercase">
                                        <th>PPn</th>
                                        <td data-title="PPn" class="text-end">
                                            <span class="price-amount amount ps-5">
                                                <bdi>
                                                    <span class="price-currency-symbol">Rp</span><bdi><?= ($ppn) ?></bdi>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="order-total border-bottom pt-2 pb-2 text-uppercase">
                                        <th>Total</th>
                                        <td data-title="Total" class="text-end">
                                            <span class="price-amount amount ps-5 fw-bold">
                                                <bdi>
                                                    <span class="price-currency-symbol">Rp</span><bdi><?= ($grandtotal) ?></bdi>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="list-group mt-5 mb-3">
                                <label class="list-group-item d-flex gap-2 border-0">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="payment_method" value="transfer" checked>
                                    <span>
                                        <strong class="text-uppercase">Direct bank transfer</strong>
                                        <small class="d-block text-body-secondary">Make your payment directly into our bank account.</small>
                                    </span>
                                </label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-dark btn-lg text-uppercase btn-rounded-none w-100">Place an order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
    document.querySelectorAll('input[name="delivery_method"]').forEach(input => {
        input.addEventListener('change', function() {
            const addressField = document.querySelector('textarea[name="address"]');

            if (this.value === 'pickup') {
                document.getElementById('pickup-location').style.display = 'block';
                document.getElementById('address-group').style.display = 'none';
                addressField.removeAttribute('required');
            } else {
                document.getElementById('pickup-location').style.display = 'none';
                document.getElementById('address-group').style.display = 'block';
                addressField.setAttribute('required', 'required');
            }
        });
    });
</script>