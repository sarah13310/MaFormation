<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>

<div class="modal" tabindex="-1" id="myModalDelete">
    <div class="modal-dialog">
        <form name="form_delete">
            <input id="id" name="id_training" type="hidden" value="">
            <div class="modal-content" style="align-items:center">
                <div class="modal-header">
                    <h5 class="modal-title">Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Voulez-vous effacer cet élément?</h5>
                </div>
                <div class="modal-footer mb-0">
                    <button type=button class="btn <?= $buttonColor ?>" onClick="onConfirmDelete()">Supprimer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="noselect">
    <div class="d-flex ">
        <h1 class="col mb-2 noselect"><i class="bi bi-stoplights"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2">
    <div class="mb-1 col noselect " id="option"></div>
</div>

<table class="table border rounded-1">
    <thead class="<?= $headerColor ?> ">
        <tr>
            <th style = "height:25px;width:50px;"></th>
            <th scope="col">Sujet </th>
            <th scope="col">Date et heure</th>
            <th colspan="2" scope="col">Actions</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>
<div class="pagination">
    <ul class=""></ul>
</div>

<form name="form_status" action="/training/status">
    <input type="hidden" name="id_training">
    <input type="hidden" name="status">
</form>
<?= $this->endSection() ?>
<!-- // -->
<?= $this->section('js') ?>
<script src="<?= base_url() . '/js/date.js' ?>"></script>
<script src="<?= base_url() . '/js/paginate2.js' ?>"></script>
<script src="<?= base_url() . '/js/dropstate.js' ?>"></script>

<script>
    let myModalDelete = document.getElementById('myModalDelete');
    let modalDelete = bootstrap.Modal.getOrCreateInstance(myModalDelete);
    //let states = document.getElementsByClassName("modifState");

    function onDelete(id) {
        document.form_delete.method = "POST";
        document.form_delete.action = "/training/delete";
        document.form_delete.id.value = id;
        modalDelete.show();
        return false;
    }

    function onConfirmDelete() {
        form_delete.method = "POST";
        form_delete.submit();
    }

    function onPreview(id) {
        form_status.method = "POST";
        form_status.id_training=id;
        form_status.action="/training/preview";
        form_status.submit();
    }

    getStoragePage(localStorage.page_training);
    option.append(OptionPagination());

    function DisplayNone() {
        let rows = 4;
        if (buffer.length == 0) {
            let tr = document.createElement("tr");
            tr.innerHTML = `<td colspan=${rows}><img  src='<?= constant("NO_ITEMS") ?>'></td>`;
            tr.style = "height:250px;text-align:center";
            tbody.append(tr);
            tbody.innerHTML += "<td class='h4 text-muted' colspan=4 style='border-top-style: hidden;text-align:center'>Aucun élément</td>";
            pagination.remove();
        }
    }

    function Row(parent, data, i) {

        let tr = document.createElement("tr");
        let td = document.createElement("td");
        let img = document.createElement("img");
        let a = document.createElement("a");
        a.setAttribute("onClick",`onPreview(${data.id_training});`);
        a.setAttribute("role","button");        
        img.classList.add("circle1");
        img.classList.add("thumbail");
        img.setAttribute("loading", "lazy");
        img.src = `${data.image_url}`;
        
        tr.append(td);
        td.append(a);
        a.append(img);

        tr.innerHTML += `<td>${data.title}</td> <td>${data.date}</td>`;
        tr.innerHTML += `<td><a onClick="onPreview('${data.id_training}');"><i class='bi bi-eye'></i></a></td>`;
        tr.innerHTML += `<td><a onClick="onDelete('${data.id_training}');"><i class='bi bi-trash'></i></a></td>`;
        let dropstate = new DropState(data.id_training);
        dropstate.setState(data.status);
        dropstate.addEventListener("state", (e) => {
            form_status.method = "POST";
            form_status.id_training.value = e.detail.identifiant;
            form_status.status.value = e.detail.value;
            form_status.submit();
            return true;
        });
        let td5=document.createElement("td");
        td5.append(dropstate);
        tr.append(td5);
        tbody.append(tr);
        loadImages();
    }

    loadData('<?= $training_json ?>', "formations", localStorage.page_training);
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
        localStorage.page_training = e.detail.current;
    });

    ModalTheme(<?= session()->type ?>);
</script>

<?= $this->endSection() ?>