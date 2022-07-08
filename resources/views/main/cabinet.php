<?php

use Framework\Template\Renderer;

/** @var Renderer $this */
$this->extend('main.pieces.column');
?>

<?php $this->startSection('column'); ?>
    <div class="col-md-3">
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Cabinet
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Cabinet menu</li>
            </ul>
        </div>
    </div>
<?php $this->endSection(); ?>

<?php $this->startSection('breadcrumbs'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cabinet</li>
        </ol>
    </nav>
<?php $this->endSection(); ?>

<p>I'am logged in as <?= $username; ?></p>