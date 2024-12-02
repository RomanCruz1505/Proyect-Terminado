<?php
// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "base_producto_integrador";
$username = "root"; // Cambia esto según tu configuración
$password = "";     // Cambia esto según tu configuración

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Procesar datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $mensaje = htmlspecialchars($_POST["message"]);

    // Insertar datos en la base de datos
    $sql = "INSERT INTO contactos (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':mensaje' => $mensaje,
        ]);
        echo "Mensaje enviado con éxito.";
    } catch (PDOException $e) {
        echo "Error al enviar el mensaje: " . $e->getMessage();
    }
}
?>
