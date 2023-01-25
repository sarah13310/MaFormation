<?php /* require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') */ ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('header') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>
<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listmedias as $medias) : ?>
            <div class="card mb-2 flex-row w-75">
                <img src="<?= $medias['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 15%;">
                <div class="card-body">
                    <h5 class="mb-2"><?= $medias['name'] ?></h5>
                    <small><?= "Par " . $medias['author'] ?></small>
                </div>
                <a class="btn mr-2 float-end" href="<?= $medias['url'] ?>" role="button">Voir</a>
            </div>
        <?php endforeach ?>
    </div>
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listformers as $formers) : ?>
            <form action="/former/list/cv" method="post">
            <div class="card mb-2 flex-row w-75">
                <img src="<?= $formers['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 15%;">
                <div class="card-body">
                    <h5><?= $formers['name'] ." " . $formers['firstname'] ?></h5>
                    <input type="hidden" name="mail" value="<?= $former['mail'] ?>">
                </div>
                <button type="submit" class="mt-auto btn align-self-end mr-2">Voir Plus</button>
            </div>
            </form>
        <?php endforeach ?>
    </div>
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listarticles as $articles) : ?>
            <form action="/article/list/details" method="post">
            <div class="card mb-2 flex-row w-75">
                <img src="<?= $articles['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 15%;">
                <div class="card-body">
                    <h5><?= $articles['subject'] ?></h5>
                    <input type="hidden" name="id_article" value="<?= $articles['id_article'] ?>">
                </div>
                <button type="submit" class="mt-auto btn align-self-end mr-2">Voir Plus</button>
            </div>
            </form>
        <?php endforeach ?>
    </div>
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listpublications as $publications) : ?>
            <form action="/publishes/list/details" method="post">
            <div class="card mb-2 flex-row w-75">
                <img src="<?= $publications['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 15%;">
                <div class="card-body">
                    <h5><?= $publications['subject'] ?></h5>
                    <input type="hidden" name="id_publication" value="<?= $artipublicationscles['id_publication'] ?>">
                </div>
            </div>
            <button type="submit" class="mt-auto btn align-self-end mr-2">Voir Plus</button>
            </form>
        <?php endforeach ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>

<?= $this->endSection() ?>