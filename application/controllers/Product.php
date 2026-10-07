<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'pagination']);
        $this->load->helper(['string', 'url', 'date']);
        $this->load->model('M_Product');

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

    private function checkAccess($url)
    {
        $id_function = $this->db->where('url', $url)->get('menu')->row_array();
        $login_menu = $this->M_Setting->getUserMenu($this->session->userdata('username'));

        // Pastikan 'access_menu' terdekode dengan benar
        $access_menu = json_decode($login_menu['access_menu'], true);

        // Cek apakah hasil 'json_decode' adalah array
        if (is_array($access_menu)) {
            if (!in_array($id_function['Id'], $access_menu)) {
                redirect('auth/forbidden');
            }
        } else {
            redirect('auth/forbidden');
        }
    }

    public function index()
    {
        $keyword = ($this->input->post('keyword')) ? trim($this->input->post('keyword')) : (($this->session->userdata('search_product')) ? $this->session->userdata('search_product') : '');
        if ($keyword === null) $keyword = $this->session->userdata('search_product');
        else $this->session->set_userdata('search_product', $keyword);

        $config = [
            'base_url' => site_url('product/index'),
            'total_rows' => $this->M_Product->count($keyword),
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
            "title" => "Product",
            "page" => $page,
            "keyword" => $keyword,
            "categories" => $this->M_Product->getCategories(),
            "segment" => "product",
            "pages" => "pages/product/v_product",
            "products" => $this->M_Product->listProductPaginate($config["per_page"], $page, $keyword),
            "total_rows" => $config['total_rows'],
            "per_page" => $config['per_page'],
        ];

        $this->load->view('pages/index', $data);
    }

    public function store()
    {
        $this->load->helper('string');
        $this->load->library('form_validation');

        // Validasi input utama
        $this->form_validation->set_rules('nama_product', 'Nama Produk', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message_error', validation_errors());
            redirect('product');
        }

        $this->db->trans_begin();

        try {
            $sku = strtoupper(random_string('alnum', 8));
            $slug = url_title($this->input->post('nama_product', TRUE) . '-' . $sku, 'dash', TRUE);
            $descriptions = $this->input->post('descriptions', TRUE);
            $thumbnail = null;
            $filename = null;

            // Simpan produk utama
            $product_data = array(
                'sku' => $sku,
                'name' => $this->input->post('nama_product', TRUE),
                'slug' => $slug,
                'descriptions' => $descriptions,
                'thumbnail' => null,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1,
                'category' => $this->input->post('category_ids', TRUE),
            );

            print_r($product_data);
            exit;

            $this->db->insert('products', $product_data);
            $product_id = $this->db->insert_id();

            // Simpan kategori produk
            $category_ids = $this->input->post('category_ids');
            if (!empty($category_ids)) {
                foreach ($category_ids as $cat_id) {
                    $this->db->insert('product_categories', array(
                        'product_id' => $product_id,
                        'category_id' => $cat_id
                    ));
                }
            }

            // Upload gambar utama produk (multi)
            if (!empty($_FILES['images']['name'][0])) {
                $files = $_FILES;
                $count = count($_FILES['images']['name']);

                for ($i = 0; $i < $count; $i++) {
                    $_FILES['image']['name'] = $files['images']['name'][$i];
                    $_FILES['image']['type'] = $files['images']['type'][$i];
                    $_FILES['image']['tmp_name'] = $files['images']['tmp_name'][$i];
                    $_FILES['image']['error'] = $files['images']['error'][$i];
                    $_FILES['image']['size'] = $files['images']['size'][$i];

                    $config['upload_path'] = 'assets/files/products/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('image')) {
                        $uploadData = $this->upload->data();
                        $filename = $uploadData['file_name'];

                        $this->db->insert('product_images', array(
                            'product_id' => $product_id,
                            'image' => $filename
                        ));
                    } else {
                        throw new Exception('Upload gambar produk gagal: ' . $this->upload->display_errors('', ''));
                    }
                }
            }

            // Simpan varian produk
            $variant_names  = $this->input->post('variant_name');
            $variant_prices = $this->input->post('variant_price');
            $variant_stocks = $this->input->post('variant_stock');

            $total_variant_stock = 0;

            if (!empty($variant_names)) {
                foreach ($variant_names as $i => $name) {
                    $variant_image = null;

                    // Upload gambar varian jika ada
                    if (!empty($_FILES['variant_image']['name'][$i])) {
                        $_FILES['variant_img']['name']     = $_FILES['variant_image']['name'][$i];
                        $_FILES['variant_img']['type']     = $_FILES['variant_image']['type'][$i];
                        $_FILES['variant_img']['tmp_name'] = $_FILES['variant_image']['tmp_name'][$i];
                        $_FILES['variant_img']['error']    = $_FILES['variant_image']['error'][$i];
                        $_FILES['variant_img']['size']     = $_FILES['variant_image']['size'][$i];

                        $config2['upload_path'] = 'assets/files/products/thumbnail/';
                        $config2['allowed_types'] = 'jpg|jpeg|png';
                        $config2['max_size'] = 2048;
                        $config2['encrypt_name'] = TRUE;

                        $this->upload->initialize($config2);
                        if ($this->upload->do_upload('variant_img')) {
                            $uploadData2 = $this->upload->data();
                            $variant_image = $uploadData2['file_name'];
                        } else {
                            throw new Exception('Upload gambar varian gagal: ' . $this->upload->display_errors('', ''));
                        }
                    }

                    $price = !empty($variant_prices[$i]) ? $variant_prices[$i] : NULL;
                    $stock = !empty($variant_stocks[$i]) ? (int) $variant_stocks[$i] : 0;
                    $total_variant_stock += $stock;

                    $this->db->insert('product_variants', array(
                        'product_id' => $product_id,
                        'variant_name' => $name,
                        'variant_price' => $price,
                        'stock' => $stock,
                        'image' => $variant_image
                    ));
                }

                // Update stok produk utama dari total varian, dan set thumbnail kalau ada gambar
                $update_data = ['stock' => $total_variant_stock];
                if (!empty($filename)) {
                    $update_data['image'] = $filename;
                    $update_data['thumbnail'] = $filename;
                }
                $this->db->update('products', $update_data, ['id' => $product_id]);
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('message_success', 'Produk berhasil ditambahkan!');
            redirect('product');
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message_error', 'Gagal menyimpan produk: ' . $e->getMessage());
            redirect('product');
        }
    }


    public function formEdit()
    {
        $id = $this->input->post('id');

        $detail = $this->M_Product->show($id);
        $categories = $this->M_Product->getCategories(); // Variabel ini digunakan dalam foreach
        $variants = $this->M_Product->showProductVariant($detail['id']);

        $url_form = base_url('product/store/' . $id);

        // $name = $data['name'];
        // $sku = $data['sku'];
        // $product_category = $data['category'];
        $data = [
            'detail' => $detail,
            'categories' => $categories,
            'variants' => $variants,
        ];

        // print_r($detail);

        $this->load->view('pages/product/v_edit_product', $data);

        // $output = "<form method='POST' action='$url_form'>";
        // $output .= "<div class='row'>
        //             <div class='col-md-12 col-12'>
        //                 <div class='mb-3'>
        //                     <label class='form-label'>Nama produk</label>
        //                     <input type='text' name='name' class='form-control' value='$name'>
        //                 </div>
        //             </div>";

        // $output .= "<div class='col-md-6 col-12'>
        //             <div class='mb-3'>
        //                 <label class='form-label'>SKU</label>
        //                 <input type='text' class='form-control' name='sku' value='$sku'>
        //             </div>
        //         </div>";

        // $output .= "<div class='col-md-6 col-12'>
        //             <div class='mb-3'>
        //                 <label class='form-label'>Kategori</label>
        //                 <select class='form-control' name='category'>";

        // foreach ($category as $c) {
        //     $selected = ($c->name == $product_category) ? "selected" : "";
        //     $output .= "<option value='{$c->name}' $selected>{$c->name}</option>";
        // }

        // $output .= "     </select>
        //             </div>
        //         </div>";

        // $output .= "<div class='row mt-2'><div class='col-12 text-end'><button type='submit' class='btn btn-primary btn-submit'>Perbarui</button></div></div>";
        // $output .= "</form>";

        // echo $output;
    }


    public function updateStatusProduct()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (!in_array($status, ['0', '1'])) {
            $response = array('success' => false, 'message' => 'Status tidak valid.');
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $detailProduct = $this->M_Product->showById($id);

        if (empty($detailProduct)) {
            $response = array('success' => false, 'message' => 'Data resi tidak ditemukan.');
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $data = [
            'is_active' => $status
        ];

        $this->db->trans_begin();

        if ($this->M_Product->updateProductById($id, $data)) {

            $this->db->trans_commit();

            if ($status == '1') {
                $message = "Product sudah di-publish";
            } else {
                $message = "Product sudah ditarik";
            }
        } else {

            $this->db->trans_rollback();
            $response = array('success' => false, 'message' => 'Gagal memperbarui resi.');
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $response = array('success' => true, 'status' => $status, 'message' => $message);
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}
