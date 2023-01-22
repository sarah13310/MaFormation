<?= $this->extend('layouts/profil') ?>


<?= $this->section('content') ?>
<div class="modal" tabindex="-1" id="myModalDelete">
    <div class="modal-dialog">
        <form name="form_delete">
            <input id="id" name="id_page" type="hidden" value="">
            <!-- <input id="id_training" name="id_training" type="hidden" value=""> -->
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
<h1 class="ms-4 mb-3"><?= $title ?></h1>
<hr>
<?php if (session()->get('success')) : ?>
    <div id="success" class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>

<div class="mt-4 container">

    <div class="mt-4 col">
        <table class="table border table-hover">
            <thead class=<?= $headerColor ?>>
                <tr>
                    <th>Nom de la page</th>
                    <th>couverture de la page</th>
                    <th class="w-25" colspan="2">Actions</th>
                    <th class="hidden"></th>
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
                            <form name="form_modify">
                                <input id="id_page" type="hidden" >
                                <input id="id_training" type="hidden" value="<?= $id_training?>">
                                <a type="button" onclick="onModify(this.parentElement.parentElement)" class="col-1 btn mr-2 "><i class="bi bi-pencil"></i></button>
                            </form>
                        </td>                        
                        <td class="hidden"><?= $page['id_page'] ?></td>
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
        document.form_delete.method = "POST";
        document.form_delete.action = "/training/page/delete";
        document.form_delete.id.value = id;
        modalDelete.show();
        return false;
    }

    function onConfirmDelete() {
        document.form_delete.submit();
    }

    function onModify(elem) {        
        event.stopPropagation();
        document.form_modify.method = "POST";
        document.form_modify.action = "/training/page/modify";
        document.form_modify.id_page.value = elem.cells[4].innerText;        
        document.form_modify.submit();        
    }

 
</script>

<?= $this->endSection() ?>