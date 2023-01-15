<?= $this->extend('layouts/default') ?>

<?= $this->section('header') ?>

<?= $this->endSection(); ?>
<?= $this->section('content') ?>
<h1 class="text-center mb-2"><?= $title ?></h1>
<div class="container-fluid align-items-center overflow-auto">
    <div class="row  justify-content-start">
        <?php $i = 0;
        foreach ($formers as $former) : ?>
            <div class="col-12 col-sm-4 col-md-5 col-lg-4 mb-4">
                <form action="/former/list/cv" method="post">
                    <div class="mx-auto w-75 card mb-2" style="height:500px;">
                        <div class="card-img card-img-center">
                            <img src='<?= $former['image_url'] ?>' class="p-4 ">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $former['name'] . " " . $former['firstname'] ?></h5>
                            <input type="hidden" name="mail" value="<?= $former['mail'] ?>">
                            <h6 class="card-subtitle mb-2 text-muted" style="height:3rem">
                                <?php $j = 0;
                                foreach ($former['skills'] as $skill) : ?>
                                    <?= $skill['name'] ?>
                                <?php $j++;
                                endforeach ?>
                            </h6>
                            <button type="submit" class="mt-auto btn align-self-end mr-2">Voir Plus</button>
                        </div>
                    </div>
                </form>
            </div>


        <?php $i++;
        endforeach ?>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>