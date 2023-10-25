<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>AsNevesFit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <!-- Estilos de AsnevesFit --->
  <link rel="stylesheet" href="assets/css/asnevesfit.css">

</head>
<header>
  <nav class="menu">
    <label class="logo">AsNevesFit</label>
    <ul class="menu_items">
      <li class="active"><a href="./">Inicio</a></li>
      <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']["rol"] == "cliente") { ?>
      <li><a href="./?controller=entrenamiento&action=misentrenamientos">Entrenamientos</a></li>
      <?php } ?>
      <?php if (isset($_SESSION['usuario'])) { ?>
      <li><a
          href="./?controller=usuario&action=edit&idUsuario=<?php echo $_SESSION['usuario']['idDatosUsuario']; ?>">ajustes</a>
      </li>
      <?php } ?>
      <?php if (isset($_SESSION['usuario'])) { ?>
      <li><a href="./?controller=usuario&action=logOut">Log aut</a></li>
      <?php } ?>
      <?php if (!isset($_SESSION['usuario'])) { ?>
      <li><a href="./?controller=usuario&action=login">Log in</a></li>
      <?php } ?>
    </ul>
    <span class="btn_menu">
      <i class="fa fa-bars"></i>
    </span>
  </nav>

</header>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php if (isset($_SESSION['usuario']) && ($_SESSION['usuario']["rol"] == "entrenador" || $_SESSION['usuario']["rol"] == "admin")) { ?>
      <button id="sidebarCollapse" class="btn_sidenav">
        <span class="arrow">&#8594;</span>
      </button>
      <nav id="sidebar">
        <ul class="list-unstyled components">
          <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']["rol"] == "admin") { ?>
            <li>
              <a href="./?controller=usuario&action=index">Usuarios</a>
            </li>
            <li>
              <a href="./?controller=usuario&action=new">Nuevo usuario</a>
            </li>
          <?php } ?>
          <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']["rol"] == "entrenador") { ?>
            <li>
              <a href="./?controller=usuario&action=asignarCliente">Asignar clientes</a>
            </li>
            <li>
              <a href="./?controller=entrenamiento&action=index">Entrenamientos</a>
            </li>
            <li>
              <a href="./?controller=entrenamiento&action=new">Nuevo entrenamiento</a>
            </li>
            <li>
              <a href="./?controller=ejercicio&action=index">Ejercicios</a>
            </li>
            <li>
              <a href="./?controller=ejercicio&action=new">Nuevo ejercicio</a>
            </li>
          <?php } ?>
        </ul>
      </nav>

    <?php } ?>
    <section class="content height_minimo">