<?php
$first_variant = isset($variants[0]) ? $variants[0] : null;
$product_category = $this->db->where('id', $product['category'])->get('categories')->row_array()['name'];

?>

<section id="selling-product" class="single-product mt-0 mt-md-5">
    <div class="container-fluid">
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="#">Home</a>
            <span class="breadcrumb-item active" aria-current="page"><?= $product['name'] ?></span>
        </nav>
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="row flex-column-reverse flex-lg-row">
                    <div class="col-md-12 col-lg-10 justify-content-center">
                        <!-- product-large-slider -->
                        <div class="swiper product-large-slider">
                            <div class="swiper-wrapper">

                                <?php
                                foreach ($variants as $t) : ?>
                                    <div class="swiper-slide">
                                        <img src="<?= base_url('assets/files/products/thumbnail/' . $t->image) ?>" alt="" class="thumb-image img-fluid">
                                    </div>
                                <?php
                                endforeach; ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <!-- / product-large-slider -->
                        <div class="swiper product-thumbnail-slider">
                            <div class="swiper-wrapper">
                                <?php
                                foreach ($variants as $t) : ?>
                                    <div class="swiper-slide">
                                        <img src="<?= base_url('assets/files/products/thumbnail/' . $t->image) ?>" alt="" class="thumb-image img-fluid">
                                    </div>
                                <?php
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="product-info">
                    <div class="element-header">
                        <h2 itemprop="name" class="display-6"><?= $product['name'] ?></h2>
                        <div class="rating-container d-flex gap-0 align-items-center">
                            <div class="rating" data-rating="1">
                                <svg width="32" height="32" class="text-primary">
                                    <use xlink:href="#star-solid"></use>
                                </svg>
                            </div>
                            <div class="rating" data-rating="2">
                                <svg width="32" height="32" class="text-primary">
                                    <use xlink:href="#star-solid"></use>
                                </svg>
                            </div>
                            <div class="rating" data-rating="3">
                                <svg width="32" height="32" class="text-primary">
                                    <use xlink:href="#star-solid"></use>
                                </svg>
                            </div>
                            <div class="rating" data-rating="4">
                                <svg width="32" height="32" class="text-secondary">
                                    <use xlink:href="#star-solid"></use>
                                </svg>
                            </div>
                            <div class="rating" data-rating="5">
                                <svg width="32" height="32" class="text-secondary">
                                    <use xlink:href="#star-solid"></use>
                                </svg>
                            </div>
                            <span class="rating-count">(3.5)</span>
                        </div>
                    </div>

                    <div class="product-price pt-3 pb-3">
                        <strong class="text-primary display-6 fw-bold">
                            Rp<bdi><?= number_format($first_variant ? $first_variant->variant_price : $product['price']) ?></bdi>
                        </strong>
                        <!-- <del class="ms-2">Rp<bdi>940.00</bdi></del> -->
                    </div>

                    <p><?= $product['descriptions'] ?></p>
                    <div class="cart-wrap py-5">
                        <div class="color-options product-select">
                            <div class="color-toggle" data-option-index="0">
                                <h6 class="item-title text-uppercase text-dark">Variants:</h6>
                                <ul class="select-list list-unstyled d-flex">
                                    <?php foreach ($variants as $i => $v) : ?>
                                        <li class="select-item pe-3 <?= $i == 0 ? 'active' : '' ?>" data-val="<?= $v->variant_name ?>" data-variant-id="<?= $v->id ?>" data-price="<?= $v->variant_price ?>" data-stock="<?= $v->stock ?>">
                                            <a href="#" class="btn btn-light"><?= $v->variant_name ?></a>
                                        </li>
                                    <?php endforeach; ?>

                                </ul>
                            </div>
                        </div>
                        <form action="<?= base_url('order/add') ?>" method="post" id="addToCartForm">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="variant_id" id="variant_id" value="<?= $first_variant ? $first_variant->id : '' ?>">

                            <div class="product-quantity pt-3">
                                <div class="stock-number text-dark">
                                    <em id="stock-display"><?= $first_variant ? $first_variant->stock . ' in stock' : 'Out of stock' ?></em>
                                </div>

                                <div class="stock-button-wrap">
                                    <div class="input-group product-qty" style="max-width: 150px;">
                                        <span class="input-group-btn">
                                            <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus">
                                                <svg width="16" height="16">
                                                    <use xlink:href="#minus"></use>
                                                </svg>
                                            </button>
                                        </span>
                                        <input type="text" id="quantity" name="quantity" class="form-control input-number text-center" value="1" min="1">
                                        <span class="input-group-btn">
                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus">
                                                <svg width="16" height="16">
                                                    <use xlink:href="#plus"></use>
                                                </svg>
                                            </button>
                                        </span>
                                    </div>

                                    <div class="qty-button d-flex flex-wrap pt-3">
                                        <!-- <button type="submit" class="btn btn-primary py-3 px-4 text-uppercase me-3 mt-3">Buy now</button> -->
                                        <button type="submit" id="btnAddToCart" name="add_to_cart" class="btn btn-primary py-3 px-4 text-uppercase mt-3">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="meta-product py-2">
                        <div class="meta-item d-flex align-items-baseline">
                            <h6 class="item-title no-margin pe-2">SKU:</h6>
                            <ul class="select-list list-unstyled d-flex">
                                <li data-value="S" class="select-item"><?= $product['sku'] ?></li>
                            </ul>
                        </div>
                        <div class="meta-item d-flex align-items-baseline">
                            <h6 class="item-title no-margin pe-2">Category:</h6>
                            <ul class="select-list list-unstyled d-flex">
                                <li data-value="S" class="select-item">
                                    <a href="#"><?= $product_category ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-info-tabs py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex flex-column flex-md-row align-items-start gap-5">
                <div class="nav flex-row flex-wrap flex-md-column nav-pills me-3 col-lg-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link text-start active" id="v-pills-description-tab" data-bs-toggle="pill" data-bs-target="#v-pills-description" type="button" role="tab" aria-controls="v-pills-description" aria-selected="true">Description</button>
                    <button class="nav-link text-start" id="v-pills-additional-tab" data-bs-toggle="pill" data-bs-target="#v-pills-additional" type="button" role="tab" aria-controls="v-pills-additional" aria-selected="false">Additional Information</button>
                    <button class="nav-link text-start" id="v-pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reviews" type="button" role="tab" aria-controls="v-pills-reviews" aria-selected="false">Customer Reviews</button>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-description" role="tabpanel" aria-labelledby="v-pills-description-tab" tabindex="0">
                        <h5>Product Description</h5>
                        <p><?= $product['descriptions'] ?></p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-additional" role="tabpanel" aria-labelledby="v-pills-additional-tab" tabindex="0">
                        <p>It is Comfortable and Best</p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-reviews" role="tabpanel" aria-labelledby="v-pills-reviews-tab" tabindex="0">
                        <div class="review-box d-flex flex-wrap">
                            <div class="col-lg-6 d-flex flex-wrap gap-3">
                                <div class="col-md-2">
                                    <div class="image-holder">
                                        <img src="images/reviewer-1.jpg" alt="review" class="img-fluid rounded-circle">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="review-content">
                                        <div class="rating-container d-flex align-items-center">
                                            <div class="rating" data-rating="1">
                                                <svg width="24" height="24" class="text-primary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="2">
                                                <svg width="24" height="24" class="text-primary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="3">
                                                <svg width="24" height="24" class="text-primary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="4">
                                                <svg width="24" height="24" class="text-secondary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="5">
                                                <svg width="24" height="24" class="text-secondary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <span class="rating-count">(3.5)</span>
                                        </div>
                                        <div class="review-header">
                                            <span class="author-name">Tina Johnson</span>
                                            <span class="review-date">– 03/07/2023</span>
                                        </div>
                                        <p>Vitae tortor condimentum lacinia quis vel eros donec ac. Nam at lectus urna duis convallis convallis</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex flex-wrap gap-3">
                                <div class="col-md-2">
                                    <div class="image-holder">
                                        <img src="images/reviewer-2.jpg" alt="review" class="img-fluid rounded-circle">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="review-content">
                                        <div class="rating-container d-flex align-items-center">
                                            <div class="rating" data-rating="1">
                                                <svg width="24" height="24" class="text-primary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="2">
                                                <svg width="24" height="24" class="text-primary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="3">
                                                <svg width="24" height="24" class="text-primary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="4">
                                                <svg width="24" height="24" class="text-secondary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="5">
                                                <svg width="24" height="24" class="text-secondary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <span class="rating-count">(3.5)</span>
                                        </div>
                                        <div class="review-header">
                                            <span class="author-name">Jenny Willis</span>
                                            <span class="review-date">– 03/06/2022</span>
                                        </div>
                                        <p>Vitae tortor condimentum lacinia quis vel eros donec ac. Nam at lectus urna duis convallis convallis</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="add-review mt-5">
                            <h3>Add a review</h3>
                            <p>Your email address will not be published. Required fields are marked *</p>
                            <form id="form" class="form-group">

                                <div class="pb-3">
                                    <div class="review-rating">
                                        <span>Your rating *</span>
                                        <div class="rating-container d-flex align-items-center">
                                            <div class="rating" data-rating="1">
                                                <svg width="24" height="24" class="text-primary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="2">
                                                <svg width="24" height="24" class="text-primary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="3">
                                                <svg width="24" height="24" class="text-primary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="4">
                                                <svg width="24" height="24" class="text-secondary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <div class="rating" data-rating="5">
                                                <svg width="24" height="24" class="text-secondary">
                                                    <use xlink:href="#star-solid"></use>
                                                </svg>
                                            </div>
                                            <span class="rating-count">(3.5)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-3">
                                    <input type="file" class="form-control" data-text="Choose your file">
                                </div>
                                <div class="pb-3">
                                    <label>Your Review *</label>
                                    <textarea class="form-control" placeholder="Write your review here"></textarea>
                                </div>
                                <div class="pb-3">
                                    <label>Your Name *</label>
                                    <input type="text" name="name" placeholder="Write your name here" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label>Your Email *</label>
                                    <input type="text" name="email" placeholder="Write your email here" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label>
                                        <input type="checkbox" required="">
                                        <span class="label-body">Save my name, email, and website in this browser for the next
                                            time.</span>
                                    </label>
                                </div>
                                <button type="submit" name="submit" class="btn btn-dark btn-large text-uppercase w-100">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    const thumbSwiper = new Swiper('.product-thumbnail-slider', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });

    const largeSwiper = new Swiper('.product-large-slider', {
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        thumbs: {
            swiper: thumbSwiper,
        }
    });

    document.querySelectorAll('.select-item').forEach(function(item, index) {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Aktifkan tombol varian yang dipilih
            document.querySelectorAll('.select-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            // Pindah ke gambar sesuai varian
            largeSwiper.slideTo(index);

            // Ambil harga dan stok dari atribut data
            const price = this.dataset.price;
            const stock = this.dataset.stock;

            // Tampilkan harga & stok
            document.querySelector('.product-price bdi').textContent = Number(price).toLocaleString();
            document.querySelector('.stock-number em').textContent = stock + ' in stock';
        });
    });
