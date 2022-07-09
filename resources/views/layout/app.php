<?php

use Framework\Template\Renderer;

/** @var Renderer $this */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->renderSection('meta') ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title><?= $this->renderSection('title') ?></title>
    <style>
        body {}
        h1 { margin-top: 0 }
        .app { display: flex; min-height: 100vh; flex-direction: column; }
        .app-content {
            flex: 1;
            margin-top: 30px;
        }
        .app-main {
            margin-top: 30px;
        }
        .app-footer { padding-bottom: 1em; }
    </style>
</head>
<body class="app">
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand " href="<?= $this->encode($this->path('home')); ?>">Application</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= $this->encode($this->path('blog')); ?>">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?= $this->encode($this->path('about')); ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->encode($this->path('cabinet')); ?>">Cabinet</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="app-content">
    <main class="container">
        <?= $this->renderSection('breadcrumbs'); ?>
        <div class="app-main">
            <?= $this->renderSection('content'); ?>
        </div>
    </main>
</div>

<footer class="app-footer">
    <div class="container">
        <hr />
        <p>&copy; 2022 - My App.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>