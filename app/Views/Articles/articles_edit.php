<?= $this->extend('layouts/profil') ?>
<?= $this->section('header') ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= base_url() ?>/css/stylemain.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700,700i|Source+Code+Pro:400,700&display=swap">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<section class="Content">
    <link rel="stylesheet" href="<?= base_url() ?>/css/default.min.css" />
    <script src="<?= base_url() ?>/js/sceditor.min.js"></script>
    <script src="<?= base_url() ?>/js/languages/fr.js"></script>
    <script src="<?= base_url() ?>/js/bbcode.min.js"></script>
    <script src="<?= base_url() ?>/js/monocons.min.js"></script>

    <form action="/admin/articles/edit" method="post">
        <div class='form-floating mb-3'>
            <input class='form-control' id='title_example' type='text' name='subject' placeholder="Nom de l'article" />
            <label for='title_example'>Nom de l'article (*)</label>
        </div>
        <div class="fullwidth editor">
            <p><?= $subtitle ?></p>
            <textarea id="example" name="description" style="width: 90%; height: 400px">
        </textarea>
        </div>
        <div class="row fullwidth align-items-center mt-2">
            <div class="col-sm-12 col-md-3  col-xl-1"><button type="submit" class="btn btn-primary">Sauver</button></div>
            <div class="col-sm-12 col-md-3  col-xl-2">
                <input type="checkbox" id="publish" name="publish" checked>
                <label for="publish">Publier</label>
            </div>
        </div>
    </form>
</section>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    sceditor.create(document.getElementById('example'), {
        format: 'bbcode',
        width: '95%',
        icons: 'monocons',
        style: 'css/default.min.css',
        locale: 'fr-FR'
    });
</script>
<?= $this->endSection() ?>