<?php

$this->extend = 'layout.app';
?>

<div class="row">
    <div class="col-md-9">
        <?= $content ?>
    </div>
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
</div>

