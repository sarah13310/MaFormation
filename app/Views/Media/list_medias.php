<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1 class="mb-3  text-center"><?= $title ?></h1>
<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listmedias as $medias) : ?>
                <div class="card mb-2 flex-row w-75">
                    <img src="<?= $medias['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 33%;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $medias['name'] ?></h5>
                                <small><?= $p . " " . $medias['author']?></small>
                        <div  class="mt-3">
                            <p class="card-description" style="height: 6rem;"><?= $medias['description'] ?></p>
                        </div>
                        <a class="btn mr-2 float-end" href="<?= $medias['url'] ?>" role="button"><?= $b ?></a>
                    </div>
                </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>