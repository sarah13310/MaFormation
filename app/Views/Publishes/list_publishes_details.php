<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<div class="container mx-auto w-75">
    <div class="row justify-content-between">
        <div class="col">
            <h1 class="col mt-2 mb-2"><?= $title ?></h1>
        </div>
        <div class="d-flex col-3 align-self-center justify-content-end">
            <a class="col-8 btn btn-outline-primary" href="/publishes/list">Retour</a>
        </div>
    </div>

    <div class="card  align-items-center justify-content-center mb-2" style="background-color:#b3cdfd;">
        <img src=<?= $publication['image_url'] ?> class="p-5 mb-2 mt-2 w-50">
        <div class="card-body ">
            <h4 class="card-title text-center"><?= $publication['subject'] ?></h4>
            <p class="card-subtitle mb-2 mt-2">
                <?= "Ecrit le " . dateFormat($publication['datetime']) ?>
            </p>
            <hr class="hr" />
            <p class="mb-3 mt-3"> <?= $publication['description'] ?></p>
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

</div>
<div class="container mx-auto w-75">
    <div class="row align-items-center justify-content-center">
        <?php $j = 0;
        foreach ($listarticles as $article) : ?>
            <form action="/article/list/details" method="post">
                <div class="card mb-2 flex-row ">
                    <img src="<?= $article['image_url'] ?>" class="card-img-left" style="width: 33%;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $article['subject'] ?></h5>
                        <small><?= "Ecrit le " . dateFormat($publication['datetime']) ?></small>
                        <div class="mt-3">
                            <p class="card-description" style="height: 6rem;"><?= $article['description'] ?></p>
                        </div>
                        <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                        <button type="submit" class="btn btn-outline-primary mr-2 float-end">Voir Plus</button>
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