<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="ms-4 mb-3"><?= $title ?></h1>
<hr>
<?php if (session()->get('success')) : ?>
    <div id="success" class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalexit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supprimer compétence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Voulez-vous effacer cette compétence?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                <button onclick="ConfirmDelete();" type="button" class="btn btn-primary">Oui</button>
            </div>
        </div>
    </div>
</div>
<div class="mt-4 container">
    <div class="row">
        <div class="col tbodyDiv ">
            <table class="table table-hover border">
                <thead class="<?= $headerColor ?> sticky-top">
                    <tr>
                        <th class="hidden" scope="col">id</th>
                        <th class="col" scope="col">Titre</th>
                        <th class="col" scope="col">Date d'obtention</th>
                        <th class="hidden" scope="col">Content</th>
                        <th class="col" scope="col">Nom de l'organisme</th>
                        <th class="hidden" scope="col">address</th>
                        <th class="hidden" scope="col">City</th>
                        <th class="hidden" scope="col">Cp</th>
                        <th class="col" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="">
                    <?php foreach ($skills as $skill) : ?>
                        <form action="/" onsubmit="return onDelete()">
                            <tr onclick="onSelectRow(this);">
                                <td class="hidden" scope="col"><?= $skill['id_certificate'] ?></td>
                                <td class="col" scope="col"><?= $skill['name'] ?></td>
                                <td class="col" scope="col"><?= $skill['date'] ?></td>
                                <td class="hidden" scope="col"><?= $skill['content'] ?></td>
                                <td class="col" scope="col"><?= $skill['organism'] ?></td>
                                <td class="hidden" scope="col"><?= $skill['address'] ?></td>
                                <td class="hidden" scope="col"><?= $skill['city'] ?></td>
                                <td class="hidden" scope="col"><?= $skill['cp'] ?></td>
                                <td class="view col" scope="col"><button type="submit" class="btn" ><i class="bi bi-trash"></i></button></td>
                            </tr>
                        </form>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="col-12 col-md-4">
            <form name="modif" action="/user/profil/skill" method="post">
                <input type="hidden" id="id_certificate" name="id_certificate">
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="name" id="name" placeholder='Titre de formation'>
                    <label for="name">Titre de formation</label>
                </div>
                <!-- date -->
                <div class='col form-floating mb-3'>
                    <input type="date" class="form-control mb-2" name="date" id="date" placeholder='Date de formation'>
                    <label for="date">Date de formation</label>
                </div>
                <!-- description -->
                <div class='col form-outline mb-3'>
                    <textarea class="form-control mb-2" rows="3" name="content" id="content" placeholder="Description"></textarea>

                </div>
                <!-- organisme de formation -->
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="organism" id="organism" placeholder="Nom de l'organisme">
                    <label for="organism">Nom de l'organisme</label>
                </div>
                <!-- adresse -->
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="address" id="address" placeholder="Adresse de l'organisme">
                    <label for="address">Adresse de l'organisme</label>
                </div>
                <!-- ville -->
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="city" id="city" placeholder="Ville de l'organisme">
                    <label for="city">Ville de l'organisme</label>
                </div>
                <!-- cp -->
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="cp" id="cp" placeholder="Code postale">
                    <label for="cp">Code postale</label>
                </div>
                <!-- pays -->
                <div class='col form-floating mb-3'>
                    <input type="text" readonly class="form-control mb-2" name="country" id="country" value="France" placeholder="Code postale">
                    <label for="country">Pays</label>
                </div>
                <div>
                    <button id="btnModify" type="submit" class="btn <?= $buttonColor ?>">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
    let selectItem = null;

    function onSelectRow(elem) {
        selectItem = elem;
        document.forms['modif'].id_certificate.value = selectItem.children[0].innerText;
        document.forms['modif'].name.value = selectItem.children[1].innerText;
        document.forms['modif'].date.value = selectItem.children[2].innerText;
        document.forms['modif'].content.value = selectItem.children[3].innerText;
        document.forms['modif'].organism.value = selectItem.children[4].innerText;
        document.forms['modif'].address.value = selectItem.children[5].innerText;
        document.forms['modif'].city.value = selectItem.children[6].innerText;
        document.forms['modif'].cp.value = selectItem.children[7].innerText;
        document.forms['modif'].country.value = "France";
    }

    let modalD = document.getElementById('modalDelete');
    let modalDelete = bootstrap.Modal.getOrCreateInstance(modalD);

    modalD.onsubmit = () => {
        console.log("submit");
        modalDelete.show();
        return false;
    }

    function onDelete() {
        console.log("delete");
        modalDelete.show();
        return false;
    }
    function ConfirmDelete(){
        modalDelete.hide();
        window.location.href="/user/profil/skill/delete/"+selectItem.children[0].innerText;
    }
    modalD.addEventListener('show.bs.modal', function(event) {

    });
</script>
<?= $this->endSection() ?>