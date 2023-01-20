<?php $base = base_url(); ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('header') ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= $base ?>/css/stylemain.css">
<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700,700i|Source+Code+Pro:400,700&display=swap">
 --><?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="ms-3"><?= $title ?></h1>
<hr class="hr mt-1 mb-2">
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
    <form action="/admin/publishes/edit" method="post">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class='form-floating mb-3 col-12 col-md-6'>
                        <input class='form-control' id='subject' type='text' name='subject' placeholder="Nom de la publication(*)" />
                        <label for='subject'>&nbsp;Nom de la publication</label>
                    </div>
                    <div class='form-floating mb-3 col-12 col-md-6'>
                        <input class='form-control' id='name' type='text' name='name' placeholder="Nom de l'auteur" readonly value="<?= session()->name . " " . session()->firstname; ?> " />
                        <label for='name'>&nbsp;Nom de l'auteur </label>
                    </div>
                    <div class='form-floating mb-3 col'>
                        <input class='form-control' id='image_url' type='text' name='image_url' placeholder="Url de la publication" value="<?=base_url()."/assets/publication.svg" ?>" />
                        <label for='image_url'>&nbsp;Url de la publication</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="category" class="col-2 col-form-label">Catégorie</label>
                    <div class="col-10">
                        <select id="category" name="category" class="form-select">
                            <!-- remplit les catégories disponibles  -->
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category['id_category'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="fullwidth editor mt-2">
                    <textarea id="editor" name="description"></textarea>
                </div>

            </div>
            <div class="col-12 col-md-4 ">
                <div class="row mb-2">
                    <div class="col-12 col-md-2"><a href="/admin/articles/edit" class="btn btn-primary" title="Nouvel Article" data-bs-toggle="tooltip"><i class="bi bi-plus-circle"></i></a></div>
                    <div class="col-12 col-md-10">Sélectionner vos articles dans la liste :</div>
                </div>
                <select multiple="multiple" name='list_articles[]' id="list_articles" style="width:100%;VISIBILITY: visible;" size=15>
                    <?php foreach ($articles as $article) : ?>
                        <option value="<?= $article['id_article'] ?>"><?= $article['subject'] ?></option>
                    <?php endforeach ?>
                </select>
                <div class="row align-items-center mt-2">
                    <div class="col-12 col-md-3"><button type="submit" class="btn btn-primary">Sauver</button></div>
                    <div class="col-12 col-md-3 ">
                        <input type="checkbox" id="publish" name="publish" checked>
                        <label for="publish">Publier</label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- chargements des modules -->
<script src="<?= base_url() . '/js/infos.js' ?>" type="module"></script>
<script src="<?= base_url() . '/js/editor.js' ?>" type="module"></script>
<script>
    // autorise les tooltips
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<?= $this->endSection() ?>