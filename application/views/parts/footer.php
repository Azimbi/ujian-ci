    
    <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/sweetalert2.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script>
        // delete product function
        function hapusProduk(id) {
            const deleteLink = $('#tombol-hapus-'+id).attr('title');
            
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // use ajax request to delete
                    $.ajax({
                        url : deleteLink,
                        data : {
                            id_produk : id,
                        },
                        type : 'POST',
                        success : function(response) {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Produk sudah terhapus.',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error : function(response) {
                            console.log(response);
                        },
                    });
                }
            })
        }
    </script>
</body>
</html>