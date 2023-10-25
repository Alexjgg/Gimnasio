<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <link rel="stylesheet" href="plugins/public/assets/css/asnevesfit.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/bootsrap.css">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-4 offset-4">
        <br>
        <br>
        <div class="text-center">
          <img class="img-fluid" src="Img/logo.png" alt="">
        </div>
        <form action="" method="post">
          <div class="form-group">
            <label for="usuario"> Gmail :
            </label>
            <input type="email" name="email" class="form-control" placeholder="Email"
              value="<?php echo isset($email) ? $email : ''; ?>">
          </div>
          <div class="form-group">
            <label for="password"> Password:</label>
            <div class="form-group">
              <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <?php
            if (isset($errors['email'])) {
              ?>
              <div class="row">
                <div class="col-12 text-center">
                  <p class="text-danger  text-center"><small>
                      <?php echo $errors['email']; ?>
                    </small></p>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
          <button type="submit" name="login" class="btn btn-primary btn-block">Iniciar sesión</button>
        </form>

      </div>
    </div>
  </div>
  <!-- /.login-card-body -->
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/js/adminlte.min.js"></script>
</body>

</html>