</script>
<script>
    const btnAddToCart = document.getElementById('btnAddToCart');
    const quantityInput = document.getElementById('quantity');
    const stockDisplay = document.getElementById('stock-display');
    const hiddenVariantInput = document.getElementById('variant_id');

    document.querySelectorAll('.select-item').forEach(function(item, index) {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Aktifkan tombol varian yang dipilih
            document.querySelectorAll('.select-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            // Update slider
            largeSwiper.slideTo(index);

            // Ambil data
            const price = this.dataset.price;
            const stock = parseInt(this.dataset.stock);
            const variantId = this.dataset.variantId;

            // Update tampilan harga dan stok
            document.querySelector('.product-price bdi').textContent = Number(price).toLocaleString();
            stockDisplay.textContent = stock + ' in stock';

            // Simpan varian ke hidden input
            hiddenVariantInput.value = variantId;

            // Enable / disable tombol kalau stok habis
            if (stock <= 0) {
                btnAddToCart.disabled = true;
                btnAddToCart.classList.add('disabled');
            } else {
                btnAddToCart.disabled = false;
                btnAddToCart.classList.remove('disabled');
            }
        });
    });

    // + dan - qty
    document.querySelector('.quantity-left-minus').addEventListener('click', function() {
        let qty = parseInt(quantityInput.value);
        if (qty > 1) quantityInput.value = qty - 1;
    });

    document.querySelector('.quantity-right-plus').addEventListener('click', function() {
        let qty = parseInt(quantityInput.value);
        quantityInput.value = qty + 1;
    });
</script>