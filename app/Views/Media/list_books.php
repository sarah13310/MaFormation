<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php $i = 0;
        foreach ($listbooks as $books) : ?>
                <div class="card mb-2 flex-row w-75">
                    <img src="/assets/img/avatar.png" class="card-img-left" style="width: 33%;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $books['name'] ?></h5>
                                <small><?= "Ecrit par " . $books['author']?></small>
                        <div  class="mt-3">
                            <p class="card-description" style="height: 6rem;"><?= $books['description'] ?></p>
                        </div>
                        <a class="btn mr-2 float-end" href="<?= $books['url'] ?>" role="button">Acheter le livre</a>
                    </div>
                </div>
        <?php $i++;
        endforeach ?>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>