<?php $base = base_url(); ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('header') ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= $base ?>/css/stylemain.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700,700i|Source+Code+Pro:400,700&display=swap">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section>
    <h1 class="noselect ms-3"><?= $title ?></h1>
    <hr class="mb-2 mt-2">
    <div class="container py-3">
        <form id="trainingForm" method="post" action="/training/add">
            <div class="row">
                <div class="col-12 col-md-6 ">
                    <div class="col-12  form-floating mb-3">
                        <input class="form-control" id="name" name="title" type="text" placeholder="Titre de la formation" data-sb-validations="required" />
                        <label for="nomDeLaFormation">Titre de la formation</label>
                    </div>
                    <div class="col-12  form-floating mb-3">
                        <input class="form-control" id="image_url" name="image_url" type="text" placeholder="Image de couverture" />
                        <label for="image_url">Image de couverture</label>
                    </div>
                    <div class="col-12  form-floating mb-3">
                        <select class="form-select" id="category" aria-label="Type de prestation">
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category["id_category"] ?>"><?= $category["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                        <label for="category">Catégorie</label>
                    </div>
                    <div class="col-12  form-floating mb-3">
                        <textarea class="form-control" name="description" id="description" type="text" placeholder="Description " style="height: 8rem;"></textarea>
                        <label for="description">Description </label>
                    </div>

                    <?php if (isset($warning)) : ?>
                        <div id="warning" class="alert alert-warning" role="alert">Ce titre existe déjà !</div>
                    <?php endif; ?>
                    <?php if (isset($validation)) : ?>
                        <div class="col-12 mt-2">
                            <div id="error" class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-6 form-floating mb-3">
                            <input class="form-control" name="dateStart" id="dateDeDebut" type="date" placeholder="Date de  début" value="<?= session()->dateStart ?>" />
                            <label for="dateDeDebut">&nbsp;Date de début</label>
                        </div>
                        <div class="col-6 form-floating mb-3">
                            <input class="form-control" name="timeStart" id="timeStart" type="time" placeholder="Heure de  début" value="<?= session()->timeStart ?>" />
                            <label for="timeStart">&nbsp;Heure de début</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-floating mb-3">
                            <input class="form-control" name="dateEnd" id="dateEnd" type="date" placeholder="Date de fin" value="<?= session()->dateEnd ?>" />
                            <label for="dateEnd">&nbsp;Date de fin</label>
                        </div>
                        <div class="col-6 form-floating mb-3">
                            <input class="form-control" name="timeEnd" id="timeEnd" type="time" placeholder="Date de fin" value="<?= session()->timeEnd ?>" />
                            <label for="timeEnd">&nbsp;Heure de fin</label>
                        </div>
                    </div>
                    <div class="col-12 col-xl-8 form-floating mb-3">
                        <input class="form-control" name="price" id="price" type="numeric" min="10" step="0.1" max="1000" placeholder="Montant de la prestation" />
                        <label for="price">Montant de la prestation</label>
                    </div>

                </div>
                <div class="col">
                    <div class="col-1 col-xl-2 d-grid">
                        <button class="btn btn-primary btn-lg" id="btnCreate" type="submit">Créer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</section>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    let formAdd = document.getElementById('trainingForm');
    let warning = document.getElementById('warning');
    let error = document.getElementById('error');
    let date = new Date();

    formAdd['dateStart'].value = formatDate(date);
    formAdd['dateEnd'].value = formatDate(date);
    formAdd['timeStart'].value = "08:00";
    formAdd['timeEnd'].value = "09:00";
    formAdd['image_url'].value = "<?= constant('DEFAULT_IMG_TRAINING') ?>";

    price.value = "10";
    name.value = "";
    // gestion des dates en js
    function padTo2Digits(num) {
        return num.toString().padStart(2, '0');
    }

    function formatDate(date) {
        return [
            date.getFullYear(),
            padTo2Digits(date.getMonth() + 1),
            padTo2Digits(date.getDate()),
        ].join('-');
    }

    function formatTime(date, offset = 1) {
        return [
            padTo2Digits(date.getHours() + offset),
            padTo2Digits(date.getMinutes()),
        ].join(':');
    }

    setTimeout(() => {
        if (error)
            error.remove();

        if (warning)
            warning.remove();
    }, 2000);
</script>
<?= $this->endSection() ?>