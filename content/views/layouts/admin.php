<!DOCTYPE html>
<html lang="ru" class="page">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?> | Админпанель</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/src/styles/admin.css" rel="stylesheet">
</head>
<body class="page__body">
<?php if ($this->route['action'] != 'login'): ?>
    <header class="header">
        <a href="/admin" class="header__logo logo">
            <img src="/src/images/logo-admin.svg" class="logo__image" width="44" height="44" alt="Логотип">
            <p class="logo__title">Админпанель</p>
            <p class="logo__tagline"><?php echo $title; ?></p>
        </a>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <a class="nav-link" href="/admin/users"><span class="nav-link-text">Пользователи</span></a>
            <a class="nav-link" href="/admin/players"> <span class="nav-link-text">Игроки</span></a>
            <a class="nav-link" href="/admin/groups"> <span class="nav-link-text">Группы</span> </a>
            <a class="button" href="/admin/logout">Выход</a>
        </nav>
    </header>
<?php endif; ?>
<main class="main">
    <?php echo $content; ?>
</main>

<?php if ($this->route['action'] != 'login'): ?>
    <footer class="footer">
        <small>&copy; 2021, NemeaQ |
            <?php if (PHP_OS !== "WINNT") echo "Текушая нагрузка на систему: " . round(sys_getloadavg()[0], 2); ?>
        </small>
    </footer>
<?php endif; ?>
<script src="/src/scriptsripts"></script>
</body>
</html>
