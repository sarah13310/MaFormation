<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<span class="title3"><?= $title ?></span>
<div class="container">
    <div class="row ">
        <div class="col-12  col-md-4 mb-4">
            <div class="row">
                <img src="<?= $user['image_url'] ?>" style="width: 200px;" alt="Avatar" />
            </div>
            <div class="mb-1 title0">
                <div class="title0 flex">
                    <div class="start"><i class="bi bi-wrench-adjustable-circle-fill"></i>&nbsp;Travail</div>
                    <div><button data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier Travail" class="btn-title0 mt-1">Modifier</button></div>
                </div>
                <hr class="fade-1">
            </div>
            <?php foreach ($jobs as $job) : ?>
                <div class="row">
                    <span class="title5"><?= $job['name'] ?></span>
                    <span class="title2"><?= $job['address'] ?></span>
                </div>
            <?php endforeach ?>
            <div class="mb-1 title0">
                <div class="title0 flex">
                    <div class="start"><i class="bi bi-award-fill"></i>&nbsp;Compétences</div>
                    <div><button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Modifier compétences" class="btn-title0 mt-1">Modifier</button></div>
                </div>
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
        <div class="col-12 col-md-6">
            <div class="title1">
                <div class="flex-between">
                    <span><?= $user['firstname'] . " " . $user['name'] ?> </span>
                    <span class="title2"><i class="bi bi-geo-alt" style="width:14px"></i><?= "  " . $user['city'] . ", " . $user['country'] ?></span>
                    <div><button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Modifier le nom" class="btn-title0 mt-1">Modifier</button></div>
                </div>
            </div>
            <div class="row">
                <span class="title4 "><?= $user['current_job'] ?></span>
            </div>
            <div class="title0 mt-3">Popularité</div>
            <div class="ton-blue-6 mb-4">
                <span>
                    <span class="title1"><?= $user['ratings'] ?></span>
                    <?= $ratings?>
                </span>
            </div>
            <div class="mb-4 title0"><span><i class="bi bi-chat-left-fill "></i> Envoyer un message</span></div>
            <div class="mb-1 title0">
                <div class="title0 flex">
                    <div class="start"><i class="bi bi-person-fill"></i>&nbsp;Contact</div>
                    <div><button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Modifier contact" class="btn-title0 mt-1">Modifier</button></div>
                </div>
                <hr class="fade-1">
            </div>
            <div>
                <span class="title2 mt-1">Téléphone : <span class="ton-blue-5"><?= $user['phone'] ?></span></span>
            </div>
            <div>
                <span class="title2 mt-1">Adresse : <span><?= $user['address'];
                                                            $user['cp'];
                                                            $user['city'] ?></span></span>
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
                <span class="title2 mt-1">Anniversaire : <span class="ton-blue-5"><?= $birthday ?></span></span>
            </div>
            <div>
                <span class="title2 mt-1">Genre : <span class="ton-blue-5"><?= $gender ?></span></span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<?= $this->endSection() ?>