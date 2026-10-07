<?php
defined('BASEPATH') or exit('No direct script access allowed');

// date_default_timezone_set('Asia/Jakarta');

class Order extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['Api_Whatsapp', 'pagination']);
        $this->load->helper(['string', 'date', 'form', 'cookie']);
        $this->load->model(['M_Product', 'M_Cart']);
    }

    public function index()
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('home');
        }

        $keyword = ($this->input->post('keyword')) ? trim($this->input->post('keyword')) : (($this->session->userdata('search_order_keyword')) ? $this->session->userdata('search_order_keyword') : '');
        if ($keyword === null) $keyword = $this->session->userdata('search_order_keyword');
        else $this->session->set_userdata('search_order_keyword', $keyword);

        $status = ($this->input->post('status')) ? trim($this->input->post('status')) : (($this->session->userdata('search_order_status')) ? $this->session->userdata('search_order_status') : '');
        if ($status === null) $status = $this->session->userdata('search_order_status');
        else $this->session->set_userdata('search_order_status', $status);

        $tanggal = ($this->input->post('tanggal')) ? trim($this->input->post('tanggal')) : (($this->session->userdata('search_order_tanggal')) ? $this->session->userdata('search_order_tanggal') : '');
        if ($tanggal === null) $tanggal = $this->session->userdata('search_order_tanggal');
        else $this->session->set_userdata('search_order_tanggal', $tanggal);

        $config = [
            'base_url' => site_url('order/index'),
            'total_rows' => $this->M_Cart->count($keyword, $status, $tanggal),
            'per_page' => 10,
            'uri_segment' => 3,
            'num_links' => 1,
            'full_tag_open' => '<ul class="pagination m-0 ms-auto">',
            'full_tag_close' => '</ul>',

            'prev_link' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg> prev',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
            'prev_tag_open_disabled' => '<li class="page-item disabled">',
            'prev_tag_close_disabled' => '</li>',

            'next_link' => 'next <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M9 6l6 6l-6 6" /></svg>',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'next_tag_open_disabled' => '<li class="page-item disabled">',
            'next_tag_close_disabled' => '</li>',

            'first_link' => 'First',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',

            'last_link' => 'Last',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',

            'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
            'cur_tag_close' => '</a></li>',

            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',

            'attributes' => array('class' => 'page-link'),

            'use_page_numbers' => TRUE,
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? ($this->uri->segment(3) - 1) * $config['per_page'] : 0;

        $data = [
            "title" => "Order",
            "page" => $page,
            "keyword" => $keyword,
            "status" => $status,
            "tanggal" => $tanggal,
            "segment" => "order",
            "pages" => "pages/order/v_order",
            "orders" => "",
            // "orders" => $this->M_Cart->listOrderPaginate($config["per_page"], $page, $keyword, $status, $tanggal),
            "total_rows" => $config['total_rows'],
            "per_page" => $config['per_page'],
        ];

        $this->load->view('pages/index', $data);
    }

    public function load_data()
    {
        $mode = $this->input->get('mode'); // Ambil mode dari AJAX (desktop/mobile)

        $keyword = ($this->input->post('keyword')) ? trim($this->input->post('keyword')) : (($this->session->userdata('search_order_keyword')) ? $this->session->userdata('search_order_keyword') : '');
        if ($keyword === null) $keyword = $this->session->userdata('search_order_keyword');
        else $this->session->set_userdata('search_order_keyword', $keyword);

        $status = ($this->input->post('status')) ? trim($this->input->post('status')) : (($this->session->userdata('search_order_status')) ? $this->session->userdata('search_order_status') : '');
        if ($status === null) $status = $this->session->userdata('search_order_status');
        else $this->session->set_userdata('search_order_status', $status);

        $tanggal = ($this->input->post('tanggal')) ? trim($this->input->post('tanggal')) : (($this->session->userdata('search_order_tanggal')) ? $this->session->userdata('search_order_tanggal') : '');
        if ($tanggal === null) $tanggal = $this->session->userdata('search_order_tanggal');
        else $this->session->set_userdata('search_order_tanggal', $tanggal);

        $config['per_page'] = 10;

        $page = $this->uri->segment(3) ? ($this->uri->segment(3) - 1) * $config['per_page'] : 0;

        $data = [
            "orders" => $this->M_Cart->listOrderPaginate($config["per_page"], $page, $keyword, $status, $tanggal),
            "per_page" => $config['per_page'],
            "total_rows" => $this->M_Cart->count($keyword, $status, $tanggal),
        ];

        if ($mode == 'mobile') {
            $this->load->view('pages/order/v_order_mobile', $data);
        } else {
            $this->load->view('pages/order/v_order_desktop', $data);
        }
    }

    public function getOrderDetail()
    {
        $id = $this->input->post('id');
        $data['order'] = $this->db->get_where('orders', ['id' => $id])->row();

        $this->load->view('pages/order/v_order_detail', $data);
    }

    public function checkNewOrders()
    {
        $newOrders = $this->db->where('order_status', 'menunggu konfirmasi')->count_all_results('orders');
        echo $newOrders;
    }

    public function exportOrders()
    {
        require 'vendor/autoload.php'; // Load PHPExcel
        $spreadsheet = new PHPExcel();
        $sheet = $spreadsheet->getActiveSheet();

        $orders = $this->db->get('orders')->result();
        $sheet->setCellValue('A1', 'No. Order');
        $sheet->setCellValue('B1', 'Nama Pemesan');
        $sheet->setCellValue('C1', 'Total');

        $row = 2;
        foreach ($orders as $order) {
            $sheet->setCellValue("A$row", $order->no_order);
            $sheet->setCellValue("B$row", $order->order_name);
            $sheet->setCellValue("C$row", $order->total);
            $row++;
        }

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=orders.xlsx");
        $writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel2007');
        $writer->save("php://output");
    }

    public function add()
    {
        $variant_id = $this->input->post('variant_id'); // Ini sebenarnya variant_id
        $quantity = (int) $this->input->post('quantity');

        // Cek login dulu
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('message_error', 'Anda harus login dulu untuk menambahkan ke keranjang!');
            redirect('auth');
        }

        // Ambil data varian dari DB
        $variant = $this->M_Product->get_variant_by_id($variant_id);

        // print_r($_POST);
        // exit;

        if (!$variant) {
            $this->session->set_flashdata('message_error', 'Varian produk tidak ditemukan!');
            redirect($this->input->post('redirect'));
        }

        // Cek stok
        if ($variant->stock < $quantity) {
            $this->session->set_flashdata('message_error', 'Stok varian tidak mencukupi!');
            redirect($this->input->post('redirect'));
        }

        $product_name = $this->db->where('id', $variant->product_id)->get('products')->row_array()['name'];

        $product_data = [
            'variant_id' => $variant_id,
            'product_id' => $variant->product_id,
            'product_name' => $product_name,
            'variant_name' => $variant->variant_name,
            'price' => $variant->variant_price,
            'quantity' => $quantity,
        ];

        // print_r($product_data);
        // exit;

        $this->_add_to_cart($product_data);
    }


    private function _add_to_cart($data = null)
    {
        if (!$data) {

            $variant_id = $this->input->post('variant_id');

            $variant = $this->M_Product->get_variant_by_id($variant_id);

            $data = [
                'variant_id' => $variant_id,
                'product_id' => $variant->product_id,
                'product_name' => $variant->variant_name,
                'price' => $variant->variant_price,
                'quantity' => (int) $this->input->post('quantity'),
            ];
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['subtotal'] = $data['price'] * $data['quantity'];

        if ($this->M_Cart->add_to_cart($data)) {
            $this->session->set_flashdata('message_success', 'Produk berhasil ditambahkan ke keranjang!');
        } else {
            $this->session->set_flashdata('message_error', 'Gagal menambahkan produk ke keranjang!');
        }

        if ($this->input->post('buy_now')) {
            redirect('checkout');
        } else {
            redirect($this->input->post('redirect'));
        }
    }


    // Hapus item dari keranjang
    public function remove($id)
    {
        if ($this->M_Cart->remove_item($id)) {
            $this->session->set_flashdata('success', 'Produk dihapus dari keranjang!');
        }

        redirect('order/cart');
    }

    // Kosongkan keranjang
    public function clear_cart()
    {
        $user_id = $this->session->userdata('user_id');
        $session_id = session_id();

        $this->M_Cart->clear_cart($user_id, $session_id);
        $this->session->set_flashdata('success', 'Keranjang berhasil dikosongkan!');
        redirect('order/cart');
    }

    public function send_order()
    {
        // ambil nilai menu_kode terbesar
        $query = $this->M_Order->max_number();

        $new_code = $query["no_invoice"] + 1;

        $cart = $this->cart->contents();

        $subtotal = $this->cart->total();

        $total_item  = $this->cart->total_items();
        $ppn = $subtotal * 0.1;
        $total = $subtotal + $ppn;

        $now = date('Y-m-d H:i:s');

        $data = array(
            'no_invoice' => $new_code,
            'nama_pemesan' => $this->input->post('nama'),
            'email_pemesan' => $this->input->post('email'),
            'alamat_pemesan' => $this->input->post('address'),
            'telepon_pemesan' => $this->input->post('phone'),
            'notes' => $this->input->post('notes'),
            'total_item' => $total_item,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'grand_total' => $total,
            'order_time' => $now
        );

        $this->M_Order->add_transaction($data);

        $no = 1;
        foreach ($cart as $c) {
            // ambil menu_jual sebelumnya sesuai id product
            $item_jual = $this->M_Product->check_qty($c['id']);

            // tambahkan menu_jual sebelumnya dengan qty yang dipesan
            $new_qty = $item_jual['menu_jual'] + $c['qty'];

            $update_qty = array(
                'menu_jual' => $new_qty
            );

            $this->M_Product->update_menu_jual($update_qty, $c['id']);

            $a[] = $no . '. ' . $c['qty'] . ' ' . $c['name'] . ' @ Rp' . number_format($c['price']) . ',- : Rp' . number_format($c['subtotal']) . ',-';
            $no++;
            $b = array(
                'id_transaction' => $new_code,
                'id_product' => $c["id"],
                'jumlah' => $c["qty"],
                'harga_satuan' => $c["price"],
                'subtotal' => $c["subtotal"],
                'created_at' => $now,
            );
            $this->M_Order->add_transaction_detail($b);
        }

        $b = implode('%0a', $a);

        $no_whatsapp = "08170107303";
        $no_whatsapp2 = "085240719210";
        $wa_pemesan = $data["telepon_pemesan"];

        // message with PPN 10%
        // $msg = '*New Order* %0aNama pemesan: ' . $data['nama_pemesan'] . '%0aEmail: ' . $data['email_pemesan'] . '%0aAlamat: ' . $data['alamat_pemesan'] . '%0aPhone: ' . $data['telepon_pemesan'] . '%0aNotes: ' . $data['notes'] . '%0a%0aPesanan: %0a' . $b . '%0a%0aSubotal: Rp' . number_format($subtotal) . ',-' . '%0a%0aPPn 10%: Rp' . number_format($ppn) . ',-' . '%0a%0a*Total: Rp' . number_format($total) . ',-*';

        // $msg2 = 'Halo, kak *' . $data['nama_pemesan'] . '*. Terima kasih sudah order ke Mlejit. Ini daftar pesanan yang Kamu buat:%0a%0aPesanan: %0a' . $b . '%0a%0aSubotal: Rp' . number_format($subtotal) . ',-' . '%0a%0aPPn 10%: Rp' . number_format($ppn) . ',-' . '%0a%0a*Total: Rp' . number_format($total) . ',-*' . '*%0a%0aNotes: ' . $data['notes'] . '%0a%0aPesanan akan segera datang. Mohon ditunggu ya.';

        $msg = '*New Order* %0aNama pemesan: ' . $data['nama_pemesan'] . '%0aEmail: ' . $data['email_pemesan'] . '%0aAlamat: ' . $data['alamat_pemesan'] . '%0aPhone: ' . $data['telepon_pemesan'] . '%0aNotes: ' . $data['notes'] . '%0a%0aPesanan: %0a' . $b . '%0a%0a*Subtotal: Rp' . number_format($subtotal) . ',-*';

        $msg2 = 'Halo, kak *' . $data['nama_pemesan'] . '*. Terima kasih sudah order ke Mlejit. Ini daftar pesanan yang Kamu buat:%0a%0aPesanan: %0a' . $b . '%0a%0a*Subtotal: Rp' . number_format($subtotal) . ',-*' . '*%0a%0aNotes: ' . $data['notes'] . '%0a%0aPesanan akan segera datang. Mohon ditunggu ya.';

        $this->api_whatsapp->wa_notif($msg, $no_whatsapp);
        $this->api_whatsapp->wa_notif($msg, $no_whatsapp2);
        $this->api_whatsapp->wa_notif($msg2, $wa_pemesan);

        $this->cart->destroy();
        redirect('order');
    }

    public function process_order()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }

        // Ambil cart ID yang dipilih dari session
        $selected_ids = $this->session->userdata('selected_cart_ids');
        if (!$selected_ids) {
            redirect('home/cart');
        }

        $cart = $this->M_Cart->get_selected_cart($selected_ids);

        // print_r($cart);
        // exit;
        $subtotal = array_sum(array_column($cart, 'subtotal'));
        $ppn = $subtotal * 0.1;
        $total = $subtotal + $ppn;

        $delivery_method = $this->input->post('delivery_method');
        $address = ($delivery_method == 'antar') ? $this->input->post('address') : NULL;
        $pickup_point = ($delivery_method == 'pickup') ? $this->input->post('pickup_point') : NULL;

        // Generate no order
        $get_nomor = $this->db->select('count(id) as hasil')
            ->where('created_at >=', date('Y-m-d 00:00:00'))
            ->where('created_at <=', date('Y-m-d 23:59:59'))
            ->get('orders')
            ->row_array();

        $order_number = 'IKK-INV-' . date('ymd') . '-' . str_pad($get_nomor['hasil'] + 1, 3, '0', STR_PAD_LEFT);

        $order_data = [
            'user_id' => $this->session->userdata('user_id'),
            'no_order' => $order_number,
            'order_name' => $this->input->post('firstname'),
            'order_phone' => $this->input->post('phone'),
            'order_email' => $this->input->post('email'),
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'total' => $total,
            'payment_method' => $this->input->post('payment_method'),
            'delivery_method' => $delivery_method,
            'order_status' => 'pending',
            'address' => $address,
            'pickup_point' => $pickup_point,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->trans_begin();

        $order_id = $this->M_Cart->insert_order($order_data);

        if ($order_id) {
            // Simpan order detail
            foreach ($cart as $item) {
                $detail = [
                    'order_id' => $order_id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->product_name,
                    'variant_name' => $item->variant_name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal
                ];
                $this->M_Cart->insert_order_detail($detail);
            }

            // Hapus item dari cart
            $this->M_Cart->remove_selected_cart($selected_ids);

            $this->db->trans_commit();

            // Bersihkan session
            $this->session->unset_userdata('selected_cart_ids');

            $this->session->set_flashdata('message_success', 'Pesanan Anda telah disimpan.');
            redirect('order/payment/' . $order_id);
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message_error', 'Gagal memproses order.');
            redirect('checkout');
        }
    }


    public function payment($order_id)
    {
        $data['order_id'] = $order_id;
        $data['order'] = $this->M_Cart->getOrderById($order_id);
        $data['title'] = 'Payment';
        $this->load->view('pages/front/home/v_payment', $data);
    }

    public function upload_bukti($id)
    {
        $allowed_types = ['jpg', 'jpeg', 'png'];
        $file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($file_ext), $allowed_types)) {
            $this->session->set_flashdata('message_error', 'Format file tidak diperbolehkan.');
            redirect('order/payment/' . $id);
        }

        $config['upload_path'] = 'assets/files/bukti-bayar/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 2048; // Max 2MB
        $config['file_name'] = 'bukti_' . $id . '_' . time(); // Nama file unik

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();

            $data = [
                'bukti_bayar' => $fileData['file_name'],
                'order_status' => 'menunggu konfirmasi',
            ];

            $this->db->trans_begin();
            $this->db->where('id', $id);

            if ($this->db->update('orders', $data)) {
                $this->db->trans_commit();
            } else {
                $this->db->trans_rollback();
            }

            $this->session->set_flashdata('message_success', 'Bukti pembayaran berhasil diupload!');
            redirect('home');
        } else {
            $this->session->set_flashdata('message_error', $this->upload->display_errors());
            redirect('order/payment/' . $id);
        }
    }

    public function proses_pesanan()
    {
        $id = $this->input->post('id');

        // Pastikan pesanan ada dan statusnya 'menunggu konfirmasi'
        $order = $this->M_Cart->get_order_by_id($id);

        if (!$order || $order['order_status'] != "menunggu konfirmasi") {
            echo json_encode(['status' => 'error']);
            return;
        }

        // Ambil semua detail order
        $order_details = $this->M_Cart->get_order_details($id); // pastikan method ini ada di model

        // print_r($order_details);
        // exit;

        $this->db->trans_begin();

        // Kurangi stok untuk setiap produk varian di detail order
        foreach ($order_details as $item) {
            $variant_id = $item['variant_id'];
            $qty = $item['quantity'];

            // Update stok di tabel product_variants
            $this->db->set('stock', 'stock - ' . (int)$qty, false);
            $this->db->where('id', $variant_id);
            $this->db->update('product_variants');
        }

        // Update status menjadi 'diproses'
        $this->M_Cart->update_order_status($id, "diproses");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['status' => 'error']);
        } else {
            $this->db->trans_commit();
            echo json_encode(['status' => 'success']);
        }
    }


    public function pesanan_diambil()
    {
        $id = $this->input->post('id');
        $order = $this->M_Cart->get_order_by_id($id);

        if (!$order || $order['order_status'] != 'diproses' || $order['delivery_method'] != 'pickup') {
            echo json_encode(['status' => 'error']);
            return;
        }

        // Bisa langsung ubah ke 'selesai' atau 'diambil' dulu kalau mau tracking
        $this->M_Cart->update_order_status($id, 'selesai');
        echo json_encode(['status' => 'success']);
    }

    public function kirim_pesanan()
    {
        $id = $this->input->post('order_id');
        $kurir = $this->input->post('courier');
        $resi = $this->input->post('resi');

        $order = $this->M_Cart->get_order_by_id($id);
        if (!$order || $order['order_status'] != 'diproses' || $order['delivery_method'] != 'antar') {
            echo json_encode(['status' => 'error']);
            return;
        }

        $data = [
            'kurir' => $kurir,
            'no_resi' => $resi,
            'order_status' => 'dikirim',
            'send_at' => date('Y-m-d H:i:s') // optional
        ];
        $this->M_Cart->update_order($id, $data);

        echo json_encode(['status' => 'success']);
    }

    public function confirm_received()
    {
        $id = $this->input->post('order_id');
        $order = $this->M_Cart->get_order_by_id($id);

        // Pastikan valid dan statusnya masih 'dikirim'
        if ($order && $order['order_status'] == 'dikirim') {
            $this->M_Cart->update_order_status($id, 'selesai');
            $this->session->set_flashdata('success', 'Pesanan telah dikonfirmasi diterima.');
        } else {
            $this->session->set_flashdata('error', 'Tidak dapat konfirmasi pesanan.');
        }

        redirect('home/orders'); // atau halaman lain sesuai layout kamu
    }
}
