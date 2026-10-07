(function ($) {

  "use strict";

  var initPreloader = function () {
    $(document).ready(function ($) {
      var Body = $('body');
      Body.addClass('preloader-site');
    });
    $(window).load(function () {
      $('.preloader-wrapper').fadeOut();
      $('body').removeClass('preloader-site');
    });
  }

  // init Chocolat light box
  var initChocolat = function () {
    Chocolat(document.querySelectorAll('.image-link'), {
      imageSize: 'contain',
      loop: true,
    })
  }

  var initSwiper = function () {

    var swiper = new Swiper(".main-swiper", {
      speed: 500,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

    var category_swiper = new Swiper(".category-carousel", {
      slidesPerView: 6,
      spaceBetween: 30,
      speed: 500,
      navigation: {
        nextEl: ".category-carousel-next",
        prevEl: ".category-carousel-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 4,
        },
        1500: {
          slidesPerView: 6,
        },
      }
    });

    var brand_swiper = new Swiper(".brand-carousel", {
      slidesPerView: 4,
      spaceBetween: 30,
      speed: 500,
      navigation: {
        nextEl: ".brand-carousel-next",
        prevEl: ".brand-carousel-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 2,
        },
        991: {
          slidesPerView: 3,
        },
        1500: {
          slidesPerView: 4,
        },
      }
    });

    var products_swiper = new Swiper(".products-carousel", {
      slidesPerView: 5,
      spaceBetween: 30,
      speed: 500,
      navigation: {
        nextEl: ".products-carousel-next",
        prevEl: ".products-carousel-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 4,
        },
        1500: {
          slidesPerView: 6,
        },
      }
    });
  }

  var initProductQty = function () {
    $(".product-qty").each(function () {
      var $el_product = $(this);

      // Tombol Plus (+)
      $el_product.find(".quantity-right-plus").click(function (e) {
        e.preventDefault();
        let $quantityInput = $el_product.find('input[name="quantity"]');
        let quantity = parseInt($quantityInput.val());
        $quantityInput.val(quantity + 1);
      });

      // Tombol Minus (-)
      $el_product.find(".quantity-left-minus").click(function (e) {
        e.preventDefault();
        let $quantityInput = $el_product.find('input[name="quantity"]');
        let quantity = parseInt($quantityInput.val());
        if (quantity > 1) {
          $quantityInput.val(quantity - 1);
        }
      });
    });
  };

  // init jarallax parallax
  var initJarallax = function () {
    jarallax(document.querySelectorAll(".jarallax"));

    jarallax(document.querySelectorAll(".jarallax-keep-img"), {
      keepImg: true,
    });
  }

  // document ready
  $(document).ready(function () {

    initPreloader();
    initSwiper();
    initProductQty();
    initJarallax();
    initChocolat();

  }); // End of a document

})(jQuery);

const flashdata = $(".flash-data").data("flashdata");
if (flashdata) {
  Swal.fire({
    title: "Success!! ",
    text: flashdata,
    icon: "success",
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  });
}

const flashdata_error = $(".flash-data-error").data("flashdata");
if (flashdata_error) {
  Swal.fire({
    title: "Error!! ",
    text: flashdata_error,
    icon: "error",
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  });
}

const flashdata_warning = $(".flash-data-warning").data("flashdata");
if (flashdata_warning) {
  Swal.fire({
    title: "Warning!! ",
    text: flashdata_warning,
    icon: "warning",
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  });
}

$(document).on('click', '.add-to-cart-btn', function (e) {
  e.preventDefault();

  let form = $(this).closest('form');
  let productData = {
    id: form.find('input[name="id"]').val(),
    price: form.find('input[name="price"]').val(),
    product_name: form.find('input[name="product_name"]').val(),
    redirect: form.find('input[name="redirect"]').val()
  };

  $.ajax({
    url: base_url + 'home/check_login',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response.status === 'not_logged_in') {
        // Simpan data produk di session storage (sementara)
        sessionStorage.setItem('temp_cart_item', JSON.stringify(productData));

        // Tampilkan modal login
        $('#loginModal').modal('show');
      } else {
        // Jika sudah login, langsung submit form
        form.submit();
      }
    }
  });
});

$('#loginModal').on('hidden.bs.modal', function () {
  let tempCartItem = sessionStorage.getItem('temp_cart_item');
  if (tempCartItem) {
    sessionStorage.removeItem('temp_cart_item'); // Hapus setelah login
    window.location.href = base_url + 'home/cart'; // Redirect ke cart
  }
});

