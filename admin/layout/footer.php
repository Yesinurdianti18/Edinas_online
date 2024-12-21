</div> <!-- End DIV page-wrapper -->
</div> <!-- End DIV page -->

<!-- Libs JS -->
<script src="<?= base_url('assets/libs/apexcharts/dist/apexcharts.min.js?1692870487') ?>" defer></script>
<script src="<?= base_url('assets/libs/jsvectormap/dist/js/jsvectormap.min.js?1692870487') ?>" defer></script>
<script src="<?= base_url('assets/libs/jsvectormap/dist/maps/world.js?1692870487') ?>" defer></script>
<script src="<?= base_url('assets/libs/jsvectormap/dist/maps/world-merc.js?1692870487') ?>" defer></script>
<script src="<?= base_url('assets/libs/dropzone/dist/dropzone-min.js?1692870487') ?>" defer></script>
<!-- Tabler Core -->
<script src="<?= base_url('assets/js/tabler.min.js?1692870487') ?>" defer></script>
<script src="<?= base_url('assets/js/demo.min.js?1692870487') ?>" defer></script>

<!-- jquey cdn -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- datatables -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>


<!-- Alert validasi gagal -->
<?php if (isset($_SESSION['validasi'])) : ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "<?= $_SESSION['validasi'] ?>"
        });
    </script>
    <?php unset($_SESSION['validasi']) ?>
<?php endif; ?>

<!-- Alert validasi berhasil -->
<?php if (isset($_SESSION['berhasil'])) : ?>
    <script>
        const Berhasil = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Berhasil.fire({
            icon: "success",
            title: "<?= $_SESSION['berhasil'] ?>"
        });
    </script>
    <?php unset($_SESSION['berhasil']) ?>
<?php endif; ?>

<!-- alert konfirmasi hapus -->
<script>
    $('.tombol-hapus').on('click', function() {
        var getLink = $(this).attr('href');
        Swal.fire({
            title: "Yakin Hapus?",
            text: "Data yang sudah dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = getLink

                // Swal.fire({
                //   title: "Deleted!",
                //   text: "Your file has been deleted.",
                //   icon: "success"
                // });
            }
        });
        return false;
    });
</script>

<!-- datatables -->
<script>
    new DataTable('#myTable', {
        layout: {
            topStart: {
                buttons: ['copy', 'excel', 'pdf', 'print']
            }
        },
        columnDefs: [{
            "defaultContent": "",
            "targets": "_all"
        }, {
            targets: 0, // Kolom pertama (index dimulai dari 0)
            className: 'dt-body-center'
        }]
    });
</script>

<!-- dropzone -->
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/dropzone/dist/dropzone-min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Dropzone("#dropzone-custom")
    })
</script>
</body>

</html>