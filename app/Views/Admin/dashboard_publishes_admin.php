<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>

<div class="modal" tabindex="-1" id="myModalDelete">
    <div class="modal-dialog">
        <form name="form_delete">
            <input id="id_publication" name="id_publication" type="hidden">
            <input id="id_article" name="id_article" type="hidden">
            <div class="modal-content" style="align-items:center">
                <div class="modal-header">
                    <span class="modal-title">Suppression</span>
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
<div>
    <div class="d-flex">
        <h1 class="col mb-2 noselect"><i class="bi bi-stoplights"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2">
    <div class="mb-1 col noselect" id="option"></div>
</div>

<table class="table border table-hover rounded-1">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th style="width:50px;" scope="col">Aperçu</th>
            <th scope="col">Sujet</th>
            <th scope="col">Créé le</th>
            <th colspan="2" scope="col">Actions</th>
            <th style="width:135px;" scope="col">Voir les articles</th>
        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>

<form name="form_status" method="post" action="/publishes/status">
    <input type="hidden" name="id_publication">
    <input type="hidden" name="status">
</form>

<form name="form_preview" method="post" action="/article/preview">
    <input type="hidden" name="id_article">
</form>

<div class="pagination ">
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
    let states = document.getElementsByClassName("modifState");


    getStoragePage(localStorage.page_publication);

    function onDelete(id, action = "/publishes/delete") {
        document.form_delete.method = "POST";
        document.form_delete.id_publication.value = id;
        document.form_delete.action = action;
        modalDelete.show();
        return false;
    }

    function onDeleteArticle(id, action = "/article/delete") {
        document.form_delete.method = "POST";
        document.form_delete.id_article.value = id;
        document.form_delete.action = action;
        modalDelete.show();
        return false;
    }

    function onPreviewArticle(id) {
        document.form_preview.method = "POST";
        document.form_preview.id_article.value = id;
        document.form_preview.action = "/article/preview";
        document.form_preview.submit();
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


    option.append(OptionPagination());


    function DisplayNone() {

    }

    loadData("<?= $dashboard_publication_json ?>", "publications", localStorage.page_publication);

    function Row(parent, data) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        let td2 = document.createElement("td");
        let td3 = document.createElement("td");
        let td4 = document.createElement("td");
        let td5 = document.createElement("td");
        let td6 = document.createElement("td");
        let nextTr = null;
        let a = document.createElement("a");
        a.innerHTML = "<i class='bi bi-eye'>";
        //a.classList.add("btn");
        a.addEventListener("click", () => {
            form_preview.action = "/publishes/preview";
            form_preview.id_article.value = data.id_article;
            form_preview.submit();
        });
        td1.append(a);

        td2.innerText = data.subject;
        td3.innerText = dateTimeFormat(data.datetime);
        td4.innerHTML = `<a role="button" onclick="onDelete(${data.id_publication})"><i class='bi bi-trash'></a>`
        //td5.innerHTML = `<a role="button" onclick="onDelete(${data.id_publication})"><i class='bi bi-trash'></a>`;
        let dropstate = new DropState(data.id_publication);
        dropstate.setState(data.status);
        dropstate.addEventListener("state", (e) => {
            if (e.detail) {
                let id = parseInt(e.detail.identifiant);
                let status = parseInt(e.detail.value);
                form_status.id_publication.value = id;
                form_status.status.value = status;
                form_status.submit();
                return true;
            }
        });
        td5.append(dropstate);

        if (data.article.length > 0) {
            td6.innerHTML = `<a role="button" class="btn btn-primary bi-plus btn-plus" onclick="expand(this)"> </a>`;
            //
            nextTr = document.createElement("tr");
            nextTr.classList = "collapse";
            let nextCol = document.createElement("td");
            nextCol.setAttribute("colspan", "6");
            //
            let subTable = document.createElement("table");
            subTable.classList = "table border table-hover rounded-1";
            // subTable.setAttribute("id", `colapse${i}`)
            let subHead = document.createElement("thead");
            let subTH = document.createElement("tr");
            let Col1 = document.createElement("td");
            let Col2 = document.createElement("td");
            let Col3 = document.createElement("td");
            let Col4 = document.createElement("td");
            Col1.style = "width:40px";
            Col1.innerText = "Aperçu";
            Col2.innerText = "Sujet";
            Col3.innerText = "Créé le";
            Col4.innerText = "Actions";
            subHead.append(subTH);
            subHead.classList = "table-secondary";
            subTH.append(Col1);
            subTH.append(Col2);
            subTH.append(Col3);
            subTH.append(Col4);
            //
            let subBody = document.createElement("tbody");
            //
            for (let i = 0; i < data.article.length; i++) {
                Row2(subBody, data.article[i]);
            }
            //
            nextTr.append(nextCol);
            nextCol.append(subTable);
            subTable.append(subHead);
            subTable.append(subBody);
        }
        td5.append(dropstate);
        parent.append(tr);
        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);
        tr.append(td5);
        tr.append(td6);
        //
        if (nextTr) {
            tbody.append(nextTr);
        }
    }

    function Row2(parent, data) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        let td2 = document.createElement("td");
        let td3 = document.createElement("td");
        let td4 = document.createElement("td");
        //
        let a = document.createElement("a");
        a.innerHTML = "<i class='bi bi-eye'>";
        //a.classList.add("btn");
        a.addEventListener("click", () => {
            form_preview.action = "/article/preview";
            form_preview.id_article.value = data.id_article;
            form_preview.submit();
        });
        //
        let a2 = document.createElement("a");
        a2.innerHTML = "<i class='bi bi-trash'>";
        // a2.classList.add("btn");
        a2.addEventListener("click", () => {
            onDeleteArticle(data.id_article);
        });
        //
        td2.innerText = data.subject;
        td3.innerText = dateTimeFormat(data.datetime);
        parent.append(tr);
        tr.append(td1);
        td1.append(a);
        td4.append(a2);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);
        return tr;
    }

    tbody.addEventListener("page", (e) => {
        localStorage.page_publication = e.detail.current;
    });

    ModalTheme(<?= session()->type ?>);

   
</script>

<?= $this->endSection() ?>