<?php
require 'config.php';
?>
<!-- Main Footer -->
<footer class="main-footer">

</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo BASE_URL;?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo BASE_URL;?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo BASE_URL;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/jszip/jszip.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo BASE_URL;?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo BASE_URL;?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- ChartJS -->
<script src="<?php echo BASE_URL;?>plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL;?>dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="<?php echo BASE_URL; ?>plugins/select2/js/select2.full.min.js"></script>
<!-- flecha ir arriba -->
<script>
    $(document).ready(function() {
        irArriba();
    }); //Hacia arriba

    function irArriba() {
        $('.ir-arriba').click(function() {
            $('body,html').animate({
                scrollTop: '0px'
            }, 1000);
        });
        $(window).scroll(function() {
            if ($(this).scrollTop() > 0) {
                $('.ir-arriba').slideDown(200);
            } else {
                $('.ir-arriba').slideUp(600);
            }
        });
        $('.ir-abajo').click(function() {
            $('body,html').animate({
                scrollTop: '1000px'
            }, 1000);
        });
    }
</script>

</body>

</html>