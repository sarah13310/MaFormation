<?php
$base = base_url(); ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('header') ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= $base ?>/css/stylemain.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700,700i|Source+Code+Pro:400,700&display=swap">
<?= $this->endSection()  ?>

<?= $this->section('content') ?>
<?= $modalDelete ?>
<div class="row">
    <h1 class="col ms-3"><?= $title ?></h1>
    <div class="col-2">
        <form action="/training/preview" method="post">
            <input type="hidden" id="id_page" name="id_page" value="<?= $id_page ?>">
            <input type="hidden" id="id_training" name="id_training" value="<?= $id_training ?>">
            <button type="submit" class="btn <?= $buttonColor ?>">Retour à la liste</button>
        </form>
    </div>
</div>
<hr class="mb-2 mt-2">
<h5 class="ms-3"><?= session()->title_training ?></h5>
<section class="Content ">
    <link rel="stylesheet" href="<?= $base ?>/css/default.min.css" />
    <div class="row">
        <div class="col-12 ">
            <form name="form_training" id="form_training">
                <input type="hidden" id="id_page" name="id_page" value="<?= $id_page ?>">
                <input type="hidden" id="id_training" name="id_training" value="<?= $id_training ?>">
                <input type="hidden" id="title" name="title" value="<?= $page_title ?>">
                <div class="row justify-content-between">
                    <div class="col-12 mb-2">
                        <?php if (strlen($page_title) > 0) : ?>
                            <div class="form-group mb-2 row">
                                <label for="page_title" class="col-2 col-form-label">Page</label>
                                <div class="col-10">
                                    <input class="form-control" id="title_page" name="title_page" type="text" placeholder="Nom de la page" value="<?= $page_title ?>" />
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="form-group mb-2 row">
                                <label for="page_title" class="col-2 col-form-label">Page</label>
                                <div class="col-10">
                                    <input class="form-control" id="title_page" name="title_page" type="text" placeholder="Nom de la page" value="" />
                                </div>
                            </div>
                            <div class="form-group mb-2 row">
                                <label for="select_training" class="col-2 col-form-label">Formation</label>
                                <div class="col">
                                    <select name="select_training" id="select_training" class="form-select">
                                        <?php foreach ($trainings as $training) : ?>
                                            <option value="<?= $training['id_training'] ?>"><?= $training['title'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div>

                                </div>
                            </div>
                        <?php endif ?>
                        <div class="form-group mb-2 row">
                            <label for="select" class="col-2 col-form-label">Catégorie</label>
                            <div class="col-10">
                                <select id="select" name="select" class="form-select">
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category["id_category"] ?>"><?= $category["name"] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12  form-floating mb-3">
                            <input class="form-control" id="image_url" name="image_url" type="text" placeholder="Image de la page" value="<?= base_url() . "/assets/article.svg" ?>" />
                            <label for="image_url">Image de la page</label>
                        </div>
                        <div class=" fullwidth editor mt-2 yesselect">
                            <textarea class="yesselect" id="content" name="content"></textarea>
                        </div>
                        <div class="row fullwidth mt-2">
                            <div class="row align-items-center">
                                <div id="add" class=" col-1 "><a onclick="onSave()" class=" btn btn-outline-primary">Sauver</a></div>
                                <div class="col">
                                    <input type="checkbox" id="publish" name="publish" checked>
                                    <label for="publish">Publier</label>
                                </div>
                            </div>
                        </div>
            </form>
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
    const modalDelete = new bootstrap.Modal('#modalDelete');
    const formDelete = document.getElementById('modalDelete');
    const area = document.getElementById('content');
    const image_url = document.getElementById('image_url');
    const select_training = document.getElementById('select_training');
    let action = "<?= $action ?>";
    //
    if (select_training) {
        select_training.addEventListener("change", () => {
            form_training.id_training.value = select_training[select_training.selectedIndex].value;
            form_training.title.value = select_training[select_training.selectedIndex].innerText;
        });
    }
    // init  de l'éditeur
    function initEditor() {
        sceditor.create(content, {
            format: 'xhtml',
            width: '100%',
            height: '330px',
            icons: 'monocons',
            style: '<?= $base ?>/css/default.min.css',
            locale: 'fr-FR'
        });
    }
    initEditor();
    //
    // Sauvegarder des données
    function onSave() {
        form_training.action = "/training/page/save";
        if (action === "add") {
            form_training.action = "/training/page/add";
        }
        form_training.method = "post";
        form_training.content.value = sceditor.instance(content).val();
        form_training.image_url.value = image_url.value;
        form_training.submit();
    }
    let text = sceditor.instance(content).val('<?= str_replace("'","&#039",$content) ?>', false);
    area.value = text.val();
</script>

<?= $this->endSection() ?>