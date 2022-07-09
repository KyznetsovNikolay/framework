<?php

use App\Model\Post;
use Framework\Template\Renderer;

/**
 * @var Renderer $this
 * @var Post[] $posts
 */
$this->extend('layout/app');
?>

<?php $this->startSection('title') ?>Blog<?php $this->endSection(); ?>

<?php $this->startSection('meta'); ?>
    <meta name="description" content="Blog description" />
<?php $this->endSection(); ?>

<?php $this->startSection('breadcrumbs'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $this->encode($this->path('home')); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blog</li>
        </ol>
    </nav>
<?php $this->endSection(); ?>

<?php $this->startSection('content'); ?>
    <h1>Blog</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <th scope="row"><?= $post->id; ?></th>
                    <td><?= $post->date->format('Y-m-d') ?></td>
                    <td><a href="<?= $this->encode($this->path('blog_show', ['id' => $post->id])) ?>"><?= $this->encode($post->title) ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php $this->endSection(); ?>