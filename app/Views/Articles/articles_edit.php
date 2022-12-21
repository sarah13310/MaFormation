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

    <form action="/admin/articles/edit" method="post">
        <div class="row">
            <div class='form-floating mb-3 col-12 col-md-4'>
                <input class='form-control' id='subject' type='text' name='subject' placeholder="Nom de l'article" />
                <label for='subject'>&nbsp;Nom de l'article (*)</label>
            </div>
            <div class='form-floating mb-3 col-12 col-md-4'>
                <input class='form-control' id='name' type='text' name='name' placeholder="Nom de l'auteur" readonly value="<?= session()->name . " " . session()->firstname; ?> " />
                <label for='name'>&nbsp;Nom de l'auteur </label>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="select" class="col-12 col-md-2 ">Catégorie</label>
            <div class="col-12 col-md-4">
                <select id="select" name="category" class="form-select">
                    <!-- remplit les catégories disponibles  -->
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id_category'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <a id="btnlink" class="btn btn-primary col-1 col-md-1" onclick="onLink()"><i class="bi bi-link"></i></a>
            <div class="col-12 col-md-5">
                <select id="select_training" name="select" class="form-select" disabled="true">
                    <!-- remplit les formations disponibles  -->
                    <?php foreach ($publishes as $publish) : ?>
                        <option value="<?= $publish['id_publication'] ?>"><?= $publish['subject'] ?></option>
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
<script>
    let warning = document.getElementById("warning");
    let error = document.getElementById("error");
    let success = document.getElementById("success");
    let btnLink = document.getElementById("btnlink");
    let select_training = document.getElementById("select_training");

    sceditor.create(document.getElementById('editor'), {
        format: 'bbcode',
        width: '100%',
        height: '330px',
        icons: 'monocons',
        style: '<?= $base ?>/css/default.min.css',
        locale: 'fr-FR'
    });

    setTimeout(() => {
        if (warning) {
            warning.remove();
        }
        if (error) {
            error.remove();
        }
        if (success) {
            success.remove();
        }
    }, 1500);


    let disabled = true;

    function onLink() {
        disabled = select_training.toggleAttribute("disabled");
    }
</script>
<?= $this->endSection() ?>