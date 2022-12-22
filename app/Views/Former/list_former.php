<?= $this->extend('layouts/default') ?>
<link href="<?= base_url() . '/css/former.css' ?>" rel="stylesheet">
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php $i = 0;
        foreach ($listformers as $former) : ?>
            <div class="col-xxl-3 col-lg-4 col-md-5 col-sm-8">
                <form action="/former/list/cv" method="post">
                    <div class="card mb-2" style="width: 18rem;">
                        <img src=<?php if (!isset($former['image_url'])) : ?> <?= base_url() . "/assets/img/avatar.png" ?> <?php else : ?> <?= base_url() . $former['image_url'] ?> <?php endif ?> class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $former['name'] . " " . $former['firstname'] ?></h5>
                            <input type="hidden" name="mail" value="<?= $former['mail'] ?>">
                            <h6 class="card-subtitle mb-2 text-muted">
                                Formateur en <?php $j = 0;
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