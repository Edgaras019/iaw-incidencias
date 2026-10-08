<?php
// SUSTITUYE este fichero por tu conexion.php de la práctica P2 si ya lo tienes.
// Lee los datos de conexión de variables de entorno y, si no existen,
// usa valores por defecto para el servidor local.

function obtenerConexion(): PDO
{
    $host = getenv('DB_HOST') ?: 'localhost';
    $db   = getenv('DB_NAME') ?: 'incidencias';
    $user = getenv('DB_USER') ?: 'app_incidencias';
    $pass = getenv('DB_PASS') ?: 'cambia_esta_clave';

    return new PDO(
        "mysql:host={$host};dbname={$db};charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
}
