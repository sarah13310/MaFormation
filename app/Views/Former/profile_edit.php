<?php require_once ('util.php') ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<span class="title3"><?= $title ?></span>
<div class="container">
    <div class="row ">
        <div class="col-12  col-md-4 mb-4">
            <div class="row">
                <img src="https://mdbcdn.b-cdn.net/img/new/avatars/5.webp" style="width: 200px;" alt="Avatar" />
            </div>
            <div class="row mt-2 mb-2">
                <span class="title0"><i class="bi bi-wrench-adjustable-circle-fill"></i> Travail</span>
                <hr class="fade-1">
            </div>
            <?php $i = 0;
            foreach ($jobs as $job) : ?>
                <div class="row">
                    <span class="title5"><?= $job['name'] ?></span>
                    <span class="title2"><?= $job['address'] ?></span>
                </div>
            <?php $i++;
            endforeach ?>
            <div class="row mt-2 mb-2">
                <span class="title0"><i class="bi bi-award-fill"></i> Compétences</span>
                <hr class="fade-1">
            </div>
            <?php $i = 0;
            foreach ($skills as $skill) : ?>
                <div class="row">
                    <span class="title2"><?= $skill ?></span>
                </div>
            <?php $i++;
            endforeach ?>

        </div>
        <div class="col-12 col-md-4">
            <div class="row">
                <span class="title1">
                    <?= $user['firstname'] . " " . $user['name'] . "    " ?>&nbsp;&nbsp; <i class="bi bi-geo-alt" style="width:14px"></i>
                    <span class="title2"><?= $user['city'] . ", " . $user['country'] ?></span>
            </div>
            <div class="row">
                <span class="title4 "><?= $user['current_job'] ?></span>
            </div>
            <div class="title0 mt-3">Popularité</div>
            <div class="ton-blue-6 mb-4">
                <span>
                    <span class="title1"><?= $user['ratings'] ?></span>
                    <?= ratings($user['ratings'])?>                    
                </span>
            </div>
            <div class="mb-4 title0"><span><i class="bi bi-chat-left-fill "></i> Envoyer un message</span></div>
            <div class="mb-1 title0">
                <span><i class="bi bi-person-fill"></i> Informations contact</span>
                <hr class="fade-1">
            </div>
            <div>
                <span class="title2 mt-1">Téléphone : <span class="ton-blue-5"><?= $user['phone']?></span></span>
            </div>
            <div>
                <span class="title2 mt-1">Adresse : <span><?= $user['address']; $user['cp']; $user['city']?></span></span>
            </div>
            <div>
                <span class="title2 mt-1">Mail : <span class="ton-blue-5"><?= $user['mail'] ?></span></span>
            </div>
            <div>
                <span class="title2 mt-1">Site : <span class="ton-blue-5">www.maformation.com</span></span>
            </div>
            <div class="mt-4 mb-1 title0">
                <span><i class="bi bi-eye-fill"></i> Informations personnelles</span>
                <hr class="fade-2">
            </div>
            <div>
                <span class="title2 mt-1">Anniversaire : <span class="ton-blue-5"><?= dateFormat( $user['birthday'])?></span></span>
            </div>
            <div>
                <span class="title2 mt-1">Genre : <span class="ton-blue-5"><?=($user['gender']==0)?"Féminin":"Masculin"?></span></span>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?= $this->endSection() ?>