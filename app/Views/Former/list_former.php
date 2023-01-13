<?= $this->extend('layouts/default') ?>

<?= $this->section('header') ?>
<link href="<?= base_url() . '/css/former.css' ?>" rel="stylesheet">
<?= $this->endSection(); ?>
<?= $this->section('content') ?>
<h1 class="text-center mb-4"><?= $title ?></h1>
<div class="container-fluid align-items-center overflow-auto">
    <div class="row  justify-content-start">
        <?php $i = 0;
        foreach ($formers as $former) : ?>
            <div class="col-12 col-sm-4 col-md-5 col-lg-4 mb-4">
                <form action="/former/list/cv" method="post">
                    <div class="card mb-2" style="height:450px;" >
                        <img src='<?= $former['image_url'] ?>' class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $former['name'] . " " . $former['firstname'] ?></h5>
                            <input type="hidden" name="mail" value="<?= $former['mail'] ?>">
                            <h6 class="card-subtitle mb-2 text-muted" style="height:3rem">
                                <?php $j = 0;
                                                foreach ($former['skills'] as $skill) : ?>
                                    <?= $skill['name'] ?>
                                <?php $j++;
                                                endforeach ?>
                            </h6>
                            <button type="submit" class="btn mr-2">Voir Plus</button>
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