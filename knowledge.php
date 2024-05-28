<!DOCTYPE html>
<html data-bs-theme="light" lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Knowledge base - Tipo-knowledgebase.ru</title>
    <meta property="og:url" content="https://Tipo-knowledgebase.ru.ru/">
    <meta property="og:type" content="website">
    <link rel="canonical" href="https://Tipo-knowledgebase.ru.ru/">
    <script src="https://cdn.tiny.cloud/1/2j1e7sbzxy30toy64qjubq0smr1tqphk53pwlewfj8c5ekne/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "name": "Tipo-knowledgebase.ru",
            "url": "https://Tipo-knowledgebase.ru.ru"
        }
    </script>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Nunito.css">
    <link rel="stylesheet" href="assets/css/sidebar-collapse.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <script src="assets/js/search.js"></script>
</head>

<body id="page-top">

<?php
    require_once(dirname(__FILE__) ."/assets/php/f-common.php");
    require_once dirname(__FILE__) ."/assets/php/f-tree.php";
    require_once dirname(__FILE__) ."/assets/php/f-knowledge.php";

    require dirname(__FILE__) ."/assets/php/f-auth.php";

    # $search_results = searchKnowledge($search_query);
    if ($auth_valid) {
        $knowledge_tree = getKnowledgeTree($userId);
        $knowledgeId = $_GET['id'] ?? '';
        $knowledgeInfo = getKnowledge($knowledgeId, $userId)[0];
    }
   
