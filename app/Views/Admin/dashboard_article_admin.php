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
                    <h5>Voulez-vous effacer cet article?</h5>
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
        <tr >
            <th scope="col">Sujet</th>            
            <th scope="col">Date</th>
            <th scope="col">Auteur</th>
            <th colspan='3' scope="col">Actions</th>
        </tr>
    </thead>
    <tbody id='tbody'></tbody>
</table>
<form name="form_status" method="post" action="/article/status">
    <input type="hidden" name="id_article">
    <input type="hidden" name="status">
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

    // if (localStorage.page_article){
    //     current_page=parseInt(localStorage.page_article);
    // }
    // else {
    //     localStorage.page_article=1;
    // }
    getStoragePage(localStorage.page_article);
    
    function onDelete(id) {
        document.form_delete.method = "POST";
        document.form_delete.id.value = id;
        document.form_delete.action = '/article/delete';
        modalDelete.show();
        return false;
    }

    function onConfirmDelete() {
        document.form_delete.submit();
    }
    
    option.append(OptionPagination());


    function DisplayNone() {

    }

    loadData("<?= $dashboard_article_json ?>", "articles", localStorage.page_article);

    function Row(parent, data) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        td1.innerText = data.subject;
        let td2 = document.createElement("td");
        td2.innerText = dateTimeFormat(data.datetime);
        let td3 = document.createElement("td");
        td3.innerText = data.user[0].name + " " + data.user[0].firstname;
        let td4 = document.createElement("td");
        let td5 = document.createElement("td");
        td4.innerHTML = `<a role="button" onclick="onDelete(${data.id_article})"><i class='bi bi-trash'></i></a>`;
        let dropstate = new DropState(data.id_article);
        dropstate.setState(data.status);
        dropstate.addEventListener("state", (e) => {
            form_status.id_article.value = e.detail.identifiant;
            form_status.status.value = e.detail.value;
            form_status.submit();
            return true;
        });
        td5.append(dropstate);
        parent.append(tr);
        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);
        tr.append(td5);
    }

    tbody.addEventListener("page",(e)=>{
        localStorage.page_article=e.detail.current;
    });
    ModalTheme(<?= session()->type ?>);
</script>
<?= $this->endSection() ?>