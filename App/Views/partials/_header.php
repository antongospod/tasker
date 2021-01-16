<?php use Core\Helpers; ?>
<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo Helpers::asset('css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo Helpers::asset('css/style.css'); ?>" rel="stylesheet">

</head>
<body class="d-flex h-100 text-center text-white bg-dark">

<div class="cover-container justify-content-center w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
        <div>
            <a class="nav-link text-white" href="<?php echo Helpers::path(''); ?>">
                <h3 class="float-md-start mb-0">Task Manager</h3>
            </a>
            <nav class="nav nav-masthead justify-content-center float-md-end">
                <a class="nav-link <?php echo Helpers::isCurrentURI('/create') ? 'active' : ''; ?>" aria-current="page"
                   href="<?php echo Helpers::path('create'); ?>">Add Task</a>
                <?php if (Helpers::isAuth()) : ?>
                    <a class="nav-link" aria-current="page" href="<?php echo Helpers::path('logout'); ?>">Logout</a>
                <?php else: ?>
                    <a class="nav-link <?php echo Helpers::isCurrentURI('/login') ? 'active' : ''; ?>"
                       aria-current="page" href="<?php echo Helpers::path('login'); ?>">Sign in</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>