?>


    <div id="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4>Tipo knowldgeBase</h4>
        </div>
        <ul class="list-unstyled components">
            <li> 
                <a class="list-group-item" href="index.php">
                    <i class="fas fa-tachometer-alt"> </i><span> Dashboard</span>
                </a>
        </li>
        <?php echo renderKnowledgeTree($knowledge_tree);?>
    </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid">
                        <button class="btn btn-link rounded-circle me-3" id="sidebarCollapse" type="button"><i class="fas fa-bars"></i></button>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group" style="position: relative;">
                            <input id="search-box" class="bg-light form-control border-0 small" type="text" placeholder="Поиск...">
                            <div id="suggestions-container" class="list-group position-absolute" style="max-height: 200px; overflow-y: auto; width: 100%; z-index: 1;"></div>
                        </div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                                <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                        <form class="me-auto navbar-search w-100">
                                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                <div class="d-none d-sm-block topbar-divider"></div>
                                <li class="nav-item dropdown no-arrow">
                                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" id="login-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php echo $username;?></span><img class="border rounded-circle img-profile" src="<?php echo $avatar_path;?>"></a>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                            <?php if ($auth_valid) { ?>
                                                    <a id="logout-btn" class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                                <?php } else { ?>
                                                    <a id="login-btn" class="dropdown-item" href="login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Login</a>
                                                    <a id="register-btn" class="dropdown-item" href="register.php"><i class="fas fa-address-card fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Registration</a>
                                                <?php }
                                            ?> 
                                        </div>
                                    </div>
                                </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="text-dark mb-0"><?=$knowledgeInfo["title"]?></h2>
                        <div>
                        <button type="button" id="validateKnowledge" class="btn btn-success btn-sm">Одобрить знание</button>
                        <button type="button" id="confirmDelete" class="btn btn-danger btn-sm">Удалить знание</button>
                        </div>
                    </div>
                    <ol class="breadcrumb"> 
                        <?php 
                        $breadcrumbs = generateBreadcrumbs($knowledgeInfo["id"]);
                        foreach ($breadcrumbs as $key) {
                            echo "<li class=\"breadcrumb-item\"><span>". $key ."</span></li>";
                        }
                        ?>
                    </ol>
                    <!-- Дополнительные теги и информация -->
                    <div class="container-fluid">  
                        <span class="tag"><?php 
                            echo $knowledgeInfo["knowledge_type"] == "Common" ? "Ответил оператор" : "ML";
                        ?></span> 
                        <span class="tag"><?=$knowledgeInfo["lang"]?></span> 
                        <span class="tag"><?=$knowledgeInfo["channel"]?></span>
                    </div>
                        
                        <div class="container-fluid">  
                            <p class="col-12" readonly=""><span> Имя пользователя: </span> <?=$knowledgeInfo["user_name"]?></p>
                            <p class="col-12" readonly=""><span> Оценка: </span> <?php for ($i=0; $i<=$knowledgeInfo["rating"]; $i++) { echo "<i class=\"fa fa-star\" style=\"color: #7285D5FC;\" aria-hidden=\"true\"></i>"; }?></p>
                            <p class="col-12" readonly=""><span> Общее знание: </span> <?php if ($knowledgeInfo["popularity"] == 1) {echo "Да";} else {echo "Нет";}?></p>
                            <p class="col-12" readonly=""><span> Ссылка на тикет: </span> <a style="text-decoration:underline;" href="https://mybestcrm.ru/ticket/<?=$knowledgeInfo["ticketId"]?>"><?=$knowledgeInfo["ticketId"]?></a></p>
                            <p class="col-12" readonly=""><span> Знание одобрено: </span> <?php if ($knowledgeInfo["isValid"] == 1) {echo "<i class=\"fa fa-check-circle\" style=\"color: #7285D5FC;\"></i>";} else {echo "<i class=\"fa fa-times-circle\" style=\"color: #7285D5FC;\"></i>";}?></p>
                            <p class="col-12" readonly=""><span> Уже использовалось в обучении: </span> <?php if ($knowledgeInfo["used"] == 1) {echo "Да";} else {echo "Нет";}?></p>
                            <p class="col-12" readonly=""><span> Знание создано: </span> <?=$knowledgeInfo["created_at"]?></p>
                            <p class="col-12" readonly=""><span> Последний раз обновляли: </span> <?=$knowledgeInfo["updated_at"]?></p>
                        </div>
                        <!--/tags-->
                        <h4 class="text-dark mb-0">Проблема пользователя</h4> 
                        <div class="container-fluid">
                            <form id="editProblemForm" method="POST" action="editKnowledge.php">
                                <input type="hidden" name="knowledgeId" value="<?=$knowledgeInfo['id']?>" />
                                <button type="button" id="editProblemButton" style="border:none; background-color: inherit;"><i class="fas fa-pencil-alt"></i> Редактировать</button>
                                <button type="submit" id="saveProblemButton" style="display: none; border:none; background-color: inherit;"><i class="fas fa-save"></i> Сохранить</button>
                                <textarea id="problemArea" name="problemText" class="autoExpand col-12 bg-secondary-subtle border rounded-0 border-3 form-control-lg float-start flex-fill justify-content-xxl-start align-items-xxl-start" readonly style="text-align: justify;position: relative;">
                                    <?=$knowledgeInfo["problem"]?>
                                </textarea>
                            </form>
                        </div>

                        <h4 class="text-dark mb-0">Решение проблемы</h4> 
                        <div class="container-fluid">
                            <form id="editSolutionForm" method="POST" action="editKnowledge.php">
                                <input type="hidden" name="knowledgeId" value="<?=$knowledgeInfo['id']?>" />
                                <button type="button" id="editSolutionButton" style="border:none; background-color: inherit;"><i class="fas fa-pencil-alt"></i> Редактировать</button>
                                <button type="submit" id="saveSolutionButton" style="display: none; border:none; background-color: inherit;"><i class="fas fa-save"></i> Сохранить</button>
                                <textarea id="solutionArea" name="solutionText" class="autoExpand col-12 bg-secondary-subtle border rounded-0 border-3 form-control-lg float-start flex-fill justify-content-xxl-start align-items-xxl-start" readonly style="text-align: justify;position: relative;">
                                    <?=$knowledgeInfo["solution"]?>
                                </textarea>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- toasts -->
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div id="errorToast" class="toast text-danger" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                        <strong class="me-auto">Ошибочка вышла</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                        <!-- Сообщение об ошибке будет вставлено сюда -->
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Tipo-knowledgebase.ru 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sidebar-collapse.js"></script>
    <script src="assets/js/knowledge.js"></script>
    <script src="assets/js/common.js"></script>
    <script>
    //problem button
    tinymce.init({
        selector: '#problemArea',
        readonly: true,
        menubar: true,
        toolbar: false,
        images_upload_handler: () => Promise.reject({ remove: true }),
        content_style: "body { background-color: #e7e7ea; color: #999999}",
        plugins: 'autoresize', 
        autoresize_min_height: 100,
        autoresize_max_height: 600
    });

    document.getElementById('editProblemButton').addEventListener('click', function() {
        // Показываем панель инструментов и меню
        tinymce.get('problemArea').mode.set("design");
        //tinymce.get('#problemArea').focus();
        document.getElementById('saveProblemButton').style.display = 'block';
        document.getElementById('editProblemButton').style.display = 'none';
    });

    document.getElementById('saveProblemButton').addEventListener('click', function(event) {
        event.preventDefault();
        // Сохраняем данные из TinyMCE обратно в textarea
        tinymce.triggerSave();
        let formData = new FormData(document.getElementById('editProblemForm'));

        fetch('assets/php/editKnowledge.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload(); // Перезагрузка страницы
            } else {
                // Получаем элементы тоста и устанавливаем сообщение об ошибке
                let errorToast = document.getElementById('errorToast');
                let errorToastBody = errorToast.querySelector('.toast-body');
                errorToastBody.textContent = data.error;

                // Инициализация тоста Bootstrap
                let bsToast = new bootstrap.Toast(errorToast);

                // Показываем тост с ошибкой
                bsToast.show();
            }
        })
        .catch(error => console.error('Error:', error));
    });
    </script>
    <script>
    //solution button
    tinymce.init({
        selector: '#solutionArea',
        readonly: true,
        menubar: true,
        toolbar: false,
        images_upload_handler: () => Promise.reject({ remove: true }),
        content_style: "body { background-color: #e7e7ea; color: #999999}",
        plugins: 'autoresize', 
        autoresize_min_height: 100,
        autoresize_max_height: 600
    });

    document.getElementById('editSolutionButton').addEventListener('click', function() {
        tinymce.get('solutionArea').mode.set("design");
        document.getElementById('saveSolutionButton').style.display = 'block';
        document.getElementById('editSolutionButton').style.display = 'none';
    });

    document.getElementById('saveSolutionButton').addEventListener('click', function(event) {
    event.preventDefault();
    tinymce.triggerSave();
    let formData = new FormData(document.getElementById('editSolutionForm'));

    fetch('assets/php/editKnowledge.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            // Получаем элементы тоста и устанавливаем сообщение об ошибке
            let errorToast = document.getElementById('errorToast');
            let errorToastBody = errorToast.querySelector('.toast-body');
            errorToastBody.textContent = data.error;

            // Инициализация тоста Bootstrap
            let bsToast = new bootstrap.Toast(errorToast);

            // Показываем тост с ошибкой
            bsToast.show();
        }
    })
        .catch(error => console.error('Error:', error));
    });
    </script>
    <script>
        //delete knowledge
        document.getElementById('confirmDelete').addEventListener('click', function() {
            var knowledgeId = new URLSearchParams(window.location.search).get('id');

            fetch('assets/php/delete-knowledge.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + knowledgeId
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.href = '/'; // или другая страница
                } else {
                    alert('Произошла ошибка при удалении: ' + data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>