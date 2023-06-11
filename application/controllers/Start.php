<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends CI_Controller {

    function __construct() {
		parent::__construct();
        $this->load->model('produk_model');
    }

    public function migration()
    {
        if($this->produk_model->checkProdukTableExist() === FALSE) {
            
            $this->load->library('migration');

            if ($this->migration->current() === FALSE) {
                show_error($this->migration->error_string());
            } else {
                echo 'Migration Successfull, <a href="'.site_url('start/fetch-api').'">lets Fetch API</a>';
            }
            
        } else {
            echo 'Already migrating, table exist';
        }
    }

    public function fetch_api() {
        if($this->produk_model->checkProdukTableExist() === FALSE) {
            echo 'Tabel <strong>Produk</strong> belum ada di database anda, silahkan lakukan migration dulu '. 
                '<a href="'.site_url('start/migration').'">disini</a> atau export file .sql nya';
        } else {
            redirect('start/consume-api');
        }
    }

    public function consume_api()
    {
        // Show error 404 when table not exist
        if($this->produk_model->checkProdukTableExist() === FALSE) {
            return show_error('Tabel <strong>Produk</strong> belum ada di database anda, silahkan lakukan migration dulu '. 
                '<a href="'.site_url('start/migration').'">disini</a> atau export file .sql nya', 404, '404 Table Not Found');
        }

        $apiUrl = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer';
        // Set timezone to WIB;
        date_default_timezone_set('Asia/Jakarta');
        // Add one hour later on current hour
        $oneHourlater = date('H', strtotime('+1 hour'));

        // Make username and password dynamic.
        $username = 'tesprogrammer'.date('dmy').'C'.$oneHourlater;
        $password = 'bisacoding-'.date('d-m-y');
        $password = md5($password);

        // Using curl PHP function to calling the API
        $our_curl = curl_init();

        curl_setopt($our_curl, CURLOPT_URL, $apiUrl);
        curl_setopt($our_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($our_curl, CURLOPT_POST, 1);
        curl_setopt($our_curl, CURLOPT_POSTFIELDS, array(
            'username' => $username,
            'password' => $password,
        ));
        
        $response = curl_exec($our_curl);
        $httpCode = curl_getinfo($our_curl, CURLINFO_HTTP_CODE);
        curl_close($our_curl);
        // End of calling the API

        // Decode response to array
        $result = json_decode($response, true);
        
        $responseArray = array();
        $message = '';

        // Take only data key
        if($httpCode  === 200 && isset($result['data']) && !empty($result['data'])) {

            foreach($result['data'] as $value) {

                $id_produk = intval($value['id_produk']);
                $harga = intval($value['harga']);
                $addToDb = 'FALSE';
                // Find id product that empty if true insert to db
                if(empty($this->produk_model->findProdukId($id_produk))) {
                    
                    // Insert produk
                    $this->produk_model->saveOrUpdate([
                        'id_produk' => $id_produk,
                        'nama_produk' => $value['nama_produk'],
                        'harga' => $harga,
                        'kategori' => $value['kategori'],
                        'status' => $value['status'],
                    ]);
                    $addToDb = 'TRUE';
                } 
                // Add to array to show in view
                $responseArray[] = array(
                    'id_produk' => $id_produk,
                    'nama_produk' => $value['nama_produk'],
                    'harga' => $harga,
                    'kategori' => $value['kategori'],
                    'status' => $value['status'],
                    'to_db' => $addToDb,
                );
            }
            $message = 'API catch successfully';
        } else {
            $message = 'Cant catch the API ('. (isset($result["ket"]) ? $result["ket"] : '').')' ;

        }

        // Data that will save into session
        $data = array(
            'username' => $username,
            'password' => $password,
            'response_api' => $responseArray,
            'message' => $message,
        );

        $this->session->set_userdata($data);
        // Set session as temporary for 30 minutes
        $this->session->mark_as_temp(array('username', 'password', 'response_api', 'message'), 1800);
        redirect('start/show-result');
    }

    public function show_result() {
        // Show error 404 when table not exist
        if($this->produk_model->checkProdukTableExist() === FALSE) {
            return show_error('Tabel <strong>Produk</strong> belum ada di database anda, silahkan lakukan migration dulu '. 
                '<a href="'.site_url('start/migration').'">disini</a> atau export file .sql nya', 404, '404 Table Not Found');
        }
        
        $jumlahBisaDijual = $this->produk_model->countAllProdukBisaDijual(); 
        if($jumlahBisaDijual < 5) {
            return show_error('Data anda kurang dari 5 buah, Silahkan melakukan fetch API Lagi '. 
                '<a href="'.site_url('start/fetch-api').'">disini</a>', 500, '500 Please Fetch API Again');
        }

        if(empty($this->session->userdata('response_api')) && empty($this->session->userdata('username')) ) {
            echo 'session sudah habis silahkan fetch api lagi <a href="'.site_url('start/fetch-api').'">di sini</a>';
        } else {
            $data = array(
                'title' => 'Hasil Fetch API',
                'daftarProduk' => $this->session->userdata('response_api'),
                'username' => $this->session->userdata('username'),
                'password' => $this->session->userdata('password'),
                'message' => $this->session->userdata('message'),
            );
    
            $this->load->view('parts/header', $data);
            $this->load->view('start/index', $data);
            $this->load->view('parts/footer');
        }
    }
}