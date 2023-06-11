<div class="container">
    <div class="row">
        <div class="h2 p-5 text-center">Daftar Produk</div>
        
        <?php
            if(!empty($this->session->flashdata('success'))):
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i> &nbsp;&nbsp;<?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        </div>
        <div class="col-12 pb-2 pe-0 d-flex justify-content-between text-center">
            <a href="<?= site_url('start/show-result'); ?>" class="btn btn-primary"><i class="bi bi-cloud-fog2 fs-5"></i> Fetch API</a>
            <a href="<?= site_url('produk/create'); ?>" class="btn btn-success"><i class="bi bi-plus-circle fs-5"></i> Tambah Produk</a>
        </div>
        <table class="table table-responsive table-bordered">
            <thead>
                <tr class="text-center">
                    <th style="width:5%">ID</th>
                    <th style="width:50%">Nama</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(isset($daftarProduk) && !empty($daftarProduk)):
                        foreach($daftarProduk as $value):
                ?>
                    <tr>
                        <td class="text-center align-middle"><?= $value['id_produk']; ?></td>
                        <td class="align-middle text-wrap"><?= $value['nama_produk']; ?></td>
                        <td class="text-center align-middle"><?= number_format($value['harga'], 0, ',', '.'); ?></td>
                        <td class="text-center align-middle">
                            <span class="badge bg-primary"><?= $value['kategori']; ?></span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-success"><?= $value['status']; ?></span>
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                <a href="<?= site_url('produk/update/'.$value['id_produk'])?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <button title="<?= site_url('produk/delete/'.$value['id_produk'])?>" type="button" 
                                    class="btn btn-sm btn-danger" id="tombol-hapus-<?= $value['id_produk']; ?>" onclick="hapusProduk(<?= $value['id_produk'] ?>)">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tabel Masih Kosong</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="pagination pb-3">
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>
</div>