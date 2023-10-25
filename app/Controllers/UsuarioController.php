<?php


namespace Com\Daw2\Controllers;

use Com\Daw2\Helpers\Usuario;
use Com\Daw2\Models\UsuarioModel;

class UsuarioController extends \Com\Daw2\Core\BaseController
{
    //listado/edit y delete de usuarios solo para admin
    //aseignar un usuario a entrenador solo entrenadores
    public function index()
    {
        if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'admin')) {

            $_vars = array(
                'div_title' => 'Usuarios registrados',
            );
            $usuariosModel = new UsuarioModel();

            if (isset($_POST["nombre"])) {
                $usuarios = $usuariosModel->getUsuariosByName($_POST["nombre"]);

            } else {
                $usuarios = $usuariosModel->getAllUsuarios();
            }

            $datos = array();
            foreach ($usuarios as $usuario) {
                array_push($datos, (object) $usuario);
            }
            $_vars['datos'] = $datos;
            $this->view->showViews(array('templates/header.view.php', 'usuarios.index.view.php', 'templates/footer.view.php'), $_vars);
        } else {
            header("location: index.php");
        }

    }

    public function new()
    {
        if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'admin')) {

            $_vars = [
                'titulo' => 'Nuevo Usuario',
            ];
            if (isset($_POST['action'])) {
                $_errors = $this->checkErrores($_POST);
                $sanitized = $this->sanitizar($_POST);
                if (!empty($_errors)) {
                    $_vars = [
                        'errors' => $_errors,
                        'sanitized' => (object) $sanitized
                    ];
                } else {

                    $usuariosModel = new UsuarioModel();
                    $exito = $usuariosModel->insertUsuarioSistema($_POST['nombre'], $_POST['email'], $_POST['password'], $_POST['rol']);
                    if ($exito) {
                        //revisar
                        header('location: ./?controller=usuario&action=index');
                    } else {
                        $_vars['errors'] = array('nombre' => 'Error indeterminado al guardar');
                        $_vars['sanitized'] = (object) $sanitized;
                    }
                }
            }
            $this->view->showViews(array('templates/header.view.php', 'usuariosistema.edit.view.php', 'templates/footer.view.php'), $_vars);

        } else {
            header("location: index.php");
        }


    }
    public function edit()
    {
        if (isset($_SESSION['usuario']) && (($_SESSION['usuario']['rol'] == 'admin') || ((int) $_SESSION['usuario']['idDatosUsuario'] == (int) $_GET['idUsuario']))) {
            $_vars["titulo"] = "Ajustes Usuario";
            if (isset($_POST['action'])) {

                $_errors = $this->checkErrores($_POST, (int) $_POST['idUsuario']);
                $sanitized = $this->sanitizar($_POST);

                $model = new UsuarioModel();

                if (!empty($_errors)) {

                    $usuario = $model->getUserById($_POST['idUsuario']);
                    $_vars = array(
                        'titulo' => 'Ajustar usuario',
                        'errors' => $_errors,
                        'usuario' => $usuario,
                        'sanitized' => (object) $sanitized
                    );
                    $this->view->showViews(array('templates/header.view.php', 'usuariosistema.edit.view.php', 'templates/footer.view.php'), $_vars);

                } else {
                    //comprobaciones por si hay que cambiar las tablas de rol
                    $lastRol = $model->getUserById($_POST['idUsuario']);


                    $exito = $model->updateUsuario((int) $_POST['idUsuario'], $_POST['email'], $_POST['nombre'], $_POST['password'], $_POST['rol'], $lastRol->getRol());
                    if ($exito) {
                        header('location: index.php');
                    } else {
                        $usuario = $model->getUserById($_POST['idUsuario']);
                        $sanitized = (object) $usuario;
                        $_vars = array(
                            'titulo' => 'Ajustar usuario',
                            'errors' => $_errors,
                            'sanitized' => (object) $sanitized,
                            'usuario' => $usuario
                        );
                        $this->view->showViews(array('templates/header.view.php', 'usuariosistema.edit.view.php', 'templates/footer.view.php'), $_vars);
                    }
                }
            } else if (isset($_GET['idUsuario'])) {
                $model = new UsuarioModel();
                $usuario = $model->getUserById($_GET['idUsuario']);
                $_vars['usuario'] = (object) $usuario;
                $_vars['sanitized'] = (object) $usuario;
                $_vars['titulo'] = 'Ajustar usuario';

                $this->view->showViews(array('templates/header.view.php', 'usuariosistema.edit.view.php', 'templates/footer.view.php'), $_vars);
            } else {
                header("location: index.php");
            }
        } else {
            header("location: index.php");
        }

    }
    //REVISAR
    public function asignarcliente()
    {
        if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) {
            $clave = "clave_cifrado01";
            $iv = "5a2c7a618e546f0f";
            $UserModel = new UsuarioModel();

            $clientes = $UserModel->getAllUserClienteswithNotIdCoach();
            $misClientes = $UserModel->getAllUserByIdCoach((int) $_SESSION['usuario']['idDatosUsuario']);

            $idsAEliminarDeLaVista = array_map(function ($obj) {
                return $obj->getidUsuario();
            }, $misClientes);

            $clientes = array_filter($clientes, function ($usuario) use ($idsAEliminarDeLaVista) {
                return !in_array($usuario->getidUsuario(), $idsAEliminarDeLaVista);
            });

            $allClientes = array();
            foreach ($clientes as $Cliente) {
                $auxId = $Cliente->getidUsuario();
                $Cliente->setidUsuario(openssl_encrypt($auxId, 'aes-256-cbc', $clave, 0, $iv));
                $allClientes[] = (object) $Cliente;
            }
            $datos = $misClientes;
            foreach ($datos as $Cliente) {
                $auxId = $Cliente->getidUsuario();
                $Cliente->setidUsuario(openssl_encrypt($auxId, 'aes-256-cbc', $clave, 0, $iv));
            }

            $_vars = array(
                'titulo' => 'Mis clientes',
                'allClientes' => $allClientes,
                'misClientes' => (object) $datos,
                'js' => array('assets/js/manejoDeTablasAsignar.js', 'assets/js/filtroTableEjercicio.js', 'assets/js/datosTablaAsignar.js')
            );

            if (isset($_POST["action"])) {

                $_idsClientes = json_decode($_POST["datosTabla"]);
                $error = false;
                $datosIdsDescriptados = array();
                foreach ($_idsClientes as $cliente) {
                    $cliente = openssl_decrypt($cliente, 'aes-256-cbc', $clave, 0, $iv);
                    $datosIdsDescriptados[] = $cliente;
                    $comprobarSiTineneEntrenador = $UserModel->getUserCoachById((int) $cliente);

                    if ($comprobarSiTineneEntrenador == null) {
                        $error = true;
                    }

                }
                foreach ($misClientes as $Cliente) {
                    $auxId = $Cliente->getidUsuario();
                    $Cliente->setidUsuario(openssl_decrypt($auxId, 'aes-256-cbc', $clave, 0, $iv));
                }
                //hacer comprobaciones para ver si quite alguno de los que tenia
                $misClientesIds = array_column($misClientes, 'idUsuario');


                $clientesPonerAnull = array_diff($misClientesIds, $datosIdsDescriptados);

                $exitoClienteNull = true;
                if (!empty($clientesPonerAnull)) {
                    //dponerNUllosIds
                    $exitoClienteNull = $UserModel->asignarClientenCoachNULL($clientesPonerAnull);
                }
                if ($error) {
                    $_vars['errors'] = "error al intentar guardad seguramente por que uno de los usuarios ya tinene un entrenador ";
                } else {
                    //revisar
                    $_vars['datos'] = $_idsClientes;
                    $exitoAsignarEntrenador = $UserModel->asignarCliente((int) $_SESSION['usuario']['idDatosUsuario'], $datosIdsDescriptados);
                    if ($exitoAsignarEntrenador && $exitoClienteNull) {
                        header('location: ./?controller=usuario&action=asignarCliente');
                    } else {
                        $_vars['errors'] = array('nombre' => 'Error indeterminado al guardar');
                    }
                }

            }
            $this->view->showViews(array('templates/header.view.php', 'usuario.asignar.view.php', 'templates/footer.view.php'), $_vars);
        } else {
            header("location: index.php");
        }


    }
    public function deleUser()
    {
        if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'admin')) {
            $model = new UsuarioModel();
            $idUsuario = $_GET['id'];
            if (!empty($idUsuario)) {
                try {
                    if ($model->delete((int) $idUsuario)) {
                        header('location: ./?controller=usuario&action=index');
                        die;
                    } else {
                    }
                } catch (\PDOException $ex) {
                }
            } else {
            }
        } else {
            header("location: index.php");
        }
    }
    public function logOut()
    {
        if (isset($_SESSION['usuario'])) {
            session_destroy();
            header('location: ./');
            die;

        } else {
            header('location: ./');
            die;
        }
    }
    public function login()
    {
        if (isset($_SESSION['usuario'])) {

            header('location: ./');
            die;
        } elseif (!isset($_POST['login'])) {
            $this->view->showViews(array('login.view.php'), []);
        } else {
            $_errors = $this->checkErrorsLogin($_POST);
            if (count($_errors) == 0) {
                $usuarioModel = new UsuarioModel;
                $_usuario = $usuarioModel->login($_POST['email'], $_POST['password']);
                if (is_null($_usuario)) {
                    //Error
                    $_errors['email'] = 'Datos de acceso incorrectos';
                    $this->view->showViews(array('login.view.php'), ['errors' => $_errors, 'email' => htmlspecialchars($_POST['email'])]);
                } else {
                    //Caso de éxito
                    $_SESSION['usuario'] = $_usuario;

                    header('location: ./index.php');
                    die;
                }
            } else {
                $_errors['email'] = 'Inserte un email';
                $this->view->showViews(array('login.view.php'), ['errors' => $_errors, 'email' => htmlspecialchars($_POST['email'])]);
            }
        }

    }
    private function checkErrorsLogin(array $_datos): array
    {
        $_errors = [];
        if (!filter_var($_datos['email'], FILTER_VALIDATE_EMAIL)) {
            $_errors['email'] = 'Inserte un email válido';
        }
        return $_errors;
    }
    private static function sanitizar(array $_datos): object
    {
        $_datos = filter_var_array($_datos, FILTER_SANITIZE_SPECIAL_CHARS);
        $usuario = new Usuario($_datos["nombre"], $_datos["rol"], $_datos["email"], $_datos["password"], "");
        return $usuario;

    }

    private function checkErrores(array $_datos, int $userId = null)
    {
        $_errors = array();
        if ($_datos["nombre"] != filter_var($_datos['nombre'], FILTER_SANITIZE_SPECIAL_CHARS))
            $_errors["nombre"] = "No estan permitido los caracteres especiales";
        if (empty($_datos["nombre"])) {
            $_errors["nombre"] = "Este campo esta vacio";
        }
        if (!filter_var($_datos['email'], FILTER_VALIDATE_EMAIL)) {
            $_errors['email'] = "Email no valido";
        }
        if (empty($_datos["email"])) {
            $_errors["email"] = "Este campo esta vacio";
        }
        $usuarioModel = new UsuarioModel();
        $correosDeUsuario = $usuarioModel->getAllUsuarios();
        $exists = false; // Variable para indicar si el correo existe
        foreach ($correosDeUsuario as $Email) {
            //con esto compruebo tanto para los nuevos usuarios como para los que ya tenga cuenta si sus correos estan repetidos
            if ($Email['email'] === $_POST["email"] && $Email['idDatosUsuario'] !== $userId) {
                $exists = true;
                break; // Si se encuentra una coincidencia, se detiene el bucle
            }
        }

        if ($exists) {
            $_errors["email"] = "Este email ya tiene una cuenta";
        }

        if ($_datos["password"] != filter_var($_datos['password'], FILTER_SANITIZE_SPECIAL_CHARS)) {
            $_errors["password"] = "No estan permitido los caracteres especiales";
            $_errors["password2"] = "No estan permitido los caracteres especiales";

        }
        if ($_datos["password"] != $_datos["password2"]) {
            $_errors["password"] = "No coiciden las contraseñas";
            $_errors["password2"] = "No coiciden las contraseñas";

        }
        if ($_datos["password"] < 5) {
            $_errors["password"] = "La contraseña tiene que tener como minimo 5 caracteres";
            $_errors["password2"] = "La contraseña tiene que tener como minimo 5 caracteres";

        }
        $_campos = array(
            'nombre' => 25,
            'email' => 120,
            'password' => 15,

        );

        foreach ($_campos as $key => $value) {
            if (strlen($_datos[$key]) > $value) {
                $_errors[$key] = "El tamaño máximo permito es $value";
            }
        }
        return $_errors;

    }
}