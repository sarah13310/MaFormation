<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container mx-auto w-75">
<h1 class="mt-2 mb-2"><?= $title ?></h1>
    <div class="row align-items-center justify-content-center">
        <?php $i = 0;
        foreach ($listarticles as $articles) : ?>
            <form action="/article/list/details" method="post">
                <div class="card mb-2 flex-row ">
                    <img src="<?=$articles['image_url']?>" class="card-img-left" style="width: 33%;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $articles['subject'] ?></h5>
                        <?php $j = 0;
                            foreach ($articles['user'] as $user) : ?>
                                <small><?= $user['name'] . " " . $user['firstname'] ." le " . dateFormat($articles['datetime'])?></small>
                            <?php $j++;
                            endforeach ?>
                        <div  class="mt-3">
                            <p class="card-description" style="height: 6rem;"><?= $articles['description'] ?></p>
                        </div>
                        <input type="hidden" name="id_article" value="<?= $articles['id_article'] ?>">
                        <h6 class="card-subtitle mb-2 text-muted">
                            
                        </h6>
                        <button type="submit" class="btn btn-primary mr-2 float-end">Voir Plus</button>
                    </div>
                </div>
            </form>
        <?php $i++;
        endforeach ?>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>