<?php $base = base_url(); ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('header') ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= $base ?>/css/stylemain.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700,700i|Source+Code+Pro:400,700&display=swap">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="ms-3"><i class="fs-4 bi-magic"></i>&nbsp;&nbsp;<?= $title ?></h1>

<section class="Content">
    <link rel="stylesheet" href="<?= $base ?>/css/default.min.css" />
    <script src="<?= $base ?>/js/sceditor.min.js"></script>
    <script src="<?= $base ?>/js/languages/fr.js"></script>
    <script src="<?= $base ?>/js/bbcode.min.js"></script>
    <script src="<?= $base ?>/js/monocons.min.js"></script>

    <?php if (isset(session()->success)) : ?>
        <div id="success" class="alert alert-success" role="alert">
            <?= session()->success ?>
        </div>
    <?php endif; ?>
    <?php if (isset($validation)) : ?>
        <div id="error" class="col-12 mt-2">
            <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
            </div>
        </div>
    <?php endif ?>
    <?php if (isset($warning)) : ?>
        <div id="error" class="col-12 mt-2">
            <div class="alert alert-warning" role="alert">
                <?= $warning ?>
            </div>
        </div>
    <?php endif ?>

    <form action="/admin/articles/edit" method="post">
        <div class="row">
            <div class='form-floating mb-3 col-12 col-md-6'>
                <input class='form-control' id='subject' type='text' name='subject' placeholder="Sujet de l'article" />
                <label for='subject'>&nbsp;Sujet de l'article (*)</label>
            </div>
            <div class='form-floating mb-3 col-12 col-md-6'>
                <input class='form-control' id='name' type='text' name='name' placeholder="Nom de l'auteur" readonly value="<?= session()->name . " " . session()->firstname; ?> " />
                <label for='name'>&nbsp;Nom de l'auteur </label>
            </div>
            <div class='form-floating mb-3 col-12 col'>
                <input class='form-control' id='image_url' type='text' name='image_url' placeholder="Url de l'image" value="<?= session()->url_image; ?> " />
                <label for='name'>&nbsp;URL de l'image </label>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="category" class="col-12 col-md-2 ">Catégorie</label>
            <div class="col-12 col-md-4">
                <select id="category" name="category" class="form-select">
                    <!-- remplit les catégories disponibles  -->
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id_category'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <a id="btnlink" class="btn btn-primary col-1 col-md-1" title="Associer à une publication" data-bs-toggle="tooltip" onclick="onLink()"><i class="bi bi-link"></i></a>
            <div class="col-12 col-md-5">
                <select id="select_training" name="select_training" class="form-select" disabled="true">
                    <option value='0'>Aucune association</option>
                    <!-- remplit les formations disponibles  -->
                    <?php foreach ($publishes as $publish) : ?>
                        <option value="<?= $publish['id_publication'] ?>"><?= $publish['subject'] ?> <?= getStatus($publish['status'], true) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="fullwidth editor mt-2">
            <textarea class="yesselect " id="editor" name="description" style="width:95%; height:400px"></textarea>
        </div>
        <div class="row fullwidth align-items-center mt-2">
            <div class="col-sm-12 col-md-3 col-xl-1"><button type="submit" class="btn btn-primary">Sauver</button></div>
            <div class="col-sm-12 col-md-3 col-xl-2">
                <input type="checkbox" id="publish" name="publish" checked>
                <label for="publish">Publier</label>
            </div>
        </div>

    </form>
</section>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script  src="<?= base_url() . '/js/infos.js' ?>" ></script>
<script  src="<?= base_url() . '/js/editor.js' ?>"></script>

<script>
    let btnLink = document.getElementById("btnlink");
    let select_training = document.getElementById("select_training");
    let disabled = true;

    function onLink() {
        disabled = select_training.toggleAttribute("disabled");
        if (disabled == false) {
            select_training.value = 0;
        }
    }

    // autorise les tooltips
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<?= $this->endSection() ?>