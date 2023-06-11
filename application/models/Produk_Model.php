<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_Model extends CI_Model {

    protected $table = 'produk';

    public function checkProdukTableExist()
    {
        return $this->db->table_exists('produk');
    }

    public function countAllProdukBisaDijual() {
        return $this->db->get_where($this->table, array('status' => 'bisa dijual'))
            ->num_rows();
    }

    public function findProdukId($id_produk) {
        return $this->db->get_where($this->table, array('id_produk' => $id_produk))
            ->row_array();
    }

    public function findProdukName($name) {
        return $this->db->like('nama_produk', $name, 'none')
            ->get($this->table)
            ->row_array();
    }

    public function getProdukByStatus( $status, $limit, $offset) {
        return $this->db->where('status', $status)
            ->order_by('id_produk', 'asc')
            ->get($this->table, $limit, $offset)
            ->result_array();
    }

    public function getProdukKategoriList() {
        return $this->db->select('kategori')
            ->distinct()
            ->get($this->table)
            ->result_array();
    }

    public function getProdukStatusList() {
        return $this->db->select('status')
            ->distinct()
            ->get($this->table)
            ->result_array();
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
    
    public function delete($id)
    {
        return $this->db->delete($this->table, array('id_produk' => $id));
    }
}