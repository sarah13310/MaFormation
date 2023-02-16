<?php $base = base_url(); ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('header') ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= $base ?>/css/stylemain.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700,700i|Source+Code+Pro:400,700&display=swap">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex noselect">
    <span><h1 class="col noselect"><i class="bi bi-grid"></i>&nbsp;&nbsp;<?= $title ?></h1></span>
    <span class="mt-2"><b>&nbsp;&nbsp;<?= session()->title_page ?>&nbsp;&nbsp; -  </b></span>
    <span class="mt-2">&nbsp;&nbsp;&nbsp;<i><?= session()->title_training ?></i></span>
</div>
<hr class="mb-2 mt-1">
<section class="Content noselect ">
    <link rel="stylesheet" href="<?= $base ?>/css/default.min.css" />

    <!-- Row -->
    <div class="col noselect">
        <div class="col center">
            <img class="img-fluid w-10" src="<?= session()->image_page ?>" />
        </div>
        <div class="noselect col-9 fullwidth editor mt-2" style="margin-top: 0px!important;">
            <textarea  id="content" class="noselect" name="description" style="width:100%; height:400px"><?= session()->content ?>
                </textarea>
        </div>
    </div>

</section>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= $base ?>/js/sceditor.min.js"></script>
<script src="<?= $base ?>/js/languages/fr.js"></script>
<script src="<?= $base ?>/js/bbcode.min.js"></script>
<script src="<?= $base ?>/js/monocons.min.js"></script>

<script>
    let content = document.getElementById('content');

    // init  de l'éditeur
    function initEditor() {
        sceditor.create(content, {
            format: 'xhtml',
            width: '100%',
            height: '420px',
            icons: 'monocons',
            style: '<?= $base ?>/css/default.min.css',
            locale: 'fr-FR'
        });
    }

    // gestion des ellipses en js
    String.prototype.trunc =
        function(n) {
            return this.substr(0, n - 1) + (this.length > n ? '...' : '');
        };

    initEditor();
    /* on cache la toolbar */
    let toolbar = document.getElementsByClassName("sceditor-toolbar")[0];
    toolbar.classList.add("collapse");

    let text = sceditor.instance(content).val('<?= str_replace("'","&#039",session()->content) ?>', false);
    sceditor.instance(content).readOnly(true);
    //area.value = text.val();
</script>
<?= $this->endSection() ?>