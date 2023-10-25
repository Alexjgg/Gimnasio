<?php
namespace Com\Daw2\Models;

use Com\Daw2\Helpers\Usuario;
use PDO;

class UsuarioModel extends \Com\Daw2\Core\BaseModel
{

    public function getAllUsuarios(): array
    {
        $stmt = $this->db->query("SELECT * FROM datosusuario");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getAllUserClientes(): array
    {
        $stmt = $this->db->query("SELECT du.nombre, du.rol, du.email, du.pass, du.idDatosUsuario
        FROM datosUsuario du
        JOIN cliente c ON du.idDatosUsuario = c.idCliente");
        $usuarios = [];

        while ($row = $stmt->fetch()) {
            $usuario = $this->rowToUsuario($row);
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }
    public function getAllUserClienteswithNotIdCoach()
    {
        $stmt = $this->db->query("SELECT du.nombre, du.rol, du.email, du.pass, du.idDatosUsuario
        FROM datosUsuario du
        JOIN cliente c ON du.idDatosUsuario = c.idCliente
        WHERE c.idEntrenador IS NULL");
        $usuarios = [];

        while ($row = $stmt->fetch()) {
            $usuario = $this->rowToUsuario($row);
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }
    public function getUsuariosByName($nombre): array
    {
        $stmt = $this->db->query("SELECT * FROM datosusuario where nombre like '%$nombre%' ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getAllUserByIdCoach(int $idEntrenador)
    {
        $stmt = $this->db->prepare("SELECT du.nombre, du.rol, du.email, du.pass, du.idDatosUsuario
        FROM datosUsuario du
        JOIN cliente c ON du.idDatosUsuario = c.idCliente
        JOIN entrenador e ON c.idEntrenador = e.idEntrenador
        WHERE e.idEntrenador = ?");
        $stmt->execute([$idEntrenador]);
        $usuarios = [];

        while ($row = $stmt->fetch()) {
            $usuario = $this->rowToUsuario($row);
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }
    public function getAllUserByIdCoachAndIdEntrenamiento(int $idEntrenador, int $idEntrenamiento)
    {
        $stmt = $this->db->prepare("SELECT du.nombre, du.rol, du.email, du.pass, du.idDatosUsuario
        FROM datosUsuario du
        JOIN Cliente c ON du.idDatosUsuario = c.idCliente
        JOIN Entrenador e ON c.idEntrenador = e.idEntrenador
        JOIN Cliente_has_Entrenamientos ce ON c.idCliente = ce.idCliente
        JOIN Entrenamiento ent ON ce.idEntrenamiento = ent.idEntrenamiento
        WHERE e.idEntrenador = ? AND ent.idEntrenamiento = ?;");
        $stmt->execute([$idEntrenador, $idEntrenamiento]);
        $usuarios = [];
        while ($row = $stmt->fetch()) {

            $usuario = $this->rowToUsuario($row);
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }

    private function rowToUsuario(array $row): Usuario
    {
        $usuario = new usuario($row['nombre'], $row['rol'], $row['email'], $row['pass'], $row['idDatosUsuario']);
        return $usuario;
    }
    public function getUserById(string $id): ?Usuario
    {
        $stmt = $this->db->prepare("SELECT * FROM datosusuario WHERE idDatosUsuario = ?");
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            return $this->rowToUsuario($row);
        }
        return null;
    }
    public function getUserCoachById(int $id)
    {
        $stmt = $this->db->prepare("SELECT idEntrenador FROM cliente WHERE idCliente = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
    public function asignarCliente(int $identrenador, array $idsClientes)
    {
        $success = true; // Inicializa a true

        foreach ($idsClientes as $idCliente) {
            $stmt = $this->db->prepare("UPDATE cliente SET idEntrenador = :identrenador WHERE cliente.idCliente = :idCliente;");
            $res = $stmt->execute([
                'idCliente' => (int) $idCliente,
                'identrenador' => $identrenador
            ]);

            // Verifica si la ejecución de la consulta fue exitosa en cada iteración
            if ($res === false) {
                $success = false; // Cambia a false si hay un fallo en alguna de las consultas
            }
        }

        return $success;
    }
    public function asignarClientenCoachNULL(array $idsClientes)
    {
        $success = true; // Inicializa a true
        foreach ($idsClientes as $idCliente) {
            $stmt = $this->db->prepare("UPDATE cliente  SET idEntrenador = NULL WHERE cliente.idCliente = :idCliente;");
            $res = $stmt->execute([
                'idCliente' => $idCliente
            ]);
            // Verifica si la ejecución de la consulta fue exitosa en cada iteración
            if ($res === false) {
                $success = false; // Cambia a false si hay un fallo en alguna de las consultas
            }

        }
        return $success;
    }

    public function updateUsuario(int $idDatosUsuario, string $email, string $nombre, string $pass, string $rol, string $lastRol): bool
    {
        $stmt = $this->db->prepare("UPDATE datosusuario SET email = :email, nombre = :nombre, pass = :pass, rol = :rol WHERE datosusuario.idDatosUsuario = :idDatosUsuario");
        $res = $stmt->execute([
            'idDatosUsuario' => $idDatosUsuario,
            'email' => $email,
            'nombre' => $nombre,
            'pass' => $pass,
            'rol' => $rol
        ]);
        if ($lastRol != $rol) {
            if ($res) {
                //delete
                $row = '';
                if ($lastRol == 'cliente') {
                    $row = 'idCliente';
                }
                if ($lastRol == 'entrenador') {
                    $row = 'idEntrenador';
                }
                if ($lastRol == 'admin') {
                    $row = 'idAdmin';
                }
                $stmt = $this->db->prepare("DELETE from $lastRol where $row = $idDatosUsuario");
                $res = $stmt->execute();

                //insert
                $row = '';
                if ($rol == 'cliente') {
                    $row = 'idCliente';
                }
                if ($rol == 'entrenador') {
                    $row = 'idEntrenador';
                }
                if ($rol == 'admin') {
                    $row = 'idAdmin';
                }
                $stmt = $this->db->prepare("INSERT INTO $rol ($row) VALUES(:id)");
                $res = $stmt->execute([
                    'id' => $idDatosUsuario
                ]);

            }
        }
        return $res;

    }
    public function getUsuarioSistemaByEmail(string $email): array
    {
        $stmt = $this->db->prepare("SELECT * FROM datosusuario WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchAll();
    }

    public function insertUsuarioSistema(string $nombre, string $email, string $pass, string $rol): bool
    {
        $stmt = $this->db->prepare("INSERT INTO datosusuario (nombre, email, pass, rol) VALUES(:nombre, :email, :pass, :rol)");
        $res = $stmt->execute([
            'rol' => $rol,
            'email' => $email,
            'nombre' => $nombre,
            'pass' => $pass
        ]);
        // -No funciona-
        // password_hash($pass, PASSWORD_DEFAULT)
        //para saber que row es 
        $row = '';
        if ($rol == 'cliente') {
            $row = 'idCliente';
        }
        if ($rol == 'entrenador') {
            $row = 'idEntrenador';
        }
        if ($rol == 'admin') {
            $row = 'idAdmin';
        }
        if ($res) {
            $stmt = $this->db->prepare("SELECT idDatosUsuario from datosusuario order by idDatosUsuario desc limit 1");
            $stmt->execute();
            $id = $stmt->fetchAll();
            var_dump($id[0]["idDatosUsuario"]);
            $stmt = $this->db->prepare("INSERT INTO $rol ($row) VALUES(:id)");
            $res = $stmt->execute([
                'id' => $id[0]["idDatosUsuario"]
            ]);

        }
        return $res;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE from datosusuario where idDatosUsuario = $id");
        $res = $stmt->execute();
        return $res;
    }
    public function login(string $email, string $pass): ?array
    {
        $_usuario = $this->getUsuarioSistemaByEmail($email)[0];

        if (!empty($_usuario)) {

            var_dump($_usuario);
            if ($pass == $_usuario['pass']) {

                $_usuario['permisos'] = $_usuario['rol'];
                return $_usuario;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
}