<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Stock extends CI_Model
{
    public function add_stock($variant_id, $qty, $note = '', $user_id = null)
    {
        // Update stock
        $this->db->set('stock', 'stock + ' . (int)$qty, false);
        $this->db->where('id', $variant_id);
        $this->db->update('product_variants');

        // Log history
        $data = [
            'variant_id' => $variant_id,
            'quantity' => $qty,
            'note' => $note,
            'created_by' => $user_id
        ];

        return $this->db->insert('stock_logs', $data);
    }

    private function get_logs()
    {
        $this->db->select('stock_logs.*, variant_name, u.full_name as admin_name');
        $this->db->from('stock_logs');
        $this->db->join('product_variants pv', 'pv.id = stock_logs.variant_id');
        $this->db->join('products p', 'p.id = pv.product_id');
        $this->db->join('users u', 'u.id = stock_logs.created_by', 'left');
        $this->db->order_by('stock_logs.created_at', 'DESC');
        // return $this->db->get()->result();
    }

    public function count($keyword)
    {
        $this->get_logs();
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('variant_name', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->count_all_results();
    }

    public function listProductPaginate($limit, $from, $keyword)
    {
        $this->get_logs();
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('variant_name', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->limit($limit, $from)->get()->result();
    }
}
