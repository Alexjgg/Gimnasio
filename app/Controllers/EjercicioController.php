<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Helpers\Ejercicio;
use \Com\Daw2\Helpers\Mensaje;
use Com\Daw2\Models\EjercicioModel;

class EjercicioController extends \Com\Daw2\Core\BaseController
{
    //Los ejercicios solo lo manejan los entrenadores
    public function index()
    {
        if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
            //hacemos la carga de todos los ejerciicios
            $_vars = array(
                'titulo' => 'Ejercicios',
                'div_title' => 'Lista de Ejercicios',
                'js' => array('assets/js/filtroUnaTabla.js'),
            );
            //Obtenmos todos los ejercicos como un array y lo pasmaos a objectos
            $ejercicio = new EjercicioModel();
            if (isset($_POST["nombre"])) {
                $ejercicios = $ejercicio->getEjerciciosByName($_POST["nombre"]);

            } else {
                $ejercicios = $ejercicio->getAllEjercicios();
            }

            $datos = array();
            foreach ($ejercicios as $ejercicios) {
                array_push($datos, (object) $ejercicios);
            }
            $_vars['datos'] = $datos;
            $this->view->showViews(array('templates/header.view.php', 'ejercicios.index.view.php', 'templates/footer.view.php'), $_vars);
        } else {
            header('location: index.php');
        }
    }

    public function new()
    {
        if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
            //Insertar un nuevo ejercicio
            $_vars = ['titulo' => 'Nuevo ejercicio',];
            if (isset($_POST['action'])) {
                //chekeamos errores y sannitizamos las entradas de datos
                $_errors = $this->checkErrores($_POST);
                $sanitized = $this->sanitizar($_POST);
                if (!empty($_errors)) {
                    $_vars['errors'] = $_errors;

                    $_vars['sanitized'] = (object) $sanitized;

                } else {
                    $ejercicioModel = new \Com\Daw2\Models\EjercicioModel();
                    $exito = $ejercicioModel->insertEjercicio($_POST['nombre'], $_POST['descripcion'], $_POST['repeticiones'], $_POST['duracion']);
                    if ($exito) {
                        header('location: ./?controller=ejercicio&action=index');
                    } else {
                        $_vars['errors'] = array('nombre' => 'Error indeterminado al guardar');
                        $_vars['sanitized'] = $this->sanitizeInput($_POST);
                    }
                }
            }
            $this->view->showViews(array('templates/header.view.php', 'ejercicio.new.view.php', 'templates/footer.view.php'), $_vars);
        } else {
            header('location: index.php');
        }

    }
    public function delete()
    {
        if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
            //Eleminar un ejercicios de la base de datos
            $model = new EjercicioModel();
            $idEjercicio = $_GET['id'];
            if (!empty($idEjercicio)) {
                try {
                    if ($model->delete($idEjercicio)) {

                        header('location:./?controller=ejercicio&action=index');
                    } else {
                        header('location: index.php');
                    }
                } catch (\PDOException $ex) {
                }
            } else {
            }
        } else {
            header('location: index.php');
        }
    }
    public function edit()
    {
        if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
            //editar un ejercicio de la base de datos
            $_vars = [
                'titulo' => 'Editar Ejercicio',
            ];
            if (isset($_POST['action'])) {

                //chekeamos errores y sannitizamos las entradas de datos
                $_errors = $this->checkErrores($_POST);
                $sanitized = $this->sanitizar($_POST);
                if (!empty($_errors)) {
                    //si hay errores devolvemos el ejercio previo(el id para saber donde tenemso que guardar el prosimo intento) y los mesajes de donde hay errores
                    $model = new EjercicioModel();
                    $ejercicio = $model->loadEjercicio($_POST['idEjercicio']);
                    $_vars = array(
                        'errors' => $_errors,
                        'ejercicio' => $ejercicio,
                        'sanitez' => (object) $sanitized
                    );
                    $this->view->showViews(array('templates/header.view.php', 'ejercicio.new.view.php', 'templates/footer.view.php'), $_vars);

                } else {
                    //cargamos el model de ejercicio y hacemos un update del ejercicio
                    $ejercicioModel = new EjercicioModel();
                    $exito = $ejercicioModel->updateEjercicio((int) $_POST['idEjercicio'], $_POST['nombre'], $_POST['descripcion'], $_POST['repeticiones'], $_POST['duracion']);
                    if ($exito) {
                        header('location: ./?controller=ejercicio&action=index');
                    } else {
                        //si el update no tiene exito delvovemos el ejercico
                        $ejercicio = $ejercicioModel->loadEjercicio($_POST['idEjercicio']);
                        $sanitized = (object) $ejercicio;
                        $_vars = array(
                            'errors' => $_errors,
                            'sanitized' => (object) $sanitized,
                            'ejercicio' => $ejercicio
                        );
                        $this->view->showViews(array('templates/header.view.php', 'erjercicio.edit.view.php', 'templates/footer.view.php'), $_vars);
                    }
                }
            } else if (isset($_GET['idEjercicio'])) {
                //si no existe post cargamos el ejercicio por get y lo mostramos
                $model = new EjercicioModel();
                $ejercicio = $model->loadEjercicio($_GET['idEjercicio']);
                $_vars['ejercicio'] = (object) $ejercicio;
                $_vars['sanitized'] = (object) $ejercicio;
                $this->view->showViews(array('templates/header.view.php', 'ejercicio.new.view.php', 'templates/footer.view.php'), $_vars);
            } else {
                header("location: index.php");
            }
        } else {
            header("location: index.php");
        }

    }
    private function sanitizar(array $_datos)
    {
        //sanitizamos los campos
        $_sanitizado['nombre'] = filter_var($_datos['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
        $_sanitizado['repeticiones'] = filter_var($_datos['repeticiones'], FILTER_SANITIZE_SPECIAL_CHARS);
        $_sanitizado['duracion'] = filter_var($_datos['duracion'], FILTER_SANITIZE_SPECIAL_CHARS);
        $_sanitizado['descripcion'] = filter_var($_datos['descripcion'], FILTER_SANITIZE_SPECIAL_CHARS);
        $ejercicio = new Ejercicio("", $_sanitizado['nombre'], $_sanitizado['descripcion'], $_sanitizado['repeticiones'], $_sanitizado['duracion']);
        return $ejercicio;
    }
    private function checkErrores(array $_datos)
    {
        $_errors = array();
        //comprobamos los posbiles errores que puede tener nuestos campos de ejercicios
        if ($_datos["nombre"] != filter_var($_datos['nombre'], FILTER_SANITIZE_SPECIAL_CHARS))
            $_errors["nombre"] = "No estan permitido los caracteres especiales";
        if (empty($_datos["nombre"]))
            $_errors["nombre"] = "Este campo esta vacio";

        if ($_datos["descripcion"] != filter_var($_datos['descripcion'], FILTER_SANITIZE_SPECIAL_CHARS))
            $_errors["descripcion"] = "No estan permitido los caracteres especiales";

        if ($_datos['repeticiones'] != filter_var($_datos['repeticiones'], FILTER_VALIDATE_FLOAT))
            $_errors["repeticiones"] = "No estan permitido valores no numericos";

        if ($_datos["duracion"] != filter_var($_datos['duracion'], FILTER_SANITIZE_SPECIAL_CHARS))
            $_errors["duracion"] = "No estan permitido los caracteres especiales";


        $_campos = array(
            'nombre' => 100,
            'descripcion' => 400,
            'repeticiones' => 15,
            'duracion' => 75,

        );

        foreach ($_campos as $key => $value) {
            if (strlen($_datos[$key]) > $value) {
                $_errors[$key] = "El tamaño máximo permito es $value";
            }
        }

        return $_errors;

    }
}