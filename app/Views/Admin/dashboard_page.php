<?= $this->extend('layouts/profil') ?>


<?= $this->section('content') ?>
<div class="modal" tabindex="-1" id="myModalDelete">
    <div class="modal-dialog">
        <form name="form_page_delete" action="/training/page/delete" method="post">
            <input id="id_page" name="id_page" type="hidden" />
            <input id="id_training" name="id_training" type="hidden" value=<?= $id_training ?> />
            <div class="modal-content" style="align-items:center">
                <div class="modal-header">
                    <h5 class="modal-title">Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Voulez-vous effacer cette page?</h6>
                </div>
                <div class="modal-footer mb-0">
                    <a type=button class="btn <?= $buttonColor ?>" onClick="onConfirmDelete()">Supprimer</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </form>
    </div>
</div>
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
        <a href="/former/training/edit" class="btn <?= $buttonColor ?> col-2 me-3"><i class="bi bi-plus-circle"></i>&nbsp;Ajouter Page</a>
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
                            <a type="button" onclick="onDelete(<?= $page['id_page'] ?>)" class="col-1 btn mr-2 "><i class="bi bi-trash"></i></button>
                        </td>
                        <td>
                            <form name="form_modify" method="POST" action="/training/page/modify">
                                <input id="id_page" name='id_page' type="hidden" value='<?= $page['id_page'] ?>'>
                                <input id="title" name='title' type="hidden" value="<?= session()->title_training ?>">
                                <input id="id_training" name="id_training" type="hidden" value="<?= $id_training ?>">
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
    let myModalDelete = document.getElementById('myModalDelete');
    let modalDelete = bootstrap.Modal.getOrCreateInstance(myModalDelete);

    function onDelete(id) {
        document.form_page_delete.id_page.value = id;
        modalDelete.show();
        return false;
    }

    function onConfirmDelete() {
        document.form_page_delete.submit();
    }
</script>

<?= $this->endSection() ?>