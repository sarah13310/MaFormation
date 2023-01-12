<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php $i = 0;
        foreach ($listvideos as $videos) : ?>
                <div class="card mb-2 flex-row w-75">
                    <img src="/assets/img/avatar.png" class="card-img-left" style="width: 33%;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $videos['name'] ?></h5>
                                <small><?= "Fait par " . $videos['author']?></small>
                        <div  class="mt-3">
                            <p class="card-description" style="height: 6rem;"><?= $videos['description'] ?></p>
                        </div>
                        <a class="btn mr-2 float-end" href="<?= $videos['url'] ?>" role="button">Regarder la vidéo</a>
                    </div>
                </div>
        <?php $i++;
        endforeach ?>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>