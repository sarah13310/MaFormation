<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<div class="container mx-auto w-75">
    <h1 class="mt-2 mb-2"><?= $title ?></h1>
    <div class="row align-items-center justify-content-center">
        <form action="/training/payment" method="post">
            <div class="card mb-2 mx-auto gradient-darkgray">

                <div class="mx-auto mb-2 "style="height:300px;">
                    <img src="<?= $training['image_url'] ?>" class="  img-fluid rounded mt-2  mb-2" style="height:290px;">
                </div>
                
                <div class="card-body" style="background:white;">
                    <h5 class="card-title"><?= $training['title'] ?></h5>
                    <small><?= "Ecrit le " . $date ?></small>
                    <div class="mt-3">
                        <p class="card-description" style="height: auto"><?= $training['description'] ?></p>
                    </div>
                    <input type="hidden" name="id_training" value="<?= $training['id_training'] ?>">
                    <button class="btn btn-primary float-end" type="submit"><i class="bi bi-cart3"></i>Acheter</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>