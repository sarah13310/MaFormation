<?= $this->extend('layouts/default') ?>


<?= $this->section('content') ?>
<h1 class="mt-2"><?= $title ?></h1>

<?php foreach ($trainings as $training) : ?>
    <div class="col-12 col-sm-4 col-md-5 col-lg-4  ">
        <form action="/training/list/details" method="post">
            <div class="card mb-2">
                <img src=<?= $training['image_url'] ?> class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?= $training['title']  ?></h5>
                    <p> <?= $training['date'] ?></p>
                    <input type="hidden" name="mail" value="<?= $former['mail'] ?>">
                    <h6 class="card-subtitle mb-2 text-muted">
                        <?= $training['description'] ?>
                    </h6>
                    <button type="submit" class="btn btn-primary mr-2">Voir Plus</button>
                </div>
            </div>
        </form>
    </div>
<?php endforeach ?>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    let views = document.getElementsByClassName("view");
    for (let i = 0; i < views.length; i++) {

        views[i].addEventListener("click", () => {
            if (views[i].hasAttribute("id")) {
                let id = views[i].getAttribute("id");
                console.log(id);
            }
        });
    }
</script>


<?= $this->endSection() ?>