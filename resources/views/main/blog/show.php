<?php

use App\Model\Post;
use Framework\Template\Renderer;

/**
 * @var Renderer $this
 * @var Post $post
 */
$this->extend('layout/app');
?>

<?php $this->startSection('title'); ?><?= $this->encode($post->title) ?><?php $this->endSection(); ?>

<?php $this->startSection('meta'); ?>
    <meta name="description" content="<?= $this->encode($post->title) ?>" />
<?php $this->endSection(); ?>

<?php $this->startSection('breadcrumbs'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $this->encode($this->path('home')); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= $this->encode($this->path('blog')); ?>">Blog</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $this->encode($post->title) ?></li>
        </ol>
    </nav>
<?php $this->endSection(); ?>

<?php $this->startSection('content'); ?>
    <h1><?= $this->encode($post->title) ?></h1>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?= $post->date->format('Y-m-d') ?>
        </div>
        <div class="panel-body"><?= nl2br($this->encode($post->content)) ?></div>
    </div>
<?php $this->endSection(); ?>