<?php
namespace Com\Daw2\Controllers;

use \Com\Daw2\Helpers\Mensaje;
use Com\Daw2\Models\EjercicioModel;
use Com\Daw2\Models\EntrenamientoModel;
use Com\Daw2\Helpers\Entrenamiento;
use Com\Daw2\Models\UsuarioModel;

class EntrenamientoController extends \Com\Daw2\Core\BaseController
{
  //Los entrenamientos solo lo manejan entrenadores pero los clientes pueden ver su entrenamiento
  public function index()
  {
    //Menu de crontol de los entrenadores
    if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
      $_vars = array(
        'titulo' => 'Entrenamientos',
        'div_title' => 'Lista de Entrenamiento',
        'js' => array('assets/js/filtroUnaTabla.js'),
      );
      //Cargamos los entrenamientos de el entrenador logeado
      $entrenamientoModel = new EntrenamientoModel();
      $entrenamientos = $entrenamientoModel->getAllEntrenamientosByIdCoach($_SESSION['usuario']['idDatosUsuario']);

      $datos = array();
      foreach ($entrenamientos as $entrenamiento) {
        $numEjercicios = $entrenamientoModel->getEjerciciosByName($entrenamiento["idEntrenamiento"]);

        $entrenamientoObj = (object) $entrenamiento;
        $entrenamientoObj->numEjercicios = $numEjercicios;
        $datos[] = $entrenamientoObj;
      }
      $_vars['datos'] = $datos;
      //Enviamos los entrenamientos como objectos para cargarlos en la view
      $this->view->showViews(array('templates/header.view.php', 'entrenamiento.index.view.php', 'templates/footer.view.php'), $_vars);
    } else {
      header('location: index.php');
    }

  }

  public function misEntrenamientos()
  {
    //Mostramos los entrenamientos al cliente
    if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'cliente')) {
      $entrenamientoModel = new EntrenamientoModel();
      $MisEntrenamientos = $entrenamientoModel->getEntrenamientosByIdClient((int) $_SESSION['usuario']['idDatosUsuario']);

      $datos = array();
      foreach ($MisEntrenamientos as $entrenamiento) {
        $numEjercicios = $entrenamientoModel->getEjerciciosByName($entrenamiento["idEntrenamiento"]);

        $entrenamientoObj = (object) $entrenamiento;
        $entrenamientoObj->numEjercicios = $numEjercicios;
        $datos[] = $entrenamientoObj;
      }
      $_vars = array(
        'titulo' => 'Mis entrenamientos ',
        'datos' => $datos,
        'js' => array('assets/js/filtroUnaTabla.js'),
      );
      //Enviamos los entrenamientos como objectos para cargarlos en la view
      $this->view->showViews(array('templates/header.view.php', 'entrenamiento.index.view.php', 'templates/footer.view.php'), $_vars);
    }
  }
  public function ver()
  {
    //Cargamos un entrenamiento en concreto y lo mostramos
    if (isset($_SESSION['usuario']) && (($_SESSION['usuario']['rol'] == 'entrenador') || ($_SESSION['usuario']['rol'] == 'cliente'))) {
      $entrenamientoModel = new EntrenamientoModel();

      $auxId = -1;
      if (isset($_GET['idEntrenamiento'])) {
        $auxId = (int) $_GET['idEntrenamiento'];
      }
      if (isset($_POST['idEntrenamiento'])) {
        $auxId = (int) $_POST['idEntrenamiento'];
      }
      //Comprobamos el id del entrenamiento
      $idEntrenamiento = $auxId;
      //Comprobar si el usuario tiene este entrenamiento id 
      $errores = true;
      //compruebo si el cliente tiene este entrenamiento
      if ($_SESSION['usuario']['rol'] == 'cliente') {
        $entrenamientos = $entrenamientoModel->getEntrenamientosByIdClient((int) $_SESSION['usuario']['idDatosUsuario']);
        foreach ($entrenamientos as $entrenamiento) {
          if (in_array($idEntrenamiento, array_values($entrenamiento))) {
            $errores = false;
            break;
          }
        }
      }
      //compruebo si el entrenador tiene este entrenamiento
      if ($_SESSION['usuario']['rol'] == 'entrenador') {
        $entrenamientos = $entrenamientoModel->getAllEntrenamientosByIdCoach((int) $_SESSION['usuario']['idDatosUsuario']);
        foreach ($entrenamientos as $entrenamiento) {
          if (in_array($idEntrenamiento, array_values($entrenamiento))) {
            $errores = false;
            break;
          }
        }
      }
      //Cargamos los ejercicios del entrenamiento
      if (!$errores) {
        $allEjercicios = $entrenamientoModel->getaEjerciciosByIdEntrenamiento($idEntrenamiento);

        $_vars = array(
          'ejercicios' => $allEjercicios,
        );
        $this->view->showViews(array('templates/header.view.php', 'entrenamiento.individual.view.php', 'templates/footer.view.php'), $_vars);
      } else {
        header('location: index.php');
      }
    } else {
      header('location: index.php');
    }
  }
  public function New()
  {
    if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
      $ejercicioModel = new EjercicioModel();
      $ejercicios = $ejercicioModel->getAllEjercicios();
      $datos = array();
      foreach ($ejercicios as $ejercicios) {
        array_push($datos, (object) $ejercicios);
      }

      $_vars = array(
        'titulo' => 'Nuevo Entrenamiento',
        'datos' => $datos,
        'js' => array('assets/js/manejoDeTablas.js', 'assets/js/filtroTableEjercicio.js', 'assets/js/datosTabla.js')
      );

      if (isset($_POST["action"])) {
        $sanitized = $this->sanitizar($_POST);
        $_errors = $this->checkErrores($_POST);

        if (!empty($_errors)) {
          $_vars['errors'] = $_errors;

          $_vars['sanitized'] = (object) $sanitized;

        } else {
          $entrenamientoModel = new EntrenamientoModel();
          //sesion el id
          $exito = $entrenamientoModel->insertEntrenamiento($_POST['nombre'], $_POST['dia'], $_SESSION['usuario']["idDatosUsuario"], json_decode($_POST["datosTabla"]));
          if ($exito) {
            header('location: ?controller=entrenamiento&action=index');
          } else {
            $_vars['errors'] = array('nombre' => 'Error indeterminado al guardar');
          }
        }
      }
      $this->view->showViews(array('templates/header.view.php', 'entrenamiento.new.view.php', 'templates/footer.view.php'), $_vars);
    } else {
      header('location: index.php');
    }
  }
  public function edit()
  {
    //permisoas entrenadores y admisn
    //son los ejercios que tenga hechos este entrenador con sessions
    if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
      $idEntrenador = $_SESSION['usuario']['idDatosUsuario'];
      $entrenamientoModel = new EntrenamientoModel();
      $auxId = -1;
      if (isset($_GET['idEntrenamiento'])) {
        $auxId = (int) $_GET['idEntrenamiento'];
      }
      if (isset($_POST['idEntrenamiento'])) {
        $auxId = (int) $_POST['idEntrenamiento'];
      }

      $idEntrenamiento = $auxId;
      $entrenamiento = $entrenamientoModel->getEntrenamientoByIdEntrenamientoIdEntrenador($idEntrenador, $idEntrenamiento);

      if (!empty($entrenamiento)) {
        $ejercicioModel = new EjercicioModel();
        $ejercicios = $ejercicioModel->getAllEjercicios();
        $datos = array();
        foreach ($ejercicios as $ejercicios) {
          array_push($datos, (object) $ejercicios);
        }

        //devuelve los ejercicios del entrenamiento

        $misEjercicios = $entrenamientoModel->getEjerciciosByidEntrenadorAndIdentrenamiento((int) $idEntrenador, (int) $idEntrenamiento);
        //esto es para que solo aparezca en los ejercicios disponibles los que aun no esten asignados al entrenamiento
        //creo una aux para recuperar los ids

        $idsAEliminarDeLaVista = array_map(function ($obj) {
          return $obj->getIdEjercicio();
        }, $misEjercicios);

        //con esta funcion filtro los ids 

        $datos = array_filter($datos, function ($obj) use ($idsAEliminarDeLaVista) {
          return !in_array($obj->idEjercicio, $idsAEliminarDeLaVista);
        });

        $_vars = array(
          'titulo' => 'Editar Entrenamiento',
          'sanitized' => (object) $entrenamiento,
          'entrenamiento' => $misEjercicios,
          'datos' => $datos,
          'js' => array('assets/js/manejoDeTablas.js', 'assets/js/filtroTableEjercicio.js', 'assets/js/datosTabla.js')
        );
        if (isset($_POST['action'])) {

          $_errors = $this->checkErrores($_POST);
          $sanitized = $this->sanitizar($_POST);

          if (!empty($_errors)) {
            $_vars = array(
              'errors' => $_errors,
              'sanitized' => (object) $sanitized,
              'titulo' => 'Editar Entrenamiento',
              'entrenamiento' => $misEjercicios,
              'datos' => $datos,
              'js' => array('assets/js/manejoDeTablas.js', 'assets/js/filtroTableEjercicio.js', 'assets/js/datosTabla.js')
            );
            $this->view->showViews(array('templates/header.view.php', 'entrenamiento.new.view.php', 'templates/footer.view.php'), $_vars);

          } else {
            $exito = $entrenamientoModel->updateEntrenamiento($_POST['dia'], $_POST['nombre'], $idEntrenador, $_POST['idEntrenamiento'], json_decode($_POST["datosTabla"]));

            if ($exito) {
              //revisar
              header("location: ./?controller=entrenamiento&action=index");
            } else {
              $_vars = array(
                'errors' => $_errors,
                'sanitized' => (object) $sanitized,

              );
              $this->view->showViews(array('templates/header.view.php', 'entrenamiento.edit.view.php', 'templates/footer.view.php'), $_vars);
            }
          }
        } else if (isset($_GET['idEntrenamiento'])) {
          $this->view->showViews(array('templates/header.view.php', 'entrenamiento.new.view.php', 'templates/footer.view.php'), $_vars);
        } else {
          header("location: ./?controller=entrenamiento&action=index");
        }
      } else {
        header("location: ./index.php");
      }
    } else {
      header("location: ./index.php");

    }
  }

  public function asignarEntrenamiento()
  {
    if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
      $clave = "clave_cifrado01";
      $iv = "5a2c7a618e546f0f";
      $UserModel = new UsuarioModel();
      $entrenamientoModel = new EntrenamientoModel();
      $auxId = -1;
      if (isset($_GET['idEntrenamiento'])) {
        $auxId = (int) $_GET['idEntrenamiento'];
      }
      if (isset($_POST['idEntrenamiento'])) {
        $auxId = (int) $_POST['idEntrenamiento'];
      }
      $idEntrenamiento = $auxId;

      $misClientes = $UserModel->getAllUserByIdCoach((int) $_SESSION['usuario']['idDatosUsuario']);
      $misClientesConEntrenamiento = $UserModel->getAllUserByIdCoachAndIdEntrenamiento((int) $_SESSION['usuario']['idDatosUsuario'], $idEntrenamiento);

      $idsAEliminarDeLaVista = array_map(function ($obj) {
        return $obj->getidUsuario();
      }, $misClientesConEntrenamiento);

      $misClientes = array_filter($misClientes, function ($usuario) use ($idsAEliminarDeLaVista) {
        return !in_array($usuario->getidUsuario(), $idsAEliminarDeLaVista);
      });

      foreach ($misClientes as $Cliente) {
        $auxId = $Cliente->getidUsuario();
        $Cliente->setidUsuario(openssl_encrypt($auxId, 'aes-256-cbc', $clave, 0, $iv));
      }
      foreach ($misClientesConEntrenamiento as $Cliente) {
        $auxId = $Cliente->getidUsuario();
        $Cliente->setidUsuario(openssl_encrypt($auxId, 'aes-256-cbc', $clave, 0, $iv));
      }
      $_vars = array(
        'titulo' => 'Mis clientes',
        'misClientes' => (object) $misClientes,
        'misClientesConEntrenamiento' => $misClientesConEntrenamiento,
        'js' => array('assets/js/manejoDeTablasAsignar.js', 'assets/js/filtroTableEjercicio.js', 'assets/js/datosTablaAsignar.js')
      );

      if (isset($_POST["action"])) {
        $_idsClientes = json_decode($_POST["datosTabla"]);
        $datosIdsDescriptados = [];

        foreach ($_idsClientes as $cliente) {
          $cliente = openssl_decrypt($cliente, 'aes-256-cbc', $clave, 0, $iv);
          $datosIdsDescriptados[] = (int) $cliente;
        }

        foreach ($misClientes as $Cliente) {
          $auxId = $Cliente->getidUsuario();
          $Cliente->setidUsuario(openssl_decrypt($auxId, 'aes-256-cbc', $clave, 0, $iv));
        }

        $misClientes = $UserModel->getAllUserByIdCoach((int) $_SESSION['usuario']['idDatosUsuario']);

        $misClientesIds = array_column($misClientes, 'idUsuario');

        $_clientesEntrenamientoQuitar = array_diff($misClientesIds, $datosIdsDescriptados);
        // var_dump('insertar', $datosIdsDescriptados);
        $exitoEntrenamientoQuitar = true;
        foreach ($_clientesEntrenamientoQuitar as $cliente) {
          var_dump('quitar', $cliente);
        }
        foreach ($datosIdsDescriptados as $cliente) {
          var_dump('insertar', $cliente);
        }
        if (!empty($_clientesEntrenamientoQuitar)) {
          $exitoEntrenamientoQuitar = $entrenamientoModel->quitarEntrenamiento($_clientesEntrenamientoQuitar, $idEntrenamiento);
        }
        $exitoAsignarEntrenador = $entrenamientoModel->insertarEntrenamiento($datosIdsDescriptados, $idEntrenamiento);

        if ($exitoAsignarEntrenador && $exitoEntrenamientoQuitar) {
          header('location: ./?controller=entrenamiento&action=index');
        } else {
          $_vars['errors'] = array('nombre' => 'Error indeterminado al guardar');
        }

      }

      $this->view->showViews(array('templates/header.view.php', 'entrenamiento.asignar.view.php', 'templates/footer.view.php'), $_vars);
    } else {
      header("location: index.php");
    }


  }
  public function delete()
  {
    if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
      $model = new EntrenamientoModel();

      $idEntrenamiento = $_GET['idEntrenamiento'];
      $idEntrenador = (int) $_SESSION['usuario']['idDatosUsuario'];

      if (!empty($idEntrenamiento)) {

        if ($model->delete($idEntrenamiento, $idEntrenador)) {
          header('location: ./?controller=entrenamiento&action=index');
          die;
        } else {
          header('location: ./?controller=entrenamiento&action=index&' . $_GET['idEntrenamiento'] . '');
          die;
        }

      } else {
      }
    } else {
      header('location: ./index.php');
    }
  }
  private function sanitizar(array $_datos)
  {
    $idEntrenador = (int) $_SESSION['usuario']['idDatosUsuario'];
    $entrenamiento['nombre'] = filter_var($_datos['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
    $entrenamiento['dia'] = filter_var($_datos['dia'], FILTER_SANITIZE_SPECIAL_CHARS);
    $entrenamiento = new Entrenamiento($_datos['nombre'], $_datos['dia'], $idEntrenador, $_datos['idEntrenamiento']);
    return $entrenamiento;
  }
  private function checkErrores(array $_datos)
  {
    $_errors = array();
    //Cargar Ids de Ejercicios
    $ejercicioModel = new EjercicioModel();
    $idsEjercicioExistentes = $ejercicioModel->getAllIdsEjercicios();
    $idsEjerciciosSelecionados = json_decode($_POST["datosTabla"]);
    //compruebo si existen todos los ids
    //arreglos para poder hacer las comprobaciones
    $idsEjerciciosSelecionados = array_map('intval', $idsEjerciciosSelecionados);
    $idsEjercicioExistentes = array_column($idsEjercicioExistentes, "idEjercicio");

    $idsEjerciciosNoExistentes = array_diff($idsEjerciciosSelecionados, $idsEjercicioExistentes);

    if (!empty($idsEjerciciosNoExistentes)) {
      $_errors['ejercicio'] = "Algun ejercicio no es valido";
    }
    if (empty(json_decode($_POST["datosTabla"]))) {
      $_errors['ejercicio'] = "No hay ejercicios";
    }
    //comprobaciones de especial chars
    if ($_datos["nombre"] != filter_var($_datos['nombre'], FILTER_SANITIZE_SPECIAL_CHARS)) {
      $_errors["nombre"] = "No estan permitido los caracteres especiales";
    }
    if ($_datos["dia"] != filter_var($_datos['dia'], FILTER_SANITIZE_SPECIAL_CHARS)) {
      $_errors["dia"] = "No estan permitido los caracteres especiales";
    }
    $_campos = array(
      'nombre' => 100,
      'dia' => 25,

    );

    //comprobaciones de legths
    foreach ($_campos as $key => $value) {
      if (strlen($_datos[$key]) > $value) {
        $_errors[$key] = "El tamaño máximo permito es $value";
      }
    }
    return $_errors;

  }

}