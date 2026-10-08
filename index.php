<?php
// SUSTITUYE este fichero por tu index.php de la práctica P2 si ya lo tienes.
require __DIR__ . '/conexion.php';

$error = '';
try {
    $pdo = obtenerConexion();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario     = trim($_POST['usuario'] ?? '');
        $equipo      = trim($_POST['equipo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if ($usuario !== '' && $equipo !== '' && $descripcion !== '') {
            $stmt = $pdo->prepare(
                'INSERT INTO incidencias (usuario, equipo, descripcion)
                 VALUES (:usuario, :equipo, :descripcion)'
            );
            $stmt->execute([
                ':usuario' => $usuario,
                ':equipo' => $equipo,
                ':descripcion' => $descripcion,
            ]);
            header('Location: index.php');
            exit;
        }
        $error = 'Rellena todos los campos.';
    }

    $incidencias = $pdo->query(
        'SELECT id, usuario, equipo, descripcion, fecha FROM incidencias ORDER BY id DESC'
    )->fetchAll();
} catch (Throwable $e) {
    $incidencias = [];
    $error = 'No se pudo conectar con la base de datos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Incidencias</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Gestión de incidencias</h1>

    <?php if ($error !== ''): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="index.php">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="text" name="equipo" placeholder="Equipo" required>
        <textarea name="descripcion" placeholder="Descripción" required></textarea>
        <button type="submit">Registrar incidencia</button>
    </form>

    <?php if (count($incidencias) === 0): ?>
        <p>No hay incidencias.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>ID</th><th>Usuario</th><th>Equipo</th><th>Descripción</th><th>Fecha</th></tr>
            </thead>
            <tbody>
            <?php foreach ($incidencias as $i): ?>
                <tr>
                    <td><?= (int)$i['id'] ?></td>
                    <td><?= htmlspecialchars($i['usuario']) ?></td>
                    <td><?= htmlspecialchars($i['equipo']) ?></td>
                    <td><?= htmlspecialchars($i['descripcion']) ?></td>
                    <td><?= htmlspecialchars($i['fecha']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
