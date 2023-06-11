<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    private $statusBisaDijual = 'bisa dijual';
    
    function __construct() {
		parent::__construct();
        $this->load->model('produk_model');
    }

    public function index() {
        if($this->produk_model->checkProdukTableExist() === FALSE) {
            echo '<h1>Tabel <strong>Produk</strong> belum ada di database anda, silahkan lakukan migration dulu '. 
                '<a href="'.site_url('start/migration').'">disini</a> atau export file .sql nya</h1>';
        }

        // Pagination Config	
        $config = array(
            'base_url' => base_url('/produk/index'),
            'total_rows' => $this->produk_model->countAllProdukBisaDijual(),
            'per_page' => 8,
            'attributes' => array('class' => 'page-link'),
        );
        
        // Init Pagination
        $this->pagination->initialize($config);

        $start = $this->uri->segment(3);
        $data = array(
            'title' => 'Daftar Produk',
            'daftarProduk' =>$this->produk_model->getProdukByStatus($this->statusBisaDijual, $config['per_page'], $start),
        );

        $this->load->view('parts/header', $data);
        $this->load->view('produk/index', $data);
        $this->load->view('parts/footer');
    }

    public function create() {
        $kategoryList = !empty($this->produk_model->getProdukKategoriList()) ? $this->produk_model->getProdukKategoriList()
                                                                        : array(
                                                                            array("kategori" => 'L MTH AKSESORIS (IM)')
                                                                        );
        $statusList = !empty($this->produk_model->getProdukStatusList()) ? $this->produk_model->getProdukStatusList()
                                                                        : array(
                                                                            array('status' => 'bisa dijual')
                                                                        );
        $data = array(
            'title' => 'Tambah Produk',
            'kategori' => $kategoryList,
            'status' => $statusList,
        );
        $this->load->view('parts/header', $data);
        $this->load->view('produk/form', $data);
        $this->load->view('parts/footer');
    }

    public function update($id) {
        $checkProduk = $this->produk_model->findProdukId($id);
        if(empty($checkProduk)) {
            show_404();
        }

        $kategoryList = !empty($this->produk_model->getProdukKategoriList()) ? $this->produk_model->getProdukKategoriList()
                                                                        : array(
                                                                            array("kategori" => 'L MTH AKSESORIS (IM)')
                                                                        );
        $statusList = !empty($this->produk_model->getProdukStatusList()) ? $this->produk_model->getProdukStatusList()
                                                                        : array(
                                                                            array('status' => 'bisa dijual')
                                                                        );
        $data = array(
            'title' => 'Update Produk',
            'kategori' => $kategoryList,
            'status' => $statusList,
            'produk' => $checkProduk,
        );
        $this->load->view('parts/header', $data);
        $this->load->view('produk/form', $data);
        $this->load->view('parts/footer');
    }

    public function process_produk() {
        if($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect("produk");
        }
        
        $nameRules = empty($this->input->post('idProduk')) ? "required|min_length[6]|trim|callback_name_check" 
                                                        : "required|min_length[6]|trim";
        
        $create_rule = array(
            array(
                "field" => "namaProduk",
                "label" => "Nama Produk",
                "rules" => $nameRules,
            ),
            array(
                "field" => "harga",
                "label" => "Harga",
                "rules" => "required|numeric|greater_than[0]",
            ), 
            array(
                "field" => "kategori",
                "label" => "Kategori",
                "rules" => "required",
            ), 
            array(
                "field" => "status",
                "label" => "Status",
                "rules" => "required",
            )
        );

        $this->form_validation->set_rules($create_rule);

        if($this->form_validation->run()){
            
            // Data yang akan disimpan
            $data = array(
                'nama_produk' => trim($this->input->post('namaProduk')),
                'harga' => intval(trim($this->input->post('harga'))),
                'kategori' => trim($this->input->post('kategori')),
                'status' => trim($this->input->post('status')),
           );

           // Tambah nilai id produk pada array jika ada
            if(!empty($this->input->post('idProduk'))) { 
                $data = array_merge(
                    array('id_produk' => intval(trim($this->input->post('idProduk')))), $data
                );
            }

            // save or update
            $this->produk_model->saveOrUpdate($data);

            $pesan = empty($this->input->post('idProduk')) ? 'Produk berhasil dibuat!' 
                                                        : 'Produk berhasil dirubah!';
                                                        
            $this->session->set_flashdata('success', $pesan);
            
            redirect('produk');
        } 
        
        if(empty($this->input->post('idProduk'))) {
            $this->create();
        } else {
            $this->update($this->input->post('idProduk'));
        }
    }

    public function delete($id) {
        if($this->input->server('REQUEST_METHOD') !== 'POST') {
            return show_404();
        }

        $idProduk = !empty($this->input->post('id_produk')) ? $this->input->post('id_produk') : null;
        $checkProduk = $this->produk_model->findProdukId($idProduk);

        if(!empty($idProduk)) {

            if(empty($checkProduk)) {
                show_404();
            }

            $this->produk_model->delete($idProduk);
        }
    }

    public function name_check($name)
    {
        $checkName = $this->produk_model->findProdukName(trim($name));
        if (!empty($checkName)) {
            $this->form_validation->set_message('name_check', 'The {field} already exist, please insert different one');
            return FALSE;
        } else {
             return TRUE;
        }
    }
}