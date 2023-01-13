<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1 class="mb-3  text-center"><?= $title ?></h1>
<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listbooks as $book) : ?>
                <div class="card mb-2 flex-row w-75">
                    <img src="/assets/chapter.svg" class="mt-2 mb-2 card-img-left p-4" style="width: 33%;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $book['name'] ?></h5>
                                <small><?= "Ecrit par " . $book['author']?></small>
                        <div  class="mt-3">
                            <p class="card-description" style="height: 6rem;"><?= $book['description'] ?></p>
                        </div>
                        <a class="btn mr-2 float-end" href="<?= $book['url'] ?>" role="button">Acheter le livre</a>
                    </div>
                </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>