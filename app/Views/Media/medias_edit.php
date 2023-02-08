<?php $base = base_url(); ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('header') ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= $base ?>/css/stylemain.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700,700i|Source+Code+Pro:400,700&display=swap">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="ms-3"><?= $title ?></h1>

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

    <form action="/admin/<?= $troute ?>/edit" method="post">
        <div class="row">
            <div class='form-floating mb-3 col-12 col-md-4'>
                <input class='form-control' id='name' type='text' name='name' placeholder="Nom du livre" />
                <label for='name'><?= $n ?></label>
            </div>
            <div class='form-floating mb-3 col-12 col-md-4'>
                <input class='form-control' id='author' type='text' name='author' placeholder="Nom de l'auteur"  />
                <label for='author'><?= $na ?></label>
            </div>
            <div class='form-floating mb-3 col-12 col-md-4'>
                <input class='form-control' id='url' type='text' name='url' placeholder="Url du livre"  />
                <label for='url'><?= $u ?></label>
            </div>
            <div class='form-floating mb-3 col-12 col-md-4'>
                <input class='form-control' id='image_url' type='text' name='image_url' placeholder="Url de la couverture du livre"  />
                <label for='image_url'><?= $ucm ?></label>
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
        </div>

        <div class="fullwidth editor mt-2">
            <textarea id="editor" name="description" style="width:95%; height:400px">
        </textarea>
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
<script src="<?= base_url() . '/js/infos.js' ?>" type="module"></script>
<script src="<?= base_url() . '/js/editor.js' ?>" type="module"></script>


<?= $this->endSection() ?>