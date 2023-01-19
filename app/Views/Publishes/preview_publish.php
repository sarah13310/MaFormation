
<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<div class="mt-1 mb-4 row">
    <h1 class="col"><?= $title ?></h1>
    <a href="javascript:window.history.go(-1);" class="me-2 col-2 btn <?= $buttonColor?> float-end">Retour</a>
</div>
<hr class="mb-3">

<div class="card w-75 align-items-center justify-content-center mb-2" style="background-color:#b3cdfd;">
    <img src=<?= $publication['image_url'] ?> class="mb-2 mt-2 w-50">
    <div class="card-body w-75">
        <h4 class="card-title text-center"><?= $publication['subject'] ?></h4>
        <hr class="hr" />
        <p class="mb-3 mt-3"> <?= $publication['description'] ?></p>
    </div>
</div>

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>