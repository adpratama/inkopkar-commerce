<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(['session', 'form_validation']);
		$this->load->helper(['string', 'date']);
		$this->load->model(['M_Auth', 'M_Product', 'M_Cart']);

		if ($this->session->userdata('is_logged_in')) {
			$this->session->set_userdata('last_page', current_url());
		}

		$this->count_cart = $this->M_Cart->get_count_cart();
		$this->list_cart = $this->M_Cart->get_list_cart();
	}

	public function index()
	{
		$categories = $this->M_Product->getCategories();

		$products_by_category = [];
		foreach ($categories as $c) {
			$products_by_category[$c->slug] = $this->M_Product->getProductsByCategory($c->id);
		}

		$data = [
			'title' => 'Home',
			'segment' => 'home',
			'pages' => 'pages/front/home/v_home',
			'categories' => $categories,
			'products' => $this->M_Product->getProducts(),
			'count_cart' => $this->count_cart,
			'list_cart' => $this->list_cart,
			'products_by_category' => $products_by_category,
		];

		$this->load->view('pages/front/index', $data);
	}

	public function product($slug)
	{
		$product = $this->M_Product->show($slug);
		if (!$product) {
			$this->session->set_flashdata('message_warning', 'Product tidak ditemukan!');
			redirect('home');
		}

		$thumbnails = $this->M_Product->showProductThumbnail($product['id']);
		$variants = $this->M_Product->showProductVariant($product['id']);


		$categories = $this->M_Product->getCategories();

		// echo '<pre>';
		// print_r($variants);
		// echo '</pre>';
		// exit;
		$data = [
			'title' => $product['name'],
			'product' => $product,
			'categories' => $categories,
			'thumbnails' => $thumbnails,
			'variants' => $variants,
			'segment' => 'product',
			'pages' => 'pages/front/home/partials/product_detail',
			'count_cart' => $this->count_cart,
			'list_cart' => $this->list_cart,
		];

		$this->load->view('pages/front/index', $data);
	}

	public function cart()
	{
		if (!$this->session->userdata('is_logged_in')) {
			$this->session->set_flashdata('message_warning', 'Harap login terlebih dahulu!');
			redirect('home');
		}

		$data = [
			'title' => 'Cart',
			'segment' => 'cart',
			'pages' => 'pages/front/home/v_cart',
			'count_cart' => $this->count_cart,
			'list_cart' => $this->list_cart,
		];

		$this->load->view('pages/front/index', $data);
	}

	public function wishlist()
	{
		if (!$this->session->userdata('is_logged_in')) {
			$this->session->set_flashdata('message_warning', 'Harap login terlebih dahulu!');
			redirect('home');
		}

		$data = [
			'title' => 'Service',
			'segment' => 'service',
			'pages' => 'pages/front/home/v_service'
		];

		$this->load->view('pages/front/index', $data);
	}

	public function update_cart()
	{
		$cart = $this->input->post('cart');
		$productId = key($cart);
		$qty = $cart[$productId]['qty'];

		if ($this->session->userdata('is_logged_in')) {
			$user_id = $this->session->userdata('user_id');

			// Loop tiap item di cart dan update
			foreach ($cart as $id => $item) {
				$this->M_Cart->update_item($user_id, $id, $item['qty']);
			}
		} else {
			// Handle cart tanpa login (guest mode)
			$this->cart->update([
				'rowid' => $productId,
				'qty' => $qty
			]);
		}

		// Ambil ulang data item dan total cart
		$item = $this->M_Cart->getCartItemById($productId);
		$cart = $this->M_Cart->get_list_cart();
		$total = array_sum(array_column($cart, 'subtotal'));

		// Pastikan JSON aman & proper
		echo json_encode([
			'status' => 'success',
			'item_id' => $productId,
			'item_subtotal' => number_format($item['subtotal']),
			'new_total' => number_format($total)
		]);
	}

	public function get_cart_data()
	{
		$count_cart = $this->M_Cart->get_count_cart();
		$list_cart = $this->M_Cart->get_list_cart();
		$subtotal = array_sum(array_column($list_cart, 'subtotal'));

		echo json_encode([
			'count_cart' => $count_cart,
			'list_cart' => $list_cart,
			'new_total' => number_format($subtotal)
		]);
	}

	public function remove_item()
	{
		$id = $this->input->post('id');
		$user_id = $this->session->userdata('user_id');

		// Hapus item di DB / session cart
		$this->M_Cart->remove_item($user_id, $id);

		// Ambil ulang data cart
		$cart = $this->M_Cart->get_list_cart();
		$total = array_sum(array_column($cart, 'subtotal'));
		$count_cart = $this->M_Cart->get_count_cart();

		echo json_encode([
			"status" => "success",
			"new_total" => number_format($total),
			"count_cart" => $count_cart,
		]);
	}

	public function check_login()
	{
		// Cek apakah user sudah login
		if (!$this->session->userdata('is_logged_in')) {
			echo json_encode(['status' => 'not_logged_in']);
		} else {
			echo json_encode(['status' => 'logged_in']);
		}
	}

	public function checkout()
	{
		$selected = $this->input->post('selected_items');

		if (!$selected) {
			$this->session->set_flashdata('message_error', 'Pilih produk terlebih dahulu untuk checkout.');
			redirect('home/cart');
		}

		$cart_content = $this->M_Cart->get_selected_cart($selected);

		if (empty($cart_content)) {
			redirect('home/cart');
		}

		$categories = $this->M_Product->getCategories();
		$jml_item = 0;

		foreach ($cart_content as $c) {
			$jml_item += $c->quantity;
		}

		$subtotal = array_sum(array_column($cart_content, 'subtotal'));
		$ppn = $subtotal * 0.1;
		$grandtotal = $subtotal + $ppn;

		// Simpan ke session sementara
		$this->session->set_userdata('selected_cart_ids', $selected);

		$data = [
			'title' => 'Checkout',
			'pages' => 'pages/front/home/v_checkout',
			'cart_content' => $cart_content,
			'categories' => $categories,
			'jml_item' => $jml_item,
			'subtotal' => $subtotal,
			'ppn' => number_format($ppn, 2, ',', '.'),
			'grandtotal' => number_format($grandtotal, 2, ',', '.')
		];

		$this->load->view('pages/front/index', $data);
	}


	public function orders()
	{
		$data = [
			'title' => 'My Orders',
			'segment' => 'order',
			'pages' => 'pages/front/home/v_order',
			'count_cart' => $this->count_cart,
			'list_cart' => $this->list_cart,
			'orders' => $this->M_Cart->getOrder(),
		];

		$this->load->view('pages/front/index', $data);
	}
}
