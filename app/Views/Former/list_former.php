<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<div class="container mx-auto mt-4">
    <div class="row">
        <?php $i = 0;
        foreach ($listformers as $former) : ?>

            <div class="col-md-4">
                <form action="/former/list/cv" method="post">
                    <div class="card" style="width: 18rem;">
                        <img src="" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $former['name'] . " " . $former['firstname'] ?></h5>
                            <input type="hidden" name="mail" value="<?=$former['mail']?>" >
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