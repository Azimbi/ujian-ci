<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_Model extends CI_Model {

    protected $table = 'produk';

    public function checkProdukTableExist()
    {
        return $this->db->table_exists('produk');
    }
}