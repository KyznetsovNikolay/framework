<?php

use Framework\Template\Renderer;

/** @var Renderer $this */
$this->extend('layout.app');
?>

<?php $this->startSection('content') ?>
    <div class="row">
        <div class="col-md-9">
            <?= $this->renderSection('main'); ?>
        </div>
        <?= $this->renderSection('sidebar'); ?>
    </div>
<?php $this->endSection(); ?>

