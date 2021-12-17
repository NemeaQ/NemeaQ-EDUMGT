<?php global $debug; ?>
<!DOCTYPE html>
<html lang="ru" class="page">
<head>
    <meta charset="utf-8">
    <title><?= $title ?>EDUMGT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#222">
    <meta name="description"
          content="Единая автоматизированная информационная система &quot;Управление образовательной организацие&quot;">

    <link rel="icon" href="/src/img/icon.svg" sizes="any" type="image/svg+xml">
    <link rel="icon" type="image/png" sizes="32x32" href="/src/img/logo-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/src/img/logo-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/src/img/logo-180x180.png.png">
    <link rel="manifest" href="/src/site.webmanifest">

    <link rel="stylesheet" href="/src/css/index.min.css">
    <!-- Bootstrap CSS -->
    <link href="../../../src/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/5c9c921f7a.js" crossorigin="anonymous"></script>
</head>
<body class="page__body">
<nav class="header leftside-menu d-flex flex-column flex-shrink-0 p-3 bg-light h-100" style="width: 230px">
    <header class="d-flex align-items-center">
        <a href="/" class="header__logo logo link-dark text-decoration-none ">
            <img src="/src/img/logo.svg" class="logo__image" width="40" height="40" alt="Логотип">
            <span>ЕАИС EDUMGT</span>
            <span>ver 0.1</span>
        </a>
    </header>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto" id="menu__list">
        <li class="menu__item">
            <a class="menu__link" href="/">Главная</a>
        </li>
        <!--        <li class="menu__item">-->
        <!--            <a class="menu__link" href="rules">Правила</a>-->
        <!--        </li>-->
        <!--        <li class="menu__item">-->
        <!--            <a class="menu__link" href="map">Карта</a>-->
        <!--        </li>-->
        <!--        <li class="menu__item">-->
        <!--            <a class="menu__link" href="wiki">Вики</a>-->
        <!--        </li>-->
        <!--        <li class="menu__item">-->
        <!--            <a class="menu__link" href="donate">Донат</a>-->
        <!--        </li>-->
        <?php if (isset($_SESSION['account']['id'])): ?>
            <li class="menu__item">
                <a class="menu__link" href="profile">Профиль</a>
            </li>
            <li class="menu__item">
                <a class="menu__link" href="logout">Выход</a>
            </li>
        <?php else: ?>
            <li class="menu__item">
                <a class="menu__link" href="login">Вход</a>
            </li>
            <li class="menu__item">
                <a class="menu__link" href="register">Регистрация</a>
            </li>
        <?php endif; ?>
    </ul>
    <footer class="footer">
        <p class="footer__line">Copyryght️ © NemeaQ 2021.<br>Все права защищены.</p>
        <p class="footer__line"><a href="copy">Пользовательское соглашение и Согласие на обработку персональных
                данных.</a>
        </p>
    </footer>
</nav>
<main class="main">
    <nav class="navbar navbar-light bg-primary navbar-top navbar-expand">
        <ul class="navbar-nav align-items-center d-none d-lg-block">
            <li class="nav-item">
                <div class="search-box" data-list="{&quot;valueNames&quot;:[&quot;title&quot;]}">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static"
                          aria-expanded="false">
                        <input class="form-control search-input fuzzy-search" type="search" placeholder="Поиск..."
                               aria-label="Search">
                        <i class="fas fa-search fa-w-16 search-box-icon" aria-hidden="true" focusable="false"></i>
                    </form>
                    <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none"
                         data-bs-dismiss="search">
                        <div class="btn-close-falcon" aria-label="Close"></div>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait"
                   id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <svg width="16px" class="svg-inline--fa fa-bell fa-w-14" data-fa-transform="shrink-6"
                         style="font-size: 33px;transform-origin: 0.4375em 0.5em;" aria-hidden="true" focusable="false"
                         data-prefix="fas" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 448 512" data-fa-i2svg="">
                        <g transform="translate(224 256)">
                            <g transform="translate(0, 0)  scale(0.625, 0.625)  rotate(0 0 0)">
                                <path fill="currentColor"
                                      d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z"
                                      transform="translate(-224 -256)"></path>
                            </g>
                        </g>
                    </svg>
                    <!-- <span class="fas fa-bell" data-fa-transform="shrink-6" style="font-size: 33px;"></span> Font Awesome fontawesome.com -->
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification"
                     aria-labelledby="navbarDropdownNotification">
                    <div class="card card-notification shadow-none">
                        <div class="card-header">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="card-header-title mb-0">Notifications</h6>
                                </div>
                                <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as
                                        read</a></div>
                            </div>
                        </div>
                        <div class="scrollbar-overlay os-host os-theme-dark os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden os-host-transition"
                             style="max-height:19rem">
                            <div class="os-resize-observer-host observed">
                                <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
                            </div>
                            <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
                                <div class="os-resize-observer"></div>
                            </div>
                            <div class="os-content-glue" style="margin: 0px;"></div>
                            <div class="os-padding">
                                <div class="os-viewport os-viewport-native-scrollbars-invisible os-viewport-native-scrollbars-overlaid">
                                    <div class="os-content" style="padding: 0px; height: 100%; width: 100%;">
                                        <div class="list-group list-group-flush fw-normal fs--1">
                                            <div class="list-group-title border-bottom">NEW</div>
