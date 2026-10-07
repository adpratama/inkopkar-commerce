<section class="py-5 mb-5">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1 class="page-title pb-2">Cart</h1>
            <nav class="breadcrumb fs-6">
                <a class="breadcrumb-item nav-link" href="#">Home</a>
                <span class="breadcrumb-item active" aria-current="page">Cart</span>
            </nav>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container-fluid">
        <div class="row g-5">
            <div class="col-md-8">
                <div class="d-none d-md-block">
                    <div class="table-responsive cart">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-sm btn-primary" id="toggle-select-all">All</button>
                                    </th>
                                    <th scope="col" class="card-title text-uppercase text-muted w-50">Product</th>
                                    <th scope="col" class="card-title text-uppercase text-muted" style="width: 34%;">Quantity</th>
                                    <th scope="col" class="card-title text-uppercase text-muted">Subtotal</th>
                                    <th scope="col" class="card-title text-uppercase text-muted"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <form action="<?= base_url('home/update_cart') ?>" method="post" id="cart-form">
                                    <?php
                                    $subtotal = 0;

                                    if ($list_cart) : ?>
                                        <?php foreach ($list_cart as $l) : ?>
                                            <tr>
                                                <td class="text-center py-4">
                                                    <input type="checkbox" name="selected_items[]" value="<?= $l->cart_id ?>" class="select-item">
                                                </td>

                                                <td scope="row" class="py-3">
                                                    <div class="cart-info d-flex flex-wrap align-items-center mb-4">
                                                        <div class="col-lg-3">
                                                            <div class="card-image">
                                                                <img src="<?= base_url('assets/files/products/thumbnail/' . $l->variant_image) ?>" alt="cloth" class="img-fluid">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="card-detail ps-3">
                                                                <h5 class="card-title">
                                                                    <a href="#" class="text-decoration-none"><?= $l->name ?></a>
                                                                </h5>

                                                                <small class="text-body-secondary"><?= htmlspecialchars($l->variant_name) ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="input-group product-cart-qty w-50 align-items-center">
                                                        <input type="hidden" name="cart[<?= $l->cart_id ?>][id]" value="<?= $l->cart_id ?>">
                                                        <input type="hidden" name="cart[<?= $l->cart_id ?>][product_id]" value="<?= $l->product_id ?>">

                                                        <span class="input-group-btn">
                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number cart-left-minus" data-type="minus">
                                                                <svg width="16" height="16">
                                                                    <use xlink:href="#minus"></use>
                                                                </svg>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="cart[<?= $l->cart_id ?>][qty]" class="form-control input-number text-center cart-quantity" value="<?= $l->quantity ?>" data-id="<?= $l->cart_id ?>">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number cart-right-plus" data-type="plus">
                                                                <svg width="16" height="16">
                                                                    <use xlink:href="#plus"></use>
                                                                </svg>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="total-price-item text-end" data-id="<?= $l->cart_id ?>">
                                                        <span class="money text-dark subtotal-value" data-subtotal="<?= $l->subtotal ?>">Rp<?= number_format($l->subtotal) ?></span>
                                                    </div>
                                                </td>

                                                <td class="py-3">
                                                    <div class="cart-remove">
                                                        <a href="javascript:void(0);" class="remove-item" data-rowid="<?= $l->cart_id ?>">
                                                            <svg width="24" height="24">
                                                                <use xlink:href="#trash"></use>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach;

                                        $subtotal = array_sum(array_column($list_cart, 'subtotal')); ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="3">Keranjang kosong</td>
                                        </tr>
                                    <?php endif; ?>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cart-totals bg-grey py-5">
                    <h4 class="text-dark pb-4">Cart Total</h4>
                    <div class="total-price pb-5">
                        <table cellspacing="0" class="table text-uppercase">
                            <tbody>
                                <tr class="subtotal pt-2 pb-2 border-top border-bottom">
                                    <th>Subtotal</th>
                                    <td data-title="Subtotal" class="text-end">
                                        <span class="price-amount amount text-dark ps-5">
                                            <bdi>
                                                <span class="price-currency-symbol">Rp </span><span id="subtotal-val">0</span>
                                            </bdi>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="button-wrap row g-2">
                        <div class="col-md-12"><button class="btn btn-dark py-3 px-4 text-uppercase btn-rounded-none w-100 h-100" onclick="document.location='<?= base_url() ?>'">Continue Shopping</button></div>
                        <!-- Tombol Proceed to Checkout -->
                        <div class="col-md-12">
                            <form action="<?= base_url('home/checkout') ?>" method="post" id="checkout-form">
                                <input type="hidden" name="selected_items[]" value="" id="dummy-selected"> <!-- biar gak error kalau kosong -->
                                <button type="submit" class="btn btn-primary py-3 px-4 text-uppercase btn-rounded-none w-100" id="btn-checkout" disabled>
                                    Proceed to checkout
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.select-item');
        const btnCheckout = document.getElementById('btn-checkout');
        const subtotalDisplay = document.getElementById('subtotal-val');
        const form = document.getElementById('checkout-form');

        function updateSummary() {
            let total = 0;
            let selected = 0;

            // Hapus semua input hidden sebelumnya (kecuali dummy)
            form.querySelectorAll('input[name="selected_items[]"]:not(#dummy-selected)').forEach(i => i.remove());

            checkboxes.forEach((cb, index) => {
                if (cb.checked) {
                    const row = cb.closest('tr');
                    const subtotal = parseFloat(row.querySelector('.subtotal-value').dataset.subtotal || 0);
                    total += subtotal;
                    selected++;

                    // Tambahkan input hidden ke form
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'selected_items[]';
                    hidden.value = cb.value;
                    form.appendChild(hidden);
                }
            });

            subtotalDisplay.innerText = total.toLocaleString('id-ID');
            btnCheckout.disabled = selected === 0;
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateSummary));

        // Trigger awal
        updateSummary();

        const toggleBtn = document.getElementById('toggle-select-all');

        toggleBtn.addEventListener('click', function() {
            const totalCheckbox = checkboxes.length;
            const checkedCheckbox = [...checkboxes].filter(cb => cb.checked).length;

            const shouldCheck = checkedCheckbox < totalCheckbox; // jika belum semua tercentang
            checkboxes.forEach(cb => cb.checked = shouldCheck);
            updateSummary();

            toggleBtn.innerText = shouldCheck ? 'Uncheck Semua' : 'Pilih Semua';
        });

        const checkedCount = [...checkboxes].filter(cb => cb.checked).length;
        toggleBtn.innerText = (checkedCount === checkboxes.length) ? 'Uncheck Semua' : 'Pilih Semua';

    });
</script>