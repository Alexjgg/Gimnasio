<?php
$config = Com\Daw2\Core\Config::getInstance();

$config->set('APP_FOLDER', '../app/');
$config->set('DEFAULT_NAMESPACE', 'Com\Daw2\\');
$config->set('CONTROLLERS_NAMESPACE', $config->get('DEFAULT_NAMESPACE') . 'Controllers\\');
$config->set('MODELS_NAMESPACE', $config->get('DEFAULT_NAMESPACE') . 'Models\\');
$config->set('VIEWS_FOLDER', $config->get('APP_FOLDER') . 'Views/');
$config->set('DATA_FOLDER', $config->get('APP_FOLDER') . 'Data/');

$config->set('DEFAULT_CONTROLLER', 'Inicio');
$config->set('DEFAULT_ACTION', 'index');

//Si estamos en producion esto se cambia a false
$config->set('DEBUG', true);

//La direcion de nuestra base de datos cambiar si tu servidor no esta en localhost
$config->set('dbhost', 'localhost');
//El schema de la base de datos que vamos a usar si importamos el archivo dado no hace falta cambiar
$config->set('dbname', 'gimnasiobd');
//El nombre de usuario que tiene un admin el la base de datos o al menos que tenga permisos para ver y modificar gimansiobd
$config->set('dbuser', 'root');
//La contraseña de el usuario
$config->set('dbpass', '');
$config->set('dbcharset', 'utf8mb4');

$config->set('emulado', false);