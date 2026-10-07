<?php
foreach ($products as $p) :
    $getPrice = $this->db->select('variant_price')->where('product_id', $p->id)->get('product_variants')->row_array();
?>
    <?= form_open('order/add'); ?>
    <?= form_hidden('id', $p->product_id); ?>
    <?= form_hidden('price', $p->price); ?>
    <?= form_hidden('product_name', $p->product_name); ?>
    <?= form_hidden('redirect', current_url()); ?>

    <div class="col">
        <div class="product-item">
            <!-- <span class="badge bg-success position-absolute m-3">-30%</span> -->
            <a href="#" class="btn-wishlist">
                <svg width="24" height="24">
                    <use xlink:href="#heart"></use>
                </svg>
            </a>
            <figure>
                <a href="<?= base_url('home/product/' . $p->slug) ?>" title="<?= $p->product_name ?>">
                    <img src="<?= base_url() ?>assets/files/products/<?= $p->image ?>" class="tab-image">
                </a>
            </figure>

            <a href="<?= base_url('home/product/' . $p->slug) ?>" title="<?= $p->product_name ?>" style="text-decoration: none">
                <h3><?= $p->product_name ?></h3>
            </a>
            <span class="qty">1 Unit</span>
            <span class="rating"><svg width="24" height="24" class="text-primary">
                    <use xlink:href="#star-solid"></use>
                </svg> 4.5</span>
            <span class="price text-end">Rp<?= number_format($getPrice['variant_price']) ?></span>

            <!-- <div class="d-flex align-items-center justify-content-between">
                <div class="input-group product-qty align-items-center">
                    <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus" data-id="<?= $p->product_id ?>">
                        <svg width="16" height="16">
                            <use xlink:href="#minus"></use>
                        </svg>
                    </button>

                    <input type="text" id="quantity-<?= $p->product_id ?>" name="quantity" class="form-control input-number" value="1">

                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-id="<?= $p->product_id ?>">
                        <svg width="16" height="16">
                            <use xlink:href="#plus"></use>
                        </svg>
                    </button>
                </div>

                <button type="submit" class="nav-link add-to-cart-btn">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></button>
            </div> -->
        </div>
    </div>

    <?= form_close(); ?>
<?php endforeach; ?>