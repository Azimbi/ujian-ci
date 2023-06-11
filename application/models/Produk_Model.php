<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_Model extends CI_Model {

    protected $table = 'produk';

    public function checkProdukTableExist()
    {
        return $this->db->table_exists('produk');
    }

    public function findProdukId($id_produk) {
        return $this->db->get_where($this->table, array('id_produk' => $id_produk))
            ->row_array();
    }

    public function saveOrUpdate($data)
    {
        $idProduk = isset($data['id_produk']) ? $data['id_produk'] : null;
        $checkId = $this->findProdukId($idProduk);
        
        if((empty($idProduk) && empty($checkId)) || (!empty($idProduk) && empty($checkId))) {
		    return $this->db->insert($this->table, $data);
        }

        if(!empty($checkId)) {
            $this->db->where('id_produk', $data['id_produk']);
		    return $this->db->update($this->table, $data);
        }

        return show_error('Cant save or update', 400, '400 An Error Was Encountered');
    }
}