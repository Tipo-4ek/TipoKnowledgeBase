<!DOCTYPE html>
<html data-bs-theme="light" lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Регистрация - Tipo-knowledgebase</title>
    <link rel="canonical" href="https://Tipo-knowledgebase.ru.ru/register.php">
    <meta property="og:url" content="https://Tipo-knowledgebase.ru.ru/register.php">
    <meta property="og:type" content="website">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Nunito.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
</head>

<body class="bg-gradient-primary">
    <div class="container col-lg-6">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background-image: url(&quot;dogs/image2.jpeg&quot;);"></div>
                    </div>
                    <div class="">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Создать аккаут!</h4>
                            </div>
                            <form class="user" id="registerForm">
                                <div class="mb-3">
                                    <input class="form-control form-control-user" type="text" placeholder="Логин" name="username">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control form-control-user" type="password" placeholder="Пароль" name="password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="password" placeholder="Повторите пароль" name="password_repeat">
                                    </div>
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" type="submit">Создать аккаунт</button>
                            </form>
                            <div id="registerResult"></div>
                            <hr>
                            <div class="text-center"><a class="small" href="forgot-password.html">Забыли пароль?</a></div>
                            <div class="text-center"><a class="small" href="login.php">Уже есть аккаут? Заходите!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/register.js"></script>
</body>

</html>