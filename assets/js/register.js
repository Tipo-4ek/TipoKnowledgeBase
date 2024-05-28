$(document).ready(function(){
    $("#registerForm").on("submit", function(e) {
        e.preventDefault();  // отменяем стандартное поведение формы

        $.ajax({
            url: 'assets/php/f-register.php',  // пропишите путь до вашего PHP файла
            type: 'post',
            data: $(this).serialize(),  // сериализуем данные формы
            success: function(result){
                // Выводим результат в div с id="registerResult"
                $('#registerResult').html(result);
            }
        });
    });
});