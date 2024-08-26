document.addEventListener('DOMContentLoaded', function() {
    const postForm = document.getElementById('postForm');
    const postContent = document.getElementById('postContent');
    const postList = document.getElementById('postList');

    function loadPosts() {
        fetch('load_posts.php')
            .then(response => response.text())
            .then(data => {
                postList.innerHTML = data;
                addCommentHandlers(); // Añadir manejadores de comentarios después de cargar publicaciones
            });
    }

    function addCommentHandlers() {
        const commentForms = document.querySelectorAll('.comment-form');
        commentForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const commentContent = form.querySelector('textarea').value.trim();
                const postItem = form.closest('.post-item');
                const postId = postItem.dataset.postId;
                if (commentContent) {
                    fetch('save_comment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'postId': postId,
                            'content': commentContent
                        })
                    })
                    .then(response => response.text())
                    .then(() => {
                        loadPosts(); // Recargar publicaciones después de guardar el comentario
                    });
                    form.querySelector('textarea').value = ''; // Limpiar el campo de comentario
                }
            });
        });
    }

    postForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const content = postContent.value.trim();
        if (content) {
            fetch('save_post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'content': content
                })
            })
            .then(response => response.text())
            .then(() => {
                loadPosts(); // Recargar publicaciones después de guardar
            });
            postContent.value = ''; // Limpiar el campo de publicación
        }
    });

    loadPosts(); // Cargar publicaciones al iniciar
});
