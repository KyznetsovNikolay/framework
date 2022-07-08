<?php

use Framework\Template\Renderer;

/** @var Renderer $this */
$this->extend('layout.app');
?>
<h2>Hello <?= $name; ?></h2>