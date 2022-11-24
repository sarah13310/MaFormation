<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<span class="title3"><?= $title ?></span>
<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="row">
                <img src="https://mdbcdn.b-cdn.net/img/new/avatars/5.webp" style="width: 200px;" alt="Avatar" />
            </div>
            <div class="row">
                <h6 style="margin-bottom:0;margin-top:10px">Travail</h6>
                <hr class="fade-2">
            </div>
            <?php $i=0;foreach ($jobs as $job) : ?>
                <div class="row">
                    <span class="title5"><?= $job['nom'] ?></span>
                </div>
            <?php $i++;endforeach ?>
        </div>
        <div class="col-8">
            <div class="row">
                <span class="title1">
                    <?= $firstname . " " . $name . "    " ?>&nbsp;&nbsp; <i class="bi bi-geo-alt" style="width:14px"></i>

                    <span class="title2"><?= $city . ", " . $country ?></span>
            </div>
            <div class="row">
                <span class="title4"><?= $current_job ?></span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>