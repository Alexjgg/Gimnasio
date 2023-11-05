<?php
namespace Com\Daw2\Models;

use Com\Daw2\Helpers\Ejercicio;
use Com\Daw2\Helpers\Entrenamiento;
use Com\Daw2\Helpers\Usuario;

class EntrenamientoModel extends \Com\Daw2\Core\BaseModel
{

    public function getAllEntrenamientosByIdCoach(int $idEntrenador): array
    {
        $stmt = $this->db->prepare("SELECT * FROM entrenamiento WHERE entrenador = :id");
        $stmt->bindValue(':id', $idEntrenador, );
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getEntrenamientosByIdClient(int $idCliente): array
    {
        $stmt = $this->db->prepare("SELECT entrenamiento.*
        FROM gimnasiobd.cliente_has_entrenamientos
        JOIN gimnasiobd.entrenamiento ON cliente_has_entrenamientos.idEntrenamiento = entrenamiento.idEntrenamiento
        WHERE cliente_has_entrenamientos.idCliente = ?;");
        $stmt->execute([$idCliente]);

        return $stmt->fetchAll();
    }
    public function getaEjerciciosByIdEntrenamiento($idEntrenamiento)
    {
        $stmt = $this->db->prepare("SELECT Ejercicio.*
        FROM Ejercicio
        INNER JOIN Ejercicios_has_Entrenamientos ON ejercicio.idEjercicio = Ejercicios_has_Entrenamientos.idEjercicios
        INNER JOIN Entrenamiento ON Ejercicios_has_Entrenamientos.idEntrenamiento = Entrenamiento.idEntrenamiento
             WHERE Entrenamiento.idEntrenamiento = ? ");
        $stmt->execute([$idEntrenamiento]);

        $ejercicios = [];
        while ($row = $stmt->fetch()) {
            $ejercicio = $this->rowToEjercicio($row);
            $ejercicios[] = $ejercicio;
        }

        return $ejercicios;
    }
    private function rowToEntrenamiento(array $row)
    {
        $entrenamiento = new Entrenamiento($row['nombre'], $row['dia'], $row['entrenador'], $row['idEntrenamiento']);
        return $entrenamiento;
    }
    public function getEntrenamientoByIdEntrenamientoIdEntrenador(int $idEntrenador, $idEntrenamiento)
    {
        $stmt = $this->db->prepare("SELECT *
        FROM Entrenamiento
        WHERE idEntrenamiento = ? AND entrenador = ?");
        $stmt->execute([$idEntrenamiento, $idEntrenador]);
        $entrenamiento = $this->rowToEntrenamiento($stmt->fetch());
        return $entrenamiento;
    }
    public function getEjerciciosByName(string $idEntrenamiento): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS numEjercicios FROM Ejercicios_has_Entrenamientos WHERE idEntrenamiento = ?");
        $stmt->execute([$idEntrenamiento]);
        $result = $stmt->fetch();
        return $result['numEjercicios'];
    }
    public function insertEntrenamiento(string $nombre, string $dia, int $idEntrenador, array $idsEjercicios): bool
    {
        $stmt = $this->db->prepare("INSERT INTO Entrenamiento (nombre, dia, entrenador) VALUES(:nombre, :dia, :idEntrenador)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':dia', $dia);
        $stmt->bindParam(':idEntrenador', $idEntrenador);

        $res = $stmt->execute();
        $idEntrenamiento = $this->lastIdEntrenamiento();
        if ($res) {
            foreach ($idsEjercicios as $idEjercicio) {
                $stmt = $this->db->prepare("INSERT INTO Ejercicios_has_Entrenamientos (idEjercicios, idEntrenamiento) VALUES(:idEjercicio, :idEntrenamiento)");
                $stmt->bindParam(':idEjercicio', $idEjercicio);
                $stmt->bindParam(':idEntrenamiento', $idEntrenamiento);
                $res = $stmt->execute();
            }
        }

        return $res;
    }
    private function lastIdEntrenamiento(): int
    {
        $stmt = $this->db->query("SELECT idEntrenamiento FROM Entrenamiento ORDER BY idEntrenamiento DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    private function rowToEjercicio(array $row): Ejercicio
    {
        $ejercicio = new Ejercicio($row['idEjercicio'], $row['nombre'], $row['descripcion'], $row['repeticiones'], $row['duracion']);
        return $ejercicio;
    }
    public function getEjerciciosByidEntrenadorAndIdEntrenamiento(int $idEntrenador, int $idEntrenamiento): array
    {
        $stmt = $this->db->prepare("SELECT Ejercicio.*
        FROM Ejercicio
        INNER JOIN Ejercicios_has_Entrenamientos ON ejercicio.idEjercicio = Ejercicios_has_Entrenamientos.idEjercicios
        INNER JOIN Entrenamiento ON Ejercicios_has_Entrenamientos.idEntrenamiento = Entrenamiento.idEntrenamiento
        INNER JOIN Entrenador ON Entrenamiento.entrenador = Entrenador.idEntrenador
             WHERE Entrenamiento.idEntrenamiento = ? AND Entrenador.idEntrenador = ?");
        $stmt->execute([$idEntrenamiento, $idEntrenador]);

        $ejercicios = [];
        while ($row = $stmt->fetch()) {
            $ejercicio = $this->rowToEjercicio($row);
            $ejercicios[] = $ejercicio;
        }

        return $ejercicios;
    }
    public function deleteEjerciciosByIdsInEntrenamientos(int $idEntrenador, string $nombre, array $idsEjercicios)
    {
        $stmt = $this->db->prepare("DELETE FROM Ejercicios_has_Entrenamientos
        WHERE nombre = ? 
        AND Ejercicios_idEjercicios IN (" . implode(',', $idsEjercicios) . ")
        AND nombre IN (
            SELECT nombre
            FROM Entrenamiento
            WHERE nombre = ?
            AND entrenador = (
                SELECT idEntrenador
                FROM Entrenador
                WHERE idEntrenador = (
                    SELECT idEntrenador
                    FROM DatosUsuario
                    WHERE idEntrenador = ?
                )
            )
        )");

        $stmt->execute([$nombre, $nombre, $idEntrenador]);

    }
    public function updateEntrenamiento(string $dia, string $nombre, int $idEntrenador, string $idEntrenamiento, array $idEjercicios)
    {
        $stmt = $this->db->prepare("UPDATE Entrenamiento SET dia =?, nombre=? , idEntrenamiento = ?, entrenador = ? WHERE idEntrenamiento = ?");
        $res = $stmt->execute([$dia, $nombre, $idEntrenamiento, $idEntrenador, $idEntrenamiento]);

        if ($res) {
            // Eliminar los registros existentes de Ejercicios_has_Entrenamientos para este entrenamiento
            $stmt = $this->db->prepare("DELETE FROM ejercicios_has_entrenamientos WHERE idEntrenamiento = ?");
            $stmt->execute([$idEntrenamiento]);

            // Insertar los nuevos registros de Ejercicios_has_Entrenamientos para este entrenamiento
            foreach ($idEjercicios as $idEjercicio) {
                $stmt = $this->db->prepare("INSERT INTO ejercicios_has_entrenamientos (idEjercicios, idEntrenamiento) VALUES (?, ?)");
                $stmt->execute([$idEjercicio, $idEntrenamiento]);
            }
        }
        return $res;
    }
    public function insertarEntrenamiento(array $idclientesInsertar, int $idEntrenamiento)
    {
        $success = true; // Inicializa a true
        foreach ($idclientesInsertar as $Cliente) {

            $stmt = $this->db->prepare("INSERT IGNORE INTO cliente_has_entrenamientos (idCliente, idEntrenamiento) VALUES (:idCliente, :idEntrenamiento);");
            $res = $stmt->execute(['idCliente' => (int) $Cliente, 'idEntrenamiento' => $idEntrenamiento]);
            // Verifica si la ejecución de la consulta fue exitosa en cada iteración
            if ($res === false) {
                $success = false; // Cambia a false si hay un fallo en alguna de las consultas
            }
        }
        return $success;
    }
    public function quitarEntrenamiento(array $clientesQuitar, int $idEntrenamiento)
    {
        $success = true; // Inicializa a true
        foreach ($clientesQuitar as $Cliente) {

            $stmt = $this->db->prepare("DELETE FROM cliente_has_entrenamientos WHERE idCliente = :idCliente AND idEntrenamiento = :idEntrenamiento;");
            $res = $stmt->execute(['idCliente' => $Cliente, 'idEntrenamiento' => $idEntrenamiento]);
            // Verifica si la ejecución de la consulta fue exitosa en cada iteración
            if ($res === false) {
                $success = false; // Cambia a false si hay un fallo en alguna de las consultas
            }

        }
        return $success;
    }
    public function delete(int $idEntrenamiento, int $idEntrenador): bool
    {
        $stmt = $this->db->prepare("DELETE FROM Entrenamiento WHERE idEntrenamiento = ? AND entrenador = ?");
        $res = $stmt->execute([$idEntrenamiento, $idEntrenador]);
        return $res;
    }

}