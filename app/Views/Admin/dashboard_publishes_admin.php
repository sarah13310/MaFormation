<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>

<div class="modal" tabindex="-1" id="myModalDelete">
    <div class="modal-dialog">
        <form name="form_delete">
            <input id="id" name="id_publication" type="hidden" value="">
            <div class="modal-content" style="align-items:center">
                <div class="modal-header">
                    <h5 class="modal-title">Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Voulez-vous effacer cet élément?</h6>
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
<table class="table border">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th scope="col">Aperçu</th>
            <th scope="col">Sujet</th>
            <th scope="col">Créé le</th>
            <th colspan="2" scope="col">Actions</th>
            <th scope="col">Voir les articles</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        foreach ($publishes as $publishe) : ?>
            <tr>
                <td>
                    <form action="/publishes/preview" method="post">
                        <input type="hidden" name="id_publication" value="<?= $publishe['id_publication'] ?>">
                        <button type="submit" class="btn mr-2 "><i class="bi bi-eye"></i></button>
                    </form>
                </td>
                <td><?= $publishe['subject'] ?></td>
                <td><?= dateTimeFormat($publishe['datetime']) ?></td>
                <td>
                    <button onclick="onDelete(<?= $publishe['id_publication'] ?>,'/publishes/delete')" id="btn_confirm" type="button" class="btn mr-2 "><i class="bi bi-trash"></i></button>
                </td>
                <td>
                    <select class="modifState" class="mt-2">
                        <option value="1">En attente </option>
                        <option value="2">Validé</option>
                        <option value="3">Refusé</option>
                        <option value="4">Déclassé</option>
                    </select>
                </td>
                <td><button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>">
                        <i class="bi bi-plus"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td colspan=4>
                    <table class="table collapse" id="collapse<?= $i ?>">
                        <thead class="<?= $headerColor ?>">
                            <tr>
                                <th scope="col">Aperçu</th>
                                <th scope="col">Sujet</th>
                                <th scope="col">Créé le</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 0;
                            foreach ($publishe['article'] as $article) : ?>
                                <tr>
                                    <td>
                                        <form action="/article/preview" method="post">
                                            <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                                            <button type="submit" class="btn mr-2 float-end"><i class="bi bi-eye"></i></button>
                                        </form>
                                    </td>
                                    <td><?= $article['subject'] ?></td>
                                    <td><?= dateTimeFormat($article['datetime']) ?></td>
                                    <td>
                                        <form action="/article/delete" method="post">
                                            <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                                            <button type="submit" class="btn mr-2 "><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php $j++;
                            endforeach ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        <?php $i++;
        endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    let myModalDelete = document.getElementById('myModalDelete');
    let modalDelete = bootstrap.Modal.getOrCreateInstance(myModalDelete);
    let states = document.getElementsByClassName("modifState");

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


    for (let i = 0; i < states.length; i++) {
        states[i].addEventListener("change", (event) => {
            const selection = event.target.value.substring(event.target.selectionStart, event.target.selectionEnd);
            console.log(selection);
        });
    };
</script>

<?= $this->endSection() ?>