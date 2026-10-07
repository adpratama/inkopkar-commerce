<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_Stock', 'M_Product']);
        $this->load->library(['session', 'pagination']);
        $this->load->helper(['string', 'url', 'date']);

        // cek login & admin di sini
        if (!$this->session->userdata('is_logged_in')) {

            $this->session->set_userdata('last_page', current_url());

            $this->session->set_flashdata('message_success', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			You have to login first.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');

            redirect('auth');
        } else {
            if ($this->session->userdata('role') !== 'admin') {
                redirect('home');
            }
        }
    }

    // public function index()
    // {
    //     $data['title'] = 'Manajemen Stok';
    //     $data['logs'] = $this->M_Stock->get_logs();
    //     $this->load->view('admin/stock/index', $data);
    // }


    public function index()
    {
        $keyword = ($this->input->post('keyword')) ? trim($this->input->post('keyword')) : (($this->session->userdata('search_stock')) ? $this->session->userdata('search_stock') : '');
        if ($keyword === null) $keyword = $this->session->userdata('search_stock');
        else $this->session->set_userdata('search_stock', $keyword);

        $config = [
            'base_url' => site_url('stock/index'),
            'total_rows' => $this->M_Stock->count($keyword),
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
            "title" => "Stock Management",
            "page" => $page,
            "keyword" => $keyword,
            "segment" => "product",
            "pages" => "pages/product/v_stock",
            "logs" => $this->M_Stock->listProductPaginate($config["per_page"], $page, $keyword),
            "total_rows" => $config['total_rows'],
            "per_page" => $config['per_page'],
            "variants" => $this->M_Product->getVariants(),
        ];

        $this->load->view('pages/index', $data);
    }

    public function add()
    {
        $variant_id = $this->input->post('variant_id');
        $qty        = $this->input->post('quantity');
        $note       = $this->input->post('note');
        $user_id    = $this->session->userdata('user_id');

        // Validasi input
        if (!$variant_id || !is_numeric($qty) || $qty <= 0) {
            $this->session->set_flashdata('message_error', 'Input tidak valid.');
            redirect('stock');
            return;
        }

        // Begin transaction
        $this->db->trans_begin();

        // Update stok di product_variants
        $this->db->set('stock', 'stock + ' . (int)$qty, false);
        $this->db->where('id', $variant_id);
        $this->db->update('product_variants');

        // Log history ke stock_logs
        $data_log = [
            'variant_id' => $variant_id,
            'quantity'   => $qty,
            'note'       => $note,
            'created_by' => $user_id
        ];
        $this->db->insert('stock_logs', $data_log);

        // Cek transaksi
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message_error', 'Gagal menambahkan stok.');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message_success', 'Stok berhasil ditambahkan.');
        }

        redirect('stock');
    }
}