$('#loginForm').on('submit', function (e) {
  e.preventDefault();

  $.ajax({
    url: base_url + 'auth/ajax_login',
    type: 'POST',
    data: $(this).serialize(),
    dataType: 'json',
    success: function (response) {
      if (response.status === 'success') {
        $('#loginModal').modal('hide');
        window.location.href = base_url;
      } else {
        $('#loginMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
      }
    }
  });
});

$(document).on('click', '.cart-left-minus, .cart-right-plus', function (e) {
  e.preventDefault();
  let input = $(this).closest('.product-cart-qty').find('.cart-quantity');
  let newQty = parseInt(input.val());
  let productId = input.data("id");

  // Tambahin loading indicator kecil
  let priceElement = $(`.total-price-item[data-id="${productId}"] .money`);
  priceElement.html("<small>Updating...</small>");

  // Ubah qty
  if ($(this).hasClass('cart-right-plus')) {
    newQty += 1;
  } else if (newQty > 1) {
    newQty -= 1;
  }

  input.val(newQty);

  // Kirim update via AJAX
  $.ajax({
    url: base_url + "home/update_cart",
    type: "POST",
    data: {
      cart: {
        [productId]: {
          id: productId,
          qty: newQty,
        },
      },
    },
    success: function (response) {
      try {
        let res = JSON.parse(response);

        if (res.status === "success") {
          // console.log("Cart updated:", res);

          // Update qty di input
          input.val(newQty);

          // Update subtotal item
          priceElement.html("Rp" + res.item_subtotal);

          // Update grand total cart
          $(".subtotal .price-amount").text("Rp" + res.new_total);
          $(".cart .cart-total").text("Rp" + res.new_total);
          // $(".order-total .price-amount").text("Rp" + res.new_total);

          updateOffcanvasCart();

          // Animasi biar smooth
          $(".cart-info").addClass("animate__animated animate__pulse");
          setTimeout(() => $(".cart-info").removeClass("animate__animated animate__pulse"), 500);
        } else {
          priceElement.html("Rp0");
          console.warn("Cart update failed!");
        }
      } catch (error) {
        console.error("JSON parse error:", error, response);
        alert("Terjadi kesalahan saat memperbarui cart!");
      }
    },
    error: function () {
      alert("Gagal update cart!");
    },
  });
});

function updateOffcanvasCart() {
  $.get(base_url + "home/get_cart_data", function (data) {
    let res = JSON.parse(data);

    // Update list cart di offcanvas
    let cartHTML = "";
    res.list_cart.forEach((item) => {
      cartHTML += `
        <li class="list-group-item d-flex justify-content-between lh-sm">
          <div>
            <h6 class="my-0">${item.product_name}</h6>
            <small class="text-body-secondary">${item.quantity} piece(s)</small>
          </div>
          <span class="text-body-secondary">Rp${new Intl.NumberFormat().format(item.subtotal)}</span>
        </li>
      `;
    });

    // Update total di offcanvas
    cartHTML += `
      <li class="list-group-item d-flex justify-content-between">
        <span>Total (IDR)</span>
        <strong>Rp${new Intl.NumberFormat().format(res.total)}</strong>
      </li>
    `;

    $(".offcanvas-body .list-group").html(cartHTML);
  });
}



$(document).on("click", ".remove-item", function (e) {
  e.preventDefault();

  let id = $(this).data("rowid");

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, remove it!",
  }).then((result) => {
    if (result.isConfirmed) {
      console.log("Removing item with ID:", id);

      $.ajax({
        url: base_url + "home/remove_item",
        type: "POST",
        data: { id: id },
        success: function (response) {
          let res = JSON.parse(response);

          if (res.status === "success") {
            // Animasi fadeOut row cart
            $(`.remove-item[data-rowid="${id}"]`).closest("tr").fadeOut(300, function () {
              $(this).remove();

              // Update total cart dan offcanvas setelah item hilang
              // $(".order-total .price-amount").text("Rp" + new Intl.NumberFormat().format(res.new_total));
              $(".subtotal .price-amount").text("Rp" + res.new_total);
              $(".cart .cart-total").text("Rp" + res.new_total);

              // Update badge cart di navbar & offcanvas
              $(".badge.bg-primary").text(res.count_cart);

              // Kalau cart kosong, munculin info
              if (res.count_cart == 0) {
                $("tbody").html('<tr><td colspan="3">Keranjang kosong</td></tr>');
                $(".offcanvas-body .list-group").html('<li class="list-group-item">Your cart is empty</li>');
              } else {
                // Refresh data di offcanvas cart
                updateOffcanvasCart();
              }

              // SweetAlert info berhasil remove
              Swal.fire("Deleted!", "Your item has been removed.", "success");
            });
          }
        },
        error: function () {
          Swal.fire("Error!", "Failed to remove item.", "error");
        },
      });
    }
  });
});


$(".btn-confirm").on("click", function (e) {
  e.preventDefault();
  const form = $(this).parents("form");

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, confirm!",
  }).then((result) => {
    if (result.isConfirmed) form.submit();
  });
});

$(".btn-logout").on("click", function (e) {
  e.preventDefault();
  const href = $(this).attr("href");

  Swal.fire({
    title: "Are you sure?",
    // text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, sign me out!",
  }).then((result) => {
    if (result.isConfirmed) {

      Swal.fire({
        title: "Loading...",
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });
      document.location.href = href;
    }
  });
});

