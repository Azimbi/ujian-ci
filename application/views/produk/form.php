<div class="container">
    <div class="row">
        <div class="h2 pt-5 pb-3">
            <?= $title; ?>
        </div>
    </div>
    <div class="row g-2">
        <?= form_open(site_url('produk/process-produk'));?>
        <input type="hidden" name="idProduk" value="<?= set_value('idProduk', $produk['id_produk'] ?? ''); ?>">
        <div class="col-auto">
            <div class="form-floating mb-3">
                <input name="namaProduk" type="text" class="form-control <?= !empty(form_error("namaProduk")) ? 'is-invalid' : '';?>" 
                    id="namaProduk" placeholder="Masukan nama produk" value="<?= set_value('namaProduk', $produk['nama_produk'] ?? ''); ?>">
                <label for="name">Nama Produk</label>
                <?php echo form_error("namaProduk", "<div class='invalid-feedback' style='display: block;'>", "</div>"); ?>
            </div>
        </div>
        <div class="col-auto">
            <div class="form-floating mb-3">
                <input name="harga" type="number" min="1" class="form-control <?= !empty(form_error("harga")) ? 'is-invalid' : '';?>" 
                    id="harga" placeholder="9000" value="<?= set_value('harga', $produk['harga'] ?? ''); ?>">
                <label for="harga">Harga</label>
                <?php echo form_error("harga", "<div class='invalid-feedback' style='display: block;'>", "</div>"); ?>
            </div>
        </div>
        <div class="col-auto">
            <div class="form-floating mb-3">
                <select name="kategori" class="form-select <?= !empty(form_error("kategori")) ? 'is-invalid' : '';?>" 
                    id="kategori" aria-label="kategori">
                    <option disabled="disabled" selected="selected">Silahkan pilih...</option>
                    <?php foreach($kategori as $value): ?>
                    <option <?= set_value('kategori', $produk['kategori'] ?? '') === $value['kategori'] ? 'selected' : ''; ?> 
                        value="<?= $value['kategori']; ?>"><?= $value['kategori']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="kategori">Kategori</label>
                <?php echo form_error("kategori", "<div class='invalid-feedback' style='display: block;'>", "</div>"); ?>
            </div>
        </div>
        <div class="col-auto">
            <div class="form-floating mb-3">
                <select name="status" class="form-select <?= !empty(form_error("status")) ? 'is-invalid' : '';?>" 
                    id="status" aria-label="status">
                    <option disabled="disabled" selected="selected">Silahkan pilih...</option>
                    <?php foreach($status as $value): ?>
                    <option <?= set_value('status', $produk['status'] ?? '') === $value['status'] ? 'selected' : ''; ?>
                        value="<?= $value['status']; ?>"><?= $value['status']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="status">Status</label>
                <?php echo form_error("status", "<div class='invalid-feedback' style='display: block;'>", "</div>"); ?>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="<?= site_url('/')?>" class="btn btn-secondary"><i class="bi bi-arrow-left-circle fs-5"></i> Back</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Submit</button>
        </div>
        <?= form_close(); ?>
    </div>
</div>