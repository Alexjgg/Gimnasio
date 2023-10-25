</section>
<!-- /.content -->
</div>

<!-- /.content-wrapper -->
<footer class="footer_fit">
  <div>
    <div class="row">
      <div class="col">
        <strong>Direcion: Pontevedra, As Neves calle San paulo Nº 23 </strong>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <span>Iconos sacados de <a href="https://www.flaticon.es/iconos-gratis/gimnasio"
            title="gimnasio iconos">Gimnasio iconos creados por Freepik - Flaticon</a></span>
      </div>
    </div>
  </div>
</footer>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- Script AsnevesFit Nav Superior -->

<script src="assets/js/navsuperior.js"></script>
<script src="assets/js/navlateral.js"></script>
<!-- ./wrapper -->

<!-- jQuery
<script src="plugins/jquery/jquery.min.js"></script>
 -->
<!-- jQuery UI 1.11.4 
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
-->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 4 -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<?php
if (isset($js) && is_array($js)) {
  foreach ($js as $jsFile) {
    echo '<script src="' . $jsFile . '"></script>';
  }
}
?>
</body>

</html>