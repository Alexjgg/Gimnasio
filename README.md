## General
Esta es una aplicación web diseñada para un gimnasio ficticio que ofrece un sistema de gestión de entrenamientos y ejercicios, administrado por los entrenadores de la plataforma.

- La plataforma incluye un sistema de inicio de sesión donde los administradores son responsables de crear cuentas para administradores, entrenadores y clientes, cada uno con roles y funciones específicas.

- Los entrenadores tienen la capacidad de crear, editar y eliminar ejercicios y entrenamientos. Es importante destacar que los entrenamientos son privados, mientras que los ejercicios son públicos, lo que significa que los entrenadores deben ser cuidadosos al eliminar o editar ejercicios.

- Además, los entrenadores pueden asignar y gestionar sus clientes, permitiéndoles asignar y retirar entrenamientos según sea necesario.

- Los clientes tienen acceso a una lista de sus entrenamientos y la posibilidad de ver en detalle un entrenamiento específico para llevarlo a cabo.

## Requerimientos Generales
- Se requiere un servidor que ejecute PHP 7.4 o una versión superior.
- Debe estar disponible un servidor de base de datos SQL donde podremos importar nuestra base de datos desde el archivo gimnasioBd.sql.

### Configuración General
- Es esencial importar el archivo gimnasioBd.sql en el servidor SQL para configurar la base de datos.
- Asegúrate de configurar el archivo config.php correctamente.
- Los usuarios pueden acceder a la web visitando la dirección: DirecciónDelServidor/ProyectoGimnasioAsneves/public/.
