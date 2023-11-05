## General
Esto es una web app creada para un gimnasio ficticio, con un sistema de entrenamientos y ejercicios gestionado por los entrenadores de la web.

- En esta web también hay un sistema de inicio de sesión donde los administradores son los encargados de crear las cuentas para los administradores, entrenadores y clientes, quienes tienen diferentes roles y funciones.

- Los entrenadores pueden crear, editar y eliminar ejercicios y entrenamientos. Es importante recalcar que los entrenamientos son privados, pero los ejercicios no. Esto significa que como entrenador, habría que evitar, dentro de lo posible, eliminar o editar un ejercicio.

- Los entrenadores también pueden asignar y designar a sus clientes, a quienes a su vez se les pueden asignar o quitar entrenamientos.

- Los clientes solo tienen la opción de ver una lista con sus entrenamientos y ver un entrenamiento en concreto para poder realizarlo.

## Requerimientos Generales
- Un servidor con PHP 7.4 o superior.
- Un servidor de base de datos SQL donde importaremos nuestra base de datos gimnasioBd.sql.

### Configuración General
- Importar el archivo gimnasioBd.sql en el servidor SQL.
- Configurar nuestro archivo config.php.
- La dirección para ver la web será DirecciónDelServidor/ProyectoGimnasioAsneves/public/.

