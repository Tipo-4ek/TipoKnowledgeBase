$(document).ready(function() {
    $('#logout-btn').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'assets/php/f-logout.php',
            type: 'POST',
            success: function() {
                // перенаправляем пользователя на главную страницу после выхода
                window.location.href = '/';
            },
            error: function(error) {
                // обрабатываем ошибку здесь...
                console.error(error);
            }
        });
    });
});