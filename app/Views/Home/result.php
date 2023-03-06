<?= $this->extend('layouts/default') ?>
<?= $this->section('header') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h1 class="ms-4"><?= $title ?></h1>
<hr class="mt-2 mb-2">
<div class="container">
    <h2><?=$titlevideos?></h2>
    <div class="row m w-75 x-auto align-items-center justify-content-center">
        <?php foreach ($listvideos as $videos) : ?>
            <div class="card mb-2 flex-row">
                <img src="<?= $videos['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 15%;">
                <div class="card-body">
                    <h5 class="mb-2"><?= $videos['name'] ?></h5>
                    <small><?= "Par " . $videos['author'] ?></small>
                </div>
                <a class="btn mr-2 float-end" href="<?= $videos['url'] ?>" role="button">Voir</a>
            </div>
        <?php endforeach ?>
    </div>
    <h2><?=$titlebooks?></h2>
    <div class="row m w-75 x-auto align-items-center justify-content-center">
        <?php foreach ($listbooks as $books) : ?>
            <div class="card mb-2 flex-row">
                <img src="<?= $books['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 15%;">
                <div class="card-body">
                    <h5 class="mb-2"><?= $books['name'] ?></h5>
                    <small><?= "Par " . $books['author'] ?></small>
                </div>
                <a class="btn mr-2 float-end" href="<?= $books['url'] ?>" role="button">Voir</a>
            </div>
        <?php endforeach ?>
    </div>
    <h2><?=$titleformers?></h2>
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listformers as $former) : ?>
            <form action="/former/list/cv" method="post">
                <div class="card mb-2 flex-row w-75">
                    <img src="<?= $former['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 15%;">
                    <div class="card-body">
                        <h5><?= $former['name'] . " " . $former['firstname'] ?></h5>
                        <input type="hidden" name="mail" value="<?= $former['mail'] ?>">
                    </div>
                    <button type="submit" class="mt-auto btn align-self-end mr-2">Voir Plus</button>
                </div>
            </form>
        <?php endforeach ?>
    </div>
    <h2><?=$titlearticles?></h2>
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
    <h2><?=$titlepublications?></h2>
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listpublications as $publication) : ?>
            <form action="/publishes/list/details" method="post">
                <div class="card mb-2 flex-row w-75">
                    <img src="<?= $publication['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 15%;">
                    <div class="card-body">
                        <h5><?= $publication['subject'] ?></h5>
                        <input type="hidden" name="id_publication" value="<?= $publication['id_publication'] ?>">
                    </div>
                    <button type="submit" class="mt-auto btn align-self-end mr-2">Voir Plus</button>
                </div>
            </form>
        <?php endforeach ?>
    </div>
    <h2><?=$titletrainings?></h2>
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listtrainings as $training) : ?>
            <form action="/trainig/details" method="post">
                <div class="card mb-2 flex-row w-75">
                    <img src="<?= $training['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 15%;">
                    <div class="card-body">
                        <h5><?= $training['title'] ?></h5>
                        <input type="hidden" name="id_publication" value="<?= $training['id_training'] ?>">
                    </div>
                    <button type="submit" class="mt-auto btn align-self-end mr-2">Voir Plus</button>
                </div>
            </form>
        <?php endforeach ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>

<?= $this->endSection() ?>