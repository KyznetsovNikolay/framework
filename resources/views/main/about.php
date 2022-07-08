<?php

use Framework\Template\Renderer;

/** @var Renderer $this */
$this->extend('main.pieces.column');
?>

<?php $this->startSection('title'); ?>About<?php $this->endSection(); ?>

<?php $this->startSection('sidebar'); ?>
<div class="col-md-3">
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            About
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Site menu</li>
        </ul>
    </div>
</div>
<?php $this->endSection(); ?>

<?php $this->startSection('breadcrumbs'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About</li>
        </ol>
    </nav>
<?php $this->endSection(); ?>

<?php $this->startSection('main'); ?>
    <p>About page</p>
<?php $this->endSection(); ?>


