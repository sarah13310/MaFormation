<?= $this->extend('layouts/default') ?>


<?= $this->section('content') ?>
<h1 class="mb-3 text-center"><?= $title ?></h1>
<div class="container align-items-center">
    <div class="row  justify-content-start">

        <?php foreach ($trainings as $training) : ?>
            <div class="col-12 col-sm-4 col-md-5 col-lg-4  ">
                <form action="/training/details/0" method="post">
                    <div class="card mb-2" style="height:600px;">
                        <div class="card-img card-img-center" style="height:400px;">
                            <img src=<?= $training['image_url'] ?> class="p-4 img-fluid  h-95">
                        </div>
                        <div class="p-3 card-body d-flex flex-column">
                            <h5 class="card-title"><?= $training['title']  ?></h5>
                            <p>&nbsp;&nbsp;Mise en ligne le <?= $training['date'] ?></p>
                            <input type="hidden" name="id_training" value="<?= $training['id_training'] ?>">
                            <h6 class="card-subtitle mb-2 text-muted">
                                <?= $training['description'] ?>
                            </h6>
                            <button type="submit" class="  btn mt-auto btn-primary mr-2 align-self-end">Voir Plus</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endforeach ?>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

</script>


<?= $this->endSection() ?>