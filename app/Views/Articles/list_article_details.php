<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<div class="container mx-auto w-50">

    <div class="row jjustify-content-between">
        <div class="col">
            <h1 class="col mt-2 mb-2"><?= $title ?></h1>
        </div>
        <div class="d-flex col-3 align-self-center justify-content-end">
            <a class="col-8 btn btn-outline-primary" href="/article/list">Retour</a>
        </div>
    </div>

    <div class="card align-items-center justify-content-center mb-2" style="background-color:#b3cdfd;">
        <div class="gradient-gray w-50 mt-2 rounded p-2">
            <img src=<?= $article['image_url'] ?> class="mb-2 mt-2 ">
        </div>
        <div class="card-body ">
            <h4 class="card-title text-center"><?= $article['subject'] ?></h4>
            <p class="card-subtitle mb-2 mt-2">
                <?= "Ecrit le " . dateFormat($article['datetime']) ?>
            </p>
            <hr class="hr" />
            <p class="mb-3 mt-3"> <?= $article['description'] ?></p>
            <hr class="hr" />
            <p class="card-subtitle mb-3 mt-3 text-center">
                <?php $j = 0;
                foreach ($author as $au) : ?>
                    <img src='<?= $au['image_url'] ?>' class="rounded-circle me-2" style="width:8rem;">
                    <?= "Ecrit par " .  $au['name'] . " " . $au['firstname'] ?>
                <?php $j++;
                endforeach ?>
            </p>
        </div>
    </div>


</div>
<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>