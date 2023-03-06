<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<div class="modal" tabindex="-1" id="myModalDelete">
    <div class="modal-dialog">
        <form name="form_delete">
            <input id="id_media" name="id_media" type="hidden" value="">
            <input id="type_media" name="type_media" type="hidden" value="<?=$typeofmedia ?>">
            <div class="modal-content" style="align-items:center">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Suppression</b></h5>
                    <button type="button" class="btn-close flex-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Voulez-vous effacer <?= ($typeofmedia == 1) ? "la vidéo" : "le livre" ?>?</h5>
                </div>
                <div class="modal-footer mb-0">
                    <button type=button class="btn <?= $buttonColor ?>" onClick="onConfirmDelete()">Supprimer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div>
    <div class="d-flex">
        <h1 class="col mb-2 noselect"><i class="bi bi-stoplights"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2">
    <div class="mb-1 col noselect" id="option"></div>
</div>

<table class="table table-hover border rounded-1">
    <thead class="<?= $headerColor ?>">
        <tr d-flex align-items-center>
            <th scope="col"></th>
            <th scope="col">Nom</th>
            <th scope="col">Auteur</th>
            <th colspan='2' scope="col">Actions</th>
        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>

<form name="form_preview" action="/media/preview" method="post">
    <input type="hidden" name="id_media">
    <input type="hidden" name="status">
</form>

<div class="pagination w-75">
    <ul class=""></ul>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/date.js"></script>
<script src="<?= base_url() ?>/js/paginate2.js"></script>
<script src="<?= base_url() ?>/js/dropstate.js"></script>
<script>
    let myModalDelete = document.getElementById('myModalDelete');
    let modalDelete = bootstrap.Modal.getOrCreateInstance(myModalDelete);

    getStoragePage(localStorage.page_media);

    option.append(OptionPagination());

    function onDelete(id, action = "/media/delete") {
        document.form_delete.method = "POST";
        document.form_delete.id_media.value = id;
        document.form_delete.action = action;
        modalDelete.show();
        return false;
    }

    function onConfirmDelete() {
        document.form_delete.submit();
    }


    function DisplayNone() {
        let rows = 4;
        if (buffer.length == 0) {
            let tr = document.createElement("tr");
            tr.innerHTML = `<td colspan=${rows}><img src='<?= constant("NO_ITEMS") ?>'></td>`;
            tr.style = "height:250px;text-align:center";
            tbody.append(tr);
            tbody.innerHTML += "<td class='h4 text-muted' colspan=4 style='border-top-style: hidden;text-align:center'>Aucun élément</td>";
            pagination.remove();
        }
    }

    loadData('<?= $media_json ?>', '<?= ($typeofmedia == 1) ? "vidéos" : "livres" ?>', localStorage.page_media);

    function Row(parent, data) {

        let tr = document.createElement("tr");
        let td = document.createElement("td");
        let td4 = document.createElement("td");
        let img = document.createElement("img");
        let a = document.createElement("a");

        tr.style = "height:25px;";
        td.style = "width:50px";
        img.classList.add("circle1");
        img.classList.add("thumbail");
        img.setAttribute("loading", "lazy");
        img.src = `${data.image_url}`;
        a.href = `${data.url}`;

        tr.append(td);
        td.append(a);
        a.append(img);
        tr.innerHTML += `<td>${data.name}</td> <td>${data.author}</td> <td><a role="button" onclick="onDelete(${data.id_media})"><i class='bi bi-trash'></a></td>`

        let dropstate = new DropState(data.id_media);
        dropstate.setState(data.status);
        dropstate.addEventListener("state", (e) => {
            form_preview.action = "/media/status/<?= $typeofmedia ?>";
            form_preview.id_media.value = e.detail.identifiant;
            form_preview.status.value = e.detail.value;
            form_preview.submit();
            return true;
        });
        td4.append(dropstate);
        tr.append(td4);
        tbody.append(tr);
        loadImages();
    }

    
    ApplyTheme(<?= session()->type ?>);

    window.addEventListener("load", event => {
        var imgs = document.querySelectorAll('img');
        imgs.forEach((elem) => {
            if (elem.classList.contains('circle1'))
                elem.classList.remove('circle1');
        })
    });

    function loadImages() {
        var imgs = document.querySelectorAll('img');
        imgs.forEach((elem) => {
            elem.addEventListener('load', () => {
                if (elem.classList.contains('circle1'))
                    elem.classList.remove('circle1');
            })
        });
    }

    tbody.addEventListener("page", (e) => {
        localStorage.page_media = e.detail.current;
    })
</script>
<?= $this->endSection() ?>