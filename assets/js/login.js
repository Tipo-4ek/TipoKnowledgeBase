$(document).ready(function(){
    $("#loginForm").on("submit", function(e) {
        e.preventDefault();  
        $.ajax({
            url: 'assets/php/f-login.php',
            type: 'post',
            data: $(this).serialize(), 
            success: function(result){
                $('#loginResult').html(result);
                if (result == "200") {
                    $('#loginResult').html("Авторизация успешна");
                    window.location.href = '/';
                }
                else if (result == "403") {
                    $('#loginResult').html("Логин или пароль неверны.");
                }
            }
        });
    });
});