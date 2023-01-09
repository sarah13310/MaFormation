<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
    <?php $i = 0;
    foreach ($publication as $p) : ?>
        <div class="card w-75 align-items-center justify-content-center mb-2" style="background-color:#b3cdfd;">
            <img src=<?= base_url() . "/assets/img/avatar.png" ?> class="mb-2 mt-2 w-50">
            <div class="card-body w-75">
                <h4 class="card-title text-center"><?= $p['subject'] ?></h4>
                <p class="card-subtitle mb-2 mt-2">
                    <?= "Ecrit le " . dateFormat($p['datetime']) ?>
                </p>
                <hr class="hr" />
                <p class="mb-3 mt-3"> <?= $p['description'] ?></p>
                <hr class="hr" />
                <p class="card-subtitle mb-3 mt-3 text-center">
                    <?php $k = 0;
                    foreach ($authors as $author) : ?>
                        <img src=<?php if (!isset($author['image_url'])) : ?> <?= "/assets/img/avatar.png" ?> <?php else : ?> <?= $author['image_url'] ?> <?php endif ?> class="rounded-circle me-2" style="width:8rem;">
                        <?= "Ecrit par " .  $author['name'] . " " . $author['firstname'] ?>
                        <?php $k++;
                    endforeach ?>
                </p>
            </div>
        </div>
<?php $i++;
    endforeach ?>

<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php $j = 0;
        foreach ($listarticles as $articles) : ?>
            <form action="/article/list/details" method="post">
                <div class="card mb-2 flex-row w-75">
                    <img src="/assets/img/avatar.png" class="card-img-left" style="width: 33%;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $articles['subject'] ?></h5>
                        <small><?= "Ecrit le " . dateFormat($p['datetime']) ?></small>
                        <div  class="mt-3">
                            <p class="card-description" style="height: 6rem;"><?= $articles['description'] ?></p>
                        </div>
                        <input type="hidden" name="id_article" value="<?= $articles['id_article'] ?>">
                        <button type="submit" class="btn mr-2 float-end">Voir Plus</button>
                    </div>
                </div>
            </form>
        <?php $j++;
        endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>