<!--                                            <div class="list-group-item">-->
<!--                                                <a class="notification notification-flush notification-unread"-->
<!--                                                   href="#!">-->
<!--                                                    <div class="notification-avatar">-->
<!--                                                        <div class="avatar avatar-2xl me-3">-->
<!--                                                            <img class="rounded-circle"-->
<!--                                                                 src="assets/img/team/1-thumb.png" alt="">-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <div class="notification-body">-->
<!--                                                        <p class="mb-1"><strong>Emma Watson</strong> replied to your comment : "Hello world 😍"</p>-->
<!--                                                        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">💬</span>Just now</span>-->
<!--                                                    </div>-->
<!--                                                </a>-->
<!--                                            </div>-->

                                            <div class="list-group-title border-bottom">EARLIER</div>
                                            <div class="list-group-item">
                                                <a class="notification notification-flush" href="#!">
                                                    <div class="notification-avatar">
                                                        <div class="avatar avatar-2xl me-3">
                                                            <img class="rounded-circle"
                                                                 src="assets/img/icons/weather-sm.jpg" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="notification-body">
                                                        <p class="mb-1">The forecast today shows a low of 20℃ in
                                                            California. See today's weather.</p>
                                                        <span class="notification-time"><span class="me-2" role="img"
                                                                                              aria-label="Emoji">🌤️</span>1d</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
                                <div class="os-scrollbar-track os-scrollbar-track-off">
                                    <div class="os-scrollbar-handle" style="transform: translate(0px, 0px);"></div>
                                </div>
                            </div>
                            <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable os-scrollbar-auto-hidden">
                                <div class="os-scrollbar-track os-scrollbar-track-off">
                                    <div class="os-scrollbar-handle" style="transform: translate(0px, 0px);"></div>
                                </div>
                            </div>
                            <div class="os-scrollbar-corner"></div>
                        </div>
                        <div class="card-footer text-center border-top"><a class="card-link d-block" href="app/social/notifications.html">View all</a></div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" href="#" role="button"
                                             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-xl">
                        <img border="2px" width="32px" height="32px" class="rounded-circle"
                             src="https://i.guim.co.uk/img/media/26392d05302e02f7bf4eb143bb84c8097d09144b/446_167_3683_2210/master/3683.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=49ed3252c0b2ffb49cf8b508892e452d"
                             alt="">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                    <div class="bg-white dark__bg-1000 rounded-2 py-2">
                        <a class="dropdown-item" href="#!">Set status</a>
                        <a class="dropdown-item" href="pages/user/profile.html">Profile &amp; account</a>
                        <a class="dropdown-item" href="#!">Feedback</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="pages/user/settings.html">Settings</a>
                        <a class="dropdown-item" href="pages/authentication/card/logout.html">Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
    <?php echo $content; ?>
</main>

<div class="notify top-right"></div>
<?php if (isset($debug) && $debug): ?>
    <script src="../../../src/js/bundle.js"></script>
<?php else: ?>
    <script src="../../../src/js/bundle.min.js"></script>
<?php endif; ?>
</body>
</html>
