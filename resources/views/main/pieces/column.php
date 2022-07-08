<?php

use Framework\Template\Renderer;

/** @var Renderer $this */
$this->extend('layout.app');
?>

<div class="row">
    <div class="col-md-9">
        <?= $content ?>
    </div>
    <?= $this->renderSection('column'); ?>
</div>

