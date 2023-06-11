<div class="container">
    <div class="row">
        <div class="h2 pt-5 text-center">
            Daftar Produk Dari API
        </div>
        <div class="h5 pb-5 text-center fw-normal fs-6">
            (Hasil API yang didapat ini disimpan pada session, <a href="<?= site_url('start/fetch-api'); ?>">Klik Disini</a> untuk memanggil ulang API)
        </div>
        <div class="col-md-6 text-md-start text-center">
            <p>Username : <span class="badge bg-success"><?= $username; ?></span></p>
            <p>Message : 
            <span class="badge <?= $message === 'API catch successfully' ? 'bg-success' : 'bg-danger' ?>">
                <?= $message; ?>
            </span>
            </p>
        </div>
        <div class="col-md-6 text-md-end text-center pb-2">
            <a href="<?= site_url('produk'); ?>" class="btn btn-primary"><i class="bi bi-bag-check fs-5"></i> Lihat Produk</a>
        </div>
        <table class="table table-responsive table-bordered">
            <thead>
                <tr class="text-center">
                    <th style="width:5%">ID</th>
                    <th style="width:50%">Nama</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Add To DB</th>
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
                        <td class="text-center align-middle"><?= $value['kategori']; ?></td>
                        <td class="text-center align-middle"><?= $value['status']; ?></td>
                        <td class="text-center align-middle">
                        <span class="badge <?= $value['to_db'] === 'TRUE' ? 'bg-success' : 'bg-danger'; ?>">
                            <?= $value['to_db']; ?>
                        </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data yang ditampilkan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>