<?php
// Conexión con la base de datos (ajusta según tu configuración)
$conn = new mysqli('localhost', 'username', 'password', 'database');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $conn->real_escape_string($_POST['content']);

    $sql = "INSERT INTO posts (content) VALUES ('$content')";
    if ($conn->query($sql) === TRUE) {
        echo "Publicación guardada correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>