<?= $this->extend('layouts/profil_former') ?>
<?= $this->section('header') ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= base_url() ?>/css/stylemain.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700,700i|Source+Code+Pro:400,700&display=swap">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<section class="Content">
    <link rel="stylesheet" href="css/default.min.css" />
    <script src="<?= base_url() ?>/js/sceditor.min.js"></script>
    <script src="<?= base_url() ?>/js/languages/fr.js"></script>
    <script src="<?= base_url() ?>/js/bbcode.min.js"></script>
    <script src="<?= base_url() ?>/js/monocons.min.js"></script>
    <div class="fullwidth Intro">
        <p><?= $subtitle ?></p>
        <textarea id="example" style="width: 80%; height: 400px">[b]Faisons [/b]un essai! :)


        </textarea>
    </div>
</section>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    sceditor.create(document.getElementById('example'), {
        format: 'bbcode',
        width: '90%',
        icons: 'monocons',
        style: 'css/default.min.css',
        locale: 'fr-FR'
    });
</script>
<?= $this->endSection() ?>