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
<h1 class="mb-2"><?= $title ?></h1>
<table class="table border">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th scope="col">Sujet</th>
            <th scope="col">Date et heure</th>
            <th colspan="3" scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        foreach ($trainings as $training) : ?>
            <tr class="mt-4" style="border-top:2px solid; <?= (count($training['pages']) > 0) ? 'border-bottom:hidden' : '' ?>">
                <td><?= $training['title'] ?></td>
                <td><?= $training['date'] ?></td>
                <td>
                    <form action="/training/preview" method="post">
                        <input type="hidden" name="id_training" value="<?= $training['id_training'] ?>">
                        <button type="submit" class="btn mr-2 "><i class="bi bi-eye"></i></button>
                    </form>
                </td>
                <td>
                    <button onclick="onDelete(<?= $training['id_training'] ?>,'/training/delete')" id="btn_confirm" type="button" class="btn mr-2 "><i class="bi bi-trash"></i></button>
                </td>
                <td>
                    <select class="modifState" class="mt-2">
                        <option value="1">En attente </option>
                        <option value="2">Validé</option>
                        <option value="3">Refusé</option>
                        <option value="4">Déclassé</option>
                    </select>
                </td>
            </tr>
            <?php if (count($training['pages']) > 0) : ?>
                <tr class="mt-3" style="border-style:none;">
                    <td colspan="4">
                        <div class="mx-auto row <?= $headerColor ?>">
                            <a class="col btn btn-collapse" style="border:0px solid black;" data-bs-toggle="collapse" href="#collapse<?= $i ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="bi bi-caret-down noselect"></i>&nbsp;&nbsp;&nbsp;&nbsp;Articles
                            </a>
                        </div>
                    </td>
                </tr>
                <tr style="border-style:hidden;border-bottom:2px solid;">
                    <div class="collapse" id="collapse<?= $i ?>">
                        <div class="card card-body w-100">
                            <?php foreach ($training['pages'] as $pages) : ?>
                                <td>
                                    <?= $page['title'] ?>
                                </td>
                                <td>
                                    <?= "" ?>
                                </td>
                                <td>
                                    <form action="/page/preview" method="post">
                                        <input type="hidden" name="id_page" value="<?= $page['id_page'] ?>">
                                        <input type="hidden" name="image_url" value="<?= $page['image_url'] ?>">
                                        <button type="submit" class="btn mr-2 "><i class="bi bi-eye"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="/page/delete" method="post">
                                        <input type="hidden" name="id_page" value="<?= $article['id_page'] ?>">
                                        <button type="submit" class="btn mr-2 "><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            <?php endforeach ?>
                        </div>
                    </div>

                </tr>
            <?php endif; ?>
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