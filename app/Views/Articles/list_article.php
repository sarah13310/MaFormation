<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<div class="container">
    <div class="row align-items-center justify-content-center">
        <?php $i = 0;
        foreach ($listarticles as $articles) : ?>
            <div class="col-xxl-3 col-lg-4 col-md-5 col-sm-8">
                <form action="/former/list/cv" method="post">
                    <div class="card mb-2" style="width: 18rem;">
                        <img src="/assets/img/avatar.png" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $articles['name'] ?></h5>
                            <p><?= $articles['description'] ?></p>
                            <input type="hidden" name="datetime" value="<?= $articles['datetime'] ?>">
                            <h6 class="card-subtitle mb-2 text-muted"><?php $j = 0;
                                                foreach ($articles['user'] as $user) : ?>
                                    <?= $user['name'] . " " . $user['firstname']?>
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