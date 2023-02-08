<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<div class="modal" tabindex="-1" id="myModalDelete">
    <div class="modal-dialog">
        <form name="form_delete">
            <input id="id" name="id_media" type="hidden" value="">
            <div class="modal-content" style="align-items:center">
                <div class="modal-header">
                    <h5 class="modal-title">Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Voulez-vous effacer<?= $typeofmedia ?>?</h6>
                </div>
                <div class="modal-footer mb-0">
                    <button type=button class="btn <?= $buttonColor ?>" onClick="onConfirmDelete()">Supprimer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </form>
    </div>
</div>
<h1 class="mb-2"><?= $title ?></h1>

<table class="table table-hover border">
    <thead class="<?= $headerColor ?>">
        <tr d-flex align-items-center>

            <th scope="col">Nom</th>
            <th scope="col">Auteur</th>
            <th scope="col">URL</th>
            <th scope="col">URL de l'image</th>
            <th scope="col">Diffuseur</th>
            <th colspan='2' scope="col">Actions</th>
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($listmedias as $media) : ?>
        <tr class=" ">
            <td><?= $media['name'] ?></td>
            <td><?= $media['author'] ?></td>
            <td><a href="<?= $media['url'] ?>"><i class="bi bi-eye"></i></a></td>
            <td><a href="<?= $media['image_url'] ?>"><i class="bi bi-eye"></i></a></td>
            <?php foreach ($media['user'] as $user) : ?>
                <td><?= $user['name'] . " " . $user['firstname'] ?></td>
            <?php endforeach ?>
            <td>
                <button onclick="onDelete(<?= $media['id_media'] ?>,'/media/delete')" id="btn_confirm" type="button" class="btn mr-2 "><i class="bi bi-trash"></i></button>
            </td>
            <td>
                <select class="mt-2">
                    <option>En attente</option>
                    <option>Validé</option>
                    <option>Refusé</option>
                </select>
            </td>

        </tr>
    <?php $i++;
    endforeach ?>

</table>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    let myModalDelete = document.getElementById('myModalDelete');
    let modalDelete = bootstrap.Modal.getOrCreateInstance(myModalDelete);

    function onDelete(id, action = "") {
        document.form_delete.method = "POST";
        document.form_delete.id.value = id;
        document.form_delete.action = action;
        modalDelete.show();
        return false;
    }

    function onConfirmDelete() {
        document.form_delete.submit();
    }
</script>
<?= $this->endSection() ?>