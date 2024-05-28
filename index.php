<!DOCTYPE html>
<html data-bs-theme="light" lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Knowledge base - Tipo-knowledgebase.ru</title>
    <link rel="canonical" href="https://Tipo-knowledgebase.ru.ru/">
    <meta property="og:url" content="https://Tipo-knowledgebase.ru.ru/">
    <meta property="og:type" content="website">
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
    <script src="https://kit.fontawesome.com/17b40801c6.js" crossorigin="anonymous"></script>
    <script src="assets/js/search.js"></script>
</head>

<body id="page-top">

<?php

require(dirname(__FILE__) ."/assets/php/db.php");
require(dirname(__FILE__) ."/assets/php/f-common.php");
require dirname(__FILE__) ."/assets/php/f-tree.php";
require dirname(__FILE__) ."/assets/php/f-dashboard.php";
require dirname(__FILE__) ."/assets/php/f-auth.php";

# $search_results = searchKnowledge($search_query);
if ($auth_valid) {
    $knowledge_tree = getKnowledgeTree($userId);
}

?>


    <div id="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h4>Tipo knowldgeBase</h4>
            </div>
            <ul class="list-unstyled components">
            <li> 
                <a class="list-group-item active" href="index.php">
                    <i class="fas fa-tachometer-alt"></i><span> Dashboard</span>
                </a>
            </li>
            <?php echo renderKnowledgeTree($knowledge_tree);?>
            </ul>
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
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Dashboard</h3>
                        <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="/assets/php/generate-dataset.php"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Сформировать датасет для дообучения</a>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Знаний всего</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?=getKnowledgeCount()?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Знаний на дообучение</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>215</span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-minus-square fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-info py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Отвечено ML / Оператором</span></div>
                                            <div class="row g-0 align-items-center">
                                                <div class="col-auto">
                                                    <div class="text-dark fw-bold h5 mb-0 me-3"><span><?= getKnowledgeTypePercentage() ?>%</span></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm" style="background: rgb(234, 236, 244);">
                                                        <div class="progress-bar bg-info" aria-valuenow="<?= getKnowledgeTypePercentage() ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= getKnowledgeTypePercentage() ?>%;"><span class="visually-hidden"><?= getKnowledgeTypePercentage() ?>%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-info py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>НЕОТВЕЧЕННЫХ</span></div>
                                            <div class="row g-0 align-items-center">
                                                <div class="col-auto">
                                                    <div class="text-dark fw-bold h5 mb-0 me-3"><span>7%</span></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm" style="background: rgb(234, 236, 244);">
                                                        <div class="progress-bar bg-info" aria-valuenow="7" aria-valuemin="0" aria-valuemax="100" style="width: 7%;"><span class="visually-hidden">7%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Start: Chart -->
                    <div class="row">
                        <div class="col-lg-7 col-xl-8">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Оценки пользователей в отзывах</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                            <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" href="#">&nbsp;Action</a><a class="dropdown-item" href="#">&nbsp;Another action</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">&nbsp;Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="chart-area">
                                        <canvas id="chart-rating"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Сгенерировано знаний</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                            <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" href="#">&nbsp;Action</a><a class="dropdown-item" href="#">&nbsp;Another action</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">&nbsp;Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="chart-area">
                                        <canvas id="chart-channel"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-xl-8">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Отвечено с помощью ML (динамика)</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                            <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" href="#">&nbsp;Action</a><a class="dropdown-item" href="#">&nbsp;Another action</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">&nbsp;Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="chart-area">
                                        <canvas id="chart-ml-dynamic"></canvas>
                                </div>
                            </div>
                        </div>
                    </div><!-- End: Chart -->
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Tipo-knowledgebase.ru 2024</span> <a href="info.php"> | О сайте</a></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sidebar-collapse.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/common.js"></script>
    
   
</body>

</html>