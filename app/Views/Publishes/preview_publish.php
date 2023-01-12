<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<div class="row">
    <h1 class="col"><?= $title ?></h1>
    <a href="/admin/publishes/list" class="col-2 btn btn-primary float-end">Retour</a>
</div>
<?php $i = 0;
foreach ($publication as $p) : ?>
    <div class="card w-75 align-items-center justify-content-center mb-2" style="background-color:#b3cdfd;">
        <img src=<?= base_url() . "/assets/img/avatar.png" ?> class="mb-2 mt-2 w-50">
        <div class="card-body w-75">
            <h4 class="card-title text-center"><?= $p['subject'] ?></h4>
            <hr class="hr" />
            <p class="mb-3 mt-3"> <?= $p['description'] ?></p>
        </div>
    </div>
<?php $i++;
endforeach ?>


<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>