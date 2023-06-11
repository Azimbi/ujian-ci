<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Produk extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id_produk' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'nama_produk' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'harga' => array(
                'type' => 'INT',
                'constraint' => '100',
            ),
            'kategori' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));
        $this->dbforge->add_key('id_produk', TRUE);
        $this->dbforge->create_table('produk');
    }

    public function down()
    {
        $this->dbforge->drop_table('produk');
    }
}