<?php
namespace Com\Daw2\Models;

use Com\Daw2\Helpers\Ejercicio;

class EjercicioModel extends \Com\Daw2\Core\BaseModel
{

    public function getAllEjercicios(): array
    {
        $stmt = $this->db->query("SELECT * FROM ejercicio");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getAllIdsEjercicios(): array
    {
        $stmt = $this->db->query("SELECT idEjercicio FROM ejercicio");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    private function rowToEjercicio(array $row): Ejercicio
    {
        $ejercicio = new Ejercicio($row['idEjercicio'], $row['nombre'], $row['descripcion'], $row['repeticiones'], $row['duracion']);
        return $ejercicio;
    }
    public function loadEjercicio(string $id): ?Ejercicio
    {
        $stmt = $this->db->prepare("SELECT * FROM ejercicio WHERE idEjercicio = ?");
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            return $this->rowToEjercicio($row);
        }
        return null;
    }
    public function getEjerciciosByName(string $nombre): array
    {
        $stmt = $this->db->prepare("SELECT * FROM ejercicio WHERE nombre like '%$nombre%' ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function insertEjercicio(string $nombre, string $descripcion, string $repeticiones, string $duracion): bool
    {
        $stmt = $this->db->prepare("INSERT INTO ejercicio (nombre, descripcion, repeticiones, duracion) VALUES(:nombre, :descripcion, :repeticiones, :duracion)");
        $res = $stmt->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'repeticiones' => $repeticiones,
            'duracion' => $duracion
        ]);

        return $res;
    }
    public function updateEjercicio(int $idEjercicio, string $nombre, string $descripcion, string $repeticiones, string $duracion): bool
    {
        $stmt = $this->db->prepare("UPDATE ejercicio SET nombre=:nombre, descripcion=:descripcion, repeticiones=:repeticiones, duracion=:duracion WHERE idEjercicio=:idEjercicio");
        $res = $stmt->execute([
            'idEjercicio' => $idEjercicio,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'repeticiones' => $repeticiones,
            'duracion' => $duracion
        ]);

        return $res;
    }
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE from ejercicio where idEjercicio = $id");
        $res = $stmt->execute();
        return $res;
    }

}