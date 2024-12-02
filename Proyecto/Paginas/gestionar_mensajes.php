<?php
// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "base_producto_integrador";
$username = "root"; // Cambia esto según tu configuración
$password = "";     // Cambia esto según tu configuración

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Manejo de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id_contacto = $_POST["id_contacto"];
    $nombre = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $mensaje = htmlspecialchars($_POST["message"]);

    $sql = "UPDATE contactos SET nombre = :nombre, email = :email, mensaje = :mensaje WHERE id_contacto = :id_contacto";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':mensaje' => $mensaje,
        ':id_contacto' => $id_contacto
    ]);
    echo "Mensaje actualizado con éxito.";
}

// Manejo de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $id_contacto = $_POST["id_contacto"];
    $sql = "DELETE FROM contactos WHERE id_contacto = :id_contacto";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_contacto' => $id_contacto]);
    echo "Mensaje eliminado con éxito.";
}

// Obtener todos los mensajes
$sql = "SELECT * FROM contactos ";
$mensajes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Estilos/lista.css">
    <script src="../JavasScripts/script.js"></script>

    <title>Gestión de Mensajes</title>
</head>
<body>
     <!-- Navbar Principal -->
     <header class="navbar">
        <div class="logo">Futbol para la gente</div>
        <nav>
            <ul>
                <li><a href="#home">Inicio</a></li>
                <li><a href="nosotros.html">Nosotros</a></li>              
                <li><a href="ligas.html">Ligas Mas Importantes</a></li>
                <li><a href="liga_mx.html">Liga MX</a></li>
                <li><a href="contacto.html">Contacto</a></li>
            </ul>
        </nav>
    </header>

    

    <section class="messages-section">
        <?php if (count($mensajes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Mensaje</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mensajes as $mensaje): ?>
                        <tr>
                            <form method="post">
                                <td>
                                    <input type="text" name="name" value="<?= htmlspecialchars($mensaje['nombre']) ?>" required>
                                </td>
                                <td>
                                    <input type="email" name="email" value="<?= htmlspecialchars($mensaje['email']) ?>" required>
                                </td>
                                <td>
                                    <textarea name="message" rows="2" required><?= htmlspecialchars($mensaje['mensaje']) ?></textarea>
                                </td>
                                <td>
                                    <input type="hidden" name="id_contacto" value="<?= $mensaje['id_contacto'] ?>">
                                    <button type="submit" name="update">Actualizar</button>
                                    <button type="submit" name="delete" class="delete-btn">Eliminar</button>
                                    </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay mensajes disponibles.</p>
        <?php endif; ?>
    </section>
</body>
</html>
