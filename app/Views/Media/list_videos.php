<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1 class="mb-3  text-center"><?= $title ?></h1>
<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listvideos as $videos) : ?>
            <div class="card mb-2 flex-row w-75 ">
                <img src="/assets/video.svg" class="mt-2 mb-2 card-img-left p-4" style="width: 33%;">
                <div class="card-body">
                    <h5 class="card-title"><?= $videos['name'] ?></h5>
                    <small><?= "Fait par " . $videos['author'] ?></small>
                    <div class="mt-3">
                        <p class="card-description" style="height: 6rem;"><?= $videos['description'] ?></p>
                    </div>
                    <a class="btn mr-2 float-end" href="<?= $videos['url'] ?>" role="button">Regarder la vidéo</a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>