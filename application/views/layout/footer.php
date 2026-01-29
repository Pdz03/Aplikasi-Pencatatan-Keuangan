<footer class="main-footer text-center">
    <strong>PERSONAL FINANCE</strong>
</footer>
</div>

<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script src="<?= base_url('assets/adminlte/dist/js/adminlte.js') ?>"></script>
<script>
$(document).ready(function() {
    // Pastikan modal tidak kedat-kedut dengan mematikan animasi jika perlu
    $('.modal').appendTo("body"); 
});

function loadDetailRekening(id) {
    // Pakai penanda agar tidak loading berkali-kali saat kursor gerak
    if($('.loading-spinner').length > 0) return; 

    $('.content-wrapper').append('<div class="loading-spinner text-center p-5"><i class="fas fa-sync fa-spin fa-3x text-indigo"></i></div>');

    $.ajax({
        url: "<?= base_url('rekening/detail/'); ?>" + id,
        type: "GET",
        success: function(response) {
            $('.content-wrapper').html(response);
            // Inisialisasi ulang jika ada modal di dalam response
            $('.modal').modal('hide'); 
        }
    });
}
</script>

</body>
</html>
