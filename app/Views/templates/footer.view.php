</section>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>
<script src="assets/js/navsuperior.js"></script>
<script src="assets/js/navlateral.js"></script>
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