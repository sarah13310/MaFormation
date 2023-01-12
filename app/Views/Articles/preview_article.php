<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<div class="row">
    <h1 class="col"><?= $title ?></h1>
    <a href="/admin/articles/list"class="col-2 btn btn-primary float-end">Retour</a>
</div>

<div class="card w-75 align-items-center justify-content-center mb-2" style="background-color:#b3cdfd;">
    <div class="gradient-gray w-50 mt-2 rounded p-2">
        <img src="<?= $article['image_url'] ?>" class="w-100 mb-2 mt-2 ">
    </div>
    <div class="card-body w-75">
        <h4 class="card-title text-center"><?= $article['subject'] ?></h4>
        <hr class="hr" />
        <p class="mb-3 mt-3"> <?= $article['description'] ?></p>
    </div>
</div>

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>