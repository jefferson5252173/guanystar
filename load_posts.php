<?php
// Conexión con la base de datos (ajusta según tu configuración)
$conn = new mysqli('localhost', 'username', 'password', 'database');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='post-item' data-post-id='" . $row['id'] . "'>";
        echo "<p class='post-content'>" . htmlspecialchars($row['content']) . "</p>";

        // Agregar formulario de comentarios
        echo "<form class='comment-form'>";
        echo "<textarea placeholder='Escribe un comentario...'></textarea>";
        echo "<button type='submit' class='btn'>Comentar</button>";
        echo "</form>";

        // Agregar lista de comentarios
        echo "<div class='comment-list'>";

        // Cargar comentarios para esta publicación
        $postId = $row['id'];
        $commentSql = "SELECT * FROM comments WHERE post_id = $postId ORDER BY created_at DESC";
        $commentResult = $conn->query($commentSql);
        if ($commentResult->num_rows > 0) {
            while ($commentRow = $commentResult->fetch_assoc()) {
                echo "<div class='comment-item'>" . htmlspecialchars($commentRow['content']) . "</div>";
            }
        }

        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No hay publicaciones";
}

$conn->close();
?>