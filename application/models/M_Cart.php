<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Cart extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function count($keyword = null, $status = null, $tanggal = null)
    {
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('no_order', $keyword);
            $this->db->or_like('order_name', $keyword);
            $this->db->group_end();
        }

        if ($status) {
            $this->db->where('order_status', $status);
        }

        if ($tanggal) {
            $this->db->where('DATE(created_at)', $tanggal);
        }

        return $this->db->from('orders')->count_all_results();
    }

    public function listOrderPaginate($limit, $from, $keyword = null, $status = null, $tanggal = null)
    {
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('no_order', $keyword);
            $this->db->or_like('order_name', $keyword);
            $this->db->group_end();
        }

        if ($status) {
            $this->db->where('order_status', $status);
        }

        if ($tanggal) {
            $this->db->where('DATE(created_at)', $tanggal);
        }

        return $this->db->from('orders')->order_by('no_order', 'DESC')->limit($limit, $from)->get()->result();
    }


    public function add_to_cart($data)
    {
        // Cek apakah produk sudah ada di keranjang user/session yang sama
        $this->db->where('product_id', $data['product_id']);
        $this->db->where('variant_id', $data['variant_id']);
        $this->db->where('user_id', $data['user_id']);

        $query = $this->db->get('cart');

        if ($query->num_rows() > 0) {
            // Kalau produk sudah ada, update jumlah dan subtotal
            $row = $query->row();
            $new_qty = $row->quantity + $data['quantity'];
            $new_subtotal = $row->price * $new_qty;

            $this->db->where('id', $row->id);
            return $this->db->update('cart', ['quantity' => $new_qty, 'subtotal' => $new_subtotal]);
        } else {
            // Kalau belum ada, tambahkan item baru
            return $this->db->insert('cart', $data);
        }
    }

    private function get_cart()
    {
        $this->db->select('*, c.id as cart_id, p.name as product_name, pv.image as variant_image');
        $this->db->from('cart c');
        $this->db->join('products p', 'c.product_id = p.id');
        $this->db->join('product_variants pv', 'c.variant_id = pv.id');
        $this->db->where('user_id', $this->session->userdata('user_id'));
    }

    public function get_list_cart()
    {
        $this->get_cart();
        return $this->db->get()->result();
    }

    // Hitung jumlah item di keranjang
    public function get_count_cart()
    {
        $this->get_cart();
        return $this->db->count_all_results();  // Lebih efisien dari get()->num_rows()
    }

    public function getItemById($id)
    {
        return $this->db->where('id', $id)->get('cart')->row_array();
    }

    public function getCartItemById($id)
    {
        return $this->db->where('id', $id)->get('cart')->row_array();
    }

    // Hapus item dari keranjang
    public function update_item($user_id, $id, $qty)
    {
        $price = $this->getCartItemById($id)['price'];
        $subtotal = $price * $qty;

        return $this->db->where(['user_id' => $user_id, 'id' => $id])
            ->update('cart', ['quantity' => $qty, 'subtotal' => $subtotal]);
    }

    // Hapus item dari keranjang
    public function remove_item($user_id, $id)
    {
        return $this->db->delete('cart', ['id' => $id, 'user_id' => $user_id]);
    }

    // Kosongkan seluruh keranjang
    public function clear_cart()
    {
        $this->db->where('user_id', $this->session->userdata('user_id'));

        return $this->db->delete('cart');
    }

    public function insert_order($data)
    {
        $this->db->insert('orders', $data);
        return $this->db->insert_id(); // Mengembalikan ID order terakhir
    }

    public function insert_order_items($items)
    {
        return $this->db->insert_batch('order_items', $items);
    }

    public function update_order_status($order_id, $status)
    {
        return $this->db->where('id', $order_id)->update('orders', ['order_status' => $status]);
    }

    public function update_order($order_id, $data)
    {
        return $this->db->where('id', $order_id)->update('orders', $data);
    }

    public function getOrderById($id)
    {
        // untuk user
        return $this->db->where(['id' => $id, 'user_id' => $this->session->userdata('user_id')])->get('orders')->row_array();
    }

    public function get_order_by_id($id)
    {
        // untuk admin
        return $this->db->where(['id' => $id])->get('orders')->row_array();
    }

    public function getOrder()
    {
        return $this->db->where('user_id', $this->session->userdata('user_id'))->order_by('created_at', 'DESC')->get('orders')->result();
    }

    public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        return $this->db->update('orders', ['order_status' => $status]);
    }

    public function get_selected_cart($selected_ids)
    {
        $this->db->where_in('cart.id', $selected_ids);
        return $this->db->get('cart')->result();
    }

    public function insert_order_detail($data)
    {
        return $this->db->insert('order_details', $data);
    }

    public function remove_selected_cart($ids)
    {
        $this->db->where_in('id', $ids);
        return $this->db->delete('cart');
    }

    public function get_order_details($order_id)
    {
        return $this->db->get_where('order_details', ['order_id' => $order_id])->result_array();
    }
}
