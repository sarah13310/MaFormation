<?= $this->extend('layouts/profil') ?>


<?= $this->section('content') ?>
<!-- fenetre modale suppression -->
<?= $modalDelete ?>
<!-------------------------------->
<div class="row">
    <div class="col">
        <h1 class=" ms-4 mb-3"><?= $title ?></h1>
    </div>
    <div class="col-2">
        <a href="/training/dashboard" type="button" class="btn <?= $buttonColor ?>">Retour à la liste</a>
    </div>
</div>
<hr>

<?php if (session()->get('success')) : ?>
    <div id="success" class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>

<div class="mt-4 container">
    <div class="row">
        <h5 class="col mt-3 "><?= session()->title_training ?></h5>
        <a href="/training/page/add" class="btn <?= $buttonColor ?> col-2 me-3"><i class="bi bi-plus-circle"></i>&nbsp;Ajouter Page</a>
    </div>
    <div class="mt-2 col">
        <table class="table border table-hover">
            <thead class=<?= $headerColor ?>>
                <tr>
                    <th>Nom de la page</th>
                    <th>couverture de la page</th>
                    <th class="w-25" colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page) : ?>
                    <tr>
                        <td><?= $page['title'] ?></td>
                        <td><?= $page['image_url'] ?></td>
                        <td>
                            <a type="button" onclick="onDelete(<?= $page['id_page']?>, <?= session()->id_training ?>)" class="col-1 btn mr-2 "><i class="bi bi-trash"></i></button>
                        </td>
                        <td>
                            <form name="form_modify" method="POST" action="/training/page/modify">
                                <input id="id_page" name='id_page' type="hidden" value='<?= $page['id_page'] ?>'>
                                <input id="title_page" name='title_page' type="hidden" value='<?= $page['title'] ?>'>
                                <input id="title" name='title' type="hidden" value="<?= session()->title_training ?>">
                                <input id="id_training" name="id_training" type="hidden" value="<?= session()->id_training ?>">
                                <button type="submit" class="col-1 btn mr-2 "><i class="bi bi-pencil"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="col">
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script defer src="<?= base_url() . '/js/infos.js' ?>"></script>
<script>
    let myModalDelete = document.getElementById('modalDelete');
    let modalDelete = bootstrap.Modal.getOrCreateInstance(myModalDelete);

    function onDelete(id_page, id_training) {
        document.modalDelete.id.value = id_page;
        document.modalDelete.id2.value = id_training;
        modalDelete.show();
        document.modalDelete.action="/training/page/delete";
        return false;
    }

    function onConfirmDelete() {
        document.modalDelete.submit();
    }
</script>

<?= $this->endSection() ?>