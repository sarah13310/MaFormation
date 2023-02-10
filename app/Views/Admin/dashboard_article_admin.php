<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<div class="modal" tabindex="-1" id="myModalDelete">
    <div class="modal-dialog">
        <form name="form_delete">
            <input id="id" name="id_article" type="hidden" value="">
            <div class="modal-content" style="align-items:center">
                <div class="modal-header">
                    <h5 class="modal-title">Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Voulez-vous effacer cet article?</h6>
                </div>
                <div class="modal-footer mb-0">
                    <button type=button class="btn <?= $buttonColor ?>" onClick="onConfirmDelete()">Supprimer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </form>
    </div>
</div>
<h1 class="mb-2"><i class="bi bi-stoplights"></i>&nbsp;&nbsp;<?= $title ?></h1>

<table class="table table-hover border">
    <thead class="<?= $headerColor ?>">
        <tr d-flex align-items-center>
            <th scope="col">Sujet</th>
            <!-- <th scope="col">Description</th> -->
            <th scope="col">Date</th>
            <th scope="col">Auteur</th>
            <th colspan='3' scope="col">Actions</th>
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($articles as $article) : ?>
        <tr class=" ">
            <td><?= $article['subject'] ?></td>
            <!-- <td><?= $article['description'] ?></td> -->
            <td><?= $article['datetime'] ?></td>

            <?php foreach ($article['user'] as $user) : ?>
                <td><?= $user['name'] . " " . $user['firstname'] ?></td>
            <?php endforeach ?>

            <td>
                <form action="/article/preview" method="post">
                    <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                    <button type="submit" class="btn mr-2 "><i class="bi bi-eye"></i></button>
                </form>
            </td>
            <td>
                <button onclick="onDelete(<?= $article['id_article'] ?>,'/article/delete')" id="btn_confirm" type="button" class="btn mr-2 "><i class="bi bi-trash"></i></button>
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