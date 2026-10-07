<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');

		// Cek apakah user sudah login
		if (!$this->session->userdata('is_logged_in')) {
			$this->session->set_userdata('last_page', current_url());
			redirect('auth');
		} else {
			if ($this->session->userdata('role') !== 'admin') {
				redirect('home');
			}
		}
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'segment' => 'dashboard',
			'pages' => 'pages/dashboard/v_dashboard',
		];
		$this->load->view('pages/index', $data);
	}

	public function reset($jenis)
	{
		$data = [
			"product" => ['search_product', 'product'],
			"order" => ['search_order_keyword', 'search_order_status', 'search_order_tanggal', 'order']
		];

		if (isset($data[$jenis])) {
			$this->session->unset_userdata(array_slice($data[$jenis], 0, -1));

			redirect($data[$jenis][count($data[$jenis]) - 1]);
		}
	}
}
