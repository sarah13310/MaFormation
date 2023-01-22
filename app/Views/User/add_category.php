<?= $this->extend('layouts/profil') ?>


<?= $this->section('content') ?>
<div class="modal" tabindex="-1" id="myModalDelete">
    <div class="modal-dialog">
        <form name="form_delete">
            <input id="id" name="id_category" type="hidden" value="">
            <div class="modal-content" style="align-items:center">
                <div class="modal-header">
                    <h5 class="modal-title">Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Voulez-vous effacer cette catégorie?</h6>
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

    <div class="col-12 col-md-6">
        <form name="form_add">
            <input type="hidden" id="id_category" name="id_category">
            <div class='col form-floating mb-3'>
                <input type="text" class="form-control mb-2" name="name" id="input_name" placeholder='Nom de la catégorie'>
                <label for="name">Nom de la catégorie</label>
            </div>
            <div>
                <button onclick="onAdd()" id="btnAdd" type="button" class="btn <?= $buttonColor ?>">Ajouter</button>
            </div>
        </form>
    </div>
    <div class="mt-4 col">
        <table class="w-50 table border table-hover">
            <thead class=<?= $headerColor ?>>
                <tr>
                    <th>Nom de la catégorie</th>
                    <th class="w-25" colspan="2">Actions</th>
                    <th class="hidden"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) : ?>
                    <tr onclick="onSelect(this.parentElement.parentElement)">
                        <td><?= $category['name'] ?></td>
                        <td>
                            <a type="button" onclick="onDelete(<?= $category['id_category'] ?>)" class="col-1 btn mr-2 "><i class="bi bi-trash"></i></button>
                        </td>
                        <td>
                            <a type="button" onclick="onModify(this.parentElement.parentElement)" class="col-1 btn mr-2 "><i class="bi bi-pencil"></i></button>
                        </td>
                        <td class="hidden"><?= $category['id_category'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script defer src="<?= base_url() . '/js/infos.js' ?>"></script>
<script>
    let myModalDelete = document.getElementById('myModalDelete');
    let modalDelete = bootstrap.Modal.getOrCreateInstance(myModalDelete);
    let btnAdd = document.getElementById("btnAdd");
    let input_name = document.getElementById("input_name");
    let states = document.getElementsByClassName("modifState");
    let modify = false;
    let selectItem = null;
    let text = "";

    function onDelete(id) {
        document.form_delete.method = "POST";
        document.form_delete.id.value = id;
        document.form_delete.action = "/user/category/delete";
        modalDelete.show();
        return false;
    }

    function onModify(elem) {
        event.stopPropagation();
        btnAdd.innerText = "Modifier";
        selectItem = elem;
        if (selectItem) {
            input_name.value = selectItem.cells[0].innerText;
            modify = true;
        }
    }

    function onConfirmDelete() {
        document.form_delete.submit();
    }

    function onSelect(elem) {
        modify = false;
        selectItem = elem;
        btnAdd.innerText = "Ajouter";
        input_name.value = "";
    }

    input_name.oninput = (event) => {

        if (modify) {
            text = event.target.value;
            console.log(text);
        }
    }

    function onAdd() {
        document.form_add.method = "POST";
        input_name.value = "";
        if (!modify) { // ajouter
            document.form_add.action = "/user/category/add";
            document.form_add.submit();
        } else { // modification
            document.form_add.action = "/user/category/modify";
            input_name.value = selectItem.cells[0].innerText;
            document.form_add.id_category.value = selectItem.cells[3].innerText;
            document.form_add.name.value = text;
            document.form_add.submit();
        }
    }
</script>

<?= $this->endSection() ?>