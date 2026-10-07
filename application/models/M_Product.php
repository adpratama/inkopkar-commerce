<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Product extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {
        return $this->db->insert('products', $data);
    }

    public function insertGetId($invoice_data)
    {
        $this->db->insert('products', $invoice_data);

        // Dapatkan ID invoice yang baru saja di-generate
        return $this->db->insert_id();
    }

    public function update($data, $old_slug)
    {
        $this->db->where('slug', $old_slug);
        return $this->db->update('products', $data);
    }

    public function updateProductById($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    public function show($id)
    {
        return $this->db->where('slug', $id)->get('products')->row_array();
    }

    public function showById($id)
    {
        return $this->db->where('id', $id)->get('products')->row_array();
    }

    public function showProductThumbnail($product_id)
    {
        return $this->db->where('product_id', $product_id)->get('product_images')->result();
    }

    public function showProductVariant($product_id)
    {
        return $this->db->where('product_id', $product_id)->get('product_variants')->result();
    }

    public function get_variant_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('product_variants')
            ->row();
    }

    public function is_available($id)
    {
        return $this->db->where('slug', $id)->get('partner')->num_rows();
    }

    public function count($keyword)
    {
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('name', $keyword);
            $this->db->or_like('sku', $keyword);
            $this->db->or_like('category', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->from('products')->count_all_results();
    }

    public function listProductPaginate($limit, $from, $keyword)
    {
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('name', $keyword);
            $this->db->or_like('sku', $keyword);
            $this->db->or_like('category', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->from('products')->order_by('name', 'ASC')->limit($limit, $from)->get()->result();
    }

    public function getCategories()
    {
        return $this->db->get('categories')->result();
    }

    public function getProducts()
    {
        return $this->db->select('*, id as product_id, name as product_name')->where('is_active', '1')->get('products')->result();
    }

    public function getProductsByCategory($id)
    {
        return $this->db->select('p.name as product_name, price, image, product_id, p.slug as slug')->from('product_categories pc')->join('products p', 'pc.product_id = p.id', 'left')->where(['category_id' => $id, 'is_active' => '1'])->get()->result();
    }

    public function getVariants()
    {
        return $this->db->get('product_variants')->result();
    }
}
