<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
        $this->load->model(['M_Auth', 'M_Cart']);
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->session->userdata('is_logged_in')) {
            redirect('dashboard');
        } else {
            if ($this->form_validation->run() ==  false) {
                $data = [
                    "title" => "Login",
                    "pages" => "pages/auth/v_login"
                ];
                $this->load->view('pages/auth/index', $data);
            } else {
                // validasinya sukses
                $this->_login();
            }
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if (!$user) {
            $this->session->set_flashdata('message_error', 'Username has not been registered.');
            redirect('auth');
        }

        if ($user['is_active'] != 1) {
            $this->session->set_flashdata('message_error', 'Username has not been activated.');
            redirect('auth');
        }

        if (!password_verify($password, $user['password'])) {
            $this->session->set_flashdata('message_error', 'Wrong password!');
            redirect('auth');
        }

        // Setup session data
        $data = [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'phone' => $user['phone'],
            'role' => $user['role'],
            'is_logged_in' => true,
        ];
        $this->session->set_userdata($data);
        if ($this->session->userdata('temp_cart_item')) {
            $cart_item = $this->session->userdata('temp_cart_item');

            // Masukkan ke database tabel cart
            $this->db->insert('cart', [
                'user_id' => $user['id'],
                'product_id' => $cart_item['id'],
                'price' => $cart_item['price'],
                'product_name' => $cart_item['product_name']
            ]);

            // Hapus data sementara setelah dimasukkan ke cart
            $this->session->unset_userdata('temp_cart_item');
        }

        $this->session->set_flashdata('toast_success', 'Welcome back, ' . $user['full_name'] . '!');

        // Panggil function redirect terakhir
        $this->redirect_post_login();
    }


    public function registration()
    {
        if ($this->session->userdata('is_logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'The email has already registered'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'The username has already registered'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() ==  false) {

            $data = [
                'title' => 'User Registration',
                // 'style' => 'dashboard/layouts/_style',
                'pages' => 'pages/auth/v_registration',
                // 'script' => 'dashboard/layouts/_script'
            ];

            $this->load->view('pages/auth/index', $data);
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'username' => $this->input->post('username'),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => '2',
                'is_active' => '1',
                'date_created' => time()
            ];

            $this->M_Auth->registration($data);
        }
    }

    public function change_password($id)
    {

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();

        $this->session->set_flashdata('message_success', '<div class="alert alert-success alert-dismissible fade show" role="alert">
		You have been logout.
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
        redirect('home');
    }

    public function forbidden()
    {
        $this->load->view('errors/html/error_403');
    }

    private function redirect_post_login()
    {
        $last_page = $this->session->userdata('last_page');

        // Cek biar nggak redirect balik ke auth atau dashboard terus
        if (!$last_page || $last_page == base_url('auth') || $last_page == base_url('dashboard')) {
            if ($this->session->userdata('role') === 'admin') {
                redirect('dashboard');
            } else {
                redirect('home');
            }
        } else {
            redirect($last_page);
        }

        // Hapus last_page biar bersih
        $this->session->unset_userdata('last_page');
    }


    public function ajax_login()
    {
        if ($this->input->is_ajax_request()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->db->get_where('users', ['email' => $email])->row_array();

            if (!$user) {
                $this->session->set_flashdata('message_error', 'Email belum terdaftar!');
                echo json_encode(['status' => 'error', 'message' => 'Email belum terdaftar!']);
                return;
            }

            if ($user['is_active'] != 1) {
                $this->session->set_flashdata('message_error', 'Akun belum diaktivasi!');
                echo json_encode(['status' => 'error', 'message' => 'Akun belum diaktivasi!']);
                return;
            }

            if (!password_verify($password, $user['password'])) {
                $this->session->set_flashdata('message_error', 'Password salah!');
                echo json_encode(['status' => 'error', 'message' => 'Password salah!']);
                return;
            }

            // Set session login
            $data = [
                'user_id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'],
                'full_name' => $user['full_name'],
                'phone' => $user['phone'],
                'is_logged_in' => true,
            ];

            $this->session->set_userdata($data);

            $this->session->set_flashdata('toast_success', 'Welcome back, ' . $user['full_name'] . '!');

            echo json_encode(['status' => 'success', 'redirect' => base_url('home')]);
        } else {
            show_404();
        }
    }

    private function _add_to_cart($data)
    {
        $cart_data = [
            'user_id' => $this->session->userdata('user_id'),
            'product_id' => $data['product_id'],
            'product_name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'subtotal' => $data['price'] * $data['quantity'],
        ];

        if ($this->M_Cart->add_to_cart($cart_data)) {
            $this->session->set_flashdata('message_success', 'Produk berhasil ditambahkan ke keranjang!');
        } else {
            $this->session->set_flashdata('message_error', 'Gagal menambahkan produk ke keranjang!');
        }

        redirect($data['redirect']);
    }
}
