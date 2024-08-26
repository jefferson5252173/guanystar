<?php
// Conexión con la base de datos (ajusta según tu configuración)
$conn = new mysqli('localhost', 'username', 'password', 'database');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = (int)$_POST['postId'];
    $content = $conn->real_escape_string($_POST['content']);

    $sql = "INSERT INTO comments (post_id, content) VALUES ('$postId', '$content')";
    if ($conn->query($sql) === TRUE) {
        echo "Comentario guardado correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>