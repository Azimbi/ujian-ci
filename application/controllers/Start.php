<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends CI_Controller {

    function __construct() {
		parent::__construct();
        $this->load->model('produk_model');
    }

    public function migration()
    {
        if($this->produk_model->checkProdukTableExist()  === FALSE) {
            
            $this->load->library('migration');

            if ($this->migration->current() === FALSE) {
                show_error($this->migration->error_string());
            } else {
                echo 'Migration Successfull';
            }
            
        } else {
            echo 'Already migrating, table exist';
        }
    }
}