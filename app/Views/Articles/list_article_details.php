<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<?php $i = 0;
foreach ($article as $a) : ?>
    <div class="card w-75 align-items-center justify-content-center mb-2" style="background-color:#b3cdfd;">
        <img src=<?= base_url() . "/assets/img/avatar.png" ?> class="mb-2 mt-2 w-50">
        <div class="card-body w-75">
            <h4 class="card-title text-center"><?= $a['subject'] ?></h4>
            <p class="card-subtitle mb-2 mt-2">
                <?= "Ecrit le " . dateFormat($a['datetime']) ?>
            </p>
            <hr class="hr" />
            <p class="mb-3 mt-3"> <?= $a['description'] ?></p>
            <hr class="hr" />
            <p class="card-subtitle mb-3 mt-3 text-center">
                <?php $j = 0;
                foreach ($author as $au) : ?>
                    <img src=<?php if (!isset($au['image_url'])) : ?> <?= "/assets/img/avatar.png" ?> <?php else : ?> <?= $au['image_url'] ?> <?php endif ?> class="rounded-circle me-2" style="width:8rem;">
                    <?= "Ecrit par " .  $au['name'] . " " . $au['firstname'] ?>
                <?php $j++;
                endforeach ?>
            </p>
        </div>
    </div>
<?php $i++;
endforeach ?>
<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>