<?php

use Framework\Template\Renderer;

/** @var Renderer $this */
$this->extend('layout.app');
?>

<?php $this->startSection('title'); ?>Home<?php $this->endSection(); ?>

<?php $this->startSection('content'); ?>
    <h2>Hello <?= $name; ?></h2>
<?php $this->endSection(); ?>