<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1 class="mb-2 text-center"><?= $title ?></h1>
<div class=" container-fluid align-items-center ">
    <?php $i = 0;
    foreach ($former as $f) : ?>
        <div class="card mx-auto w-50 align-items-center justify-content-center mb-2">
            <img src=<?php if (!isset($former['image_url'])) : ?> <?= base_url() . "/assets/img/avatar.png" ?> <?php else : ?> <?= base_url() . $f['image_url'] ?> <?php endif ?> class="card-img-top w-50 mt-2">
            <div class="card-body w-75">
                <h4 class="card-title  text-center"><?= $f['name'] . " "  . $f['firstname']  ?></h4>
                <hr class="hr" />
                <p class="card-subtitle mb-3 mt-3 text-center">
                    <b>Certificat(s) </b>
                </p>
                <p class="card-subtitle mb-3 mt-3 text-center">

                    <?php $j = 0;
                    foreach ($skills as $skill) : ?>
                        <?= $skill['name'] ?>
                    <?php $j++;
                    endforeach ?>
                </p>
                <hr class="hr" />
                <p class="card-subtitle mb-3 mt-3 text-center">
                    <b>Contacts</b>
                </p>
                <p class="text-center">
                    <?= "Mail : " . $f['mail'] ?>
                </p>
                <p class="text-center">
                    <?= "Téléphone : " . $f['phone'] ?>
                </p>
            </div>
            <a href="/former/list" class="mb-2 btn btn-outline-primary">Retour à la liste</a>
        </div>
    <?php $i++;
    endforeach ?>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>