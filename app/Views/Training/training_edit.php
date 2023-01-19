<?php $base = base_url(); ?>
<?= $this->extend('layouts/profil') ?>
<?= $this->section('header') ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= $base ?>/css/stylemain.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700,700i|Source+Code+Pro:400,700&display=swap">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="modalDelete" class="modal" tabindex="-1">
    <form action="/former/training/edit" method="POST">
        <input type="hidden" id="action" name="action" value="delete">
        <input type="hidden" id="id_page" name="id_page">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="msg_delete">Voulez-vous supprimer cette page?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-primary">Oui</button>
                </div>
            </div>
        </div>
    </form>
</div>

<h1 class="ms-3"><?= $title ?></h1>
<hr class="mb-2 mt-2">
<section class="Content ">
    <link rel="stylesheet" href="<?= $base ?>/css/default.min.css" />
    <div class="row">
        <div class="col-12 col-md-6">
            <form id="form_training" onsubmit="return save()">
                <input type="hidden" id="action" name="action" value="create">
                <input type="hidden" id="data" name="data[]">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-5">
                        <select id="type" name="type" class="form-select mb-3">
                            <?php foreach ($types as $type) : ?>
                                <option value="<?= $type["id"] ?>"><?= $type["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-5">
                        <input id="number" type="number" max="12" min="1">
                    </div>
                    <div class="col-12 col-md-2">
                        <a onclick="onResetPage()" class="btn btn-primary"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="select" class="col-2 col-form-label">Catégorie</label>
                    <div class="col-10">
                        <select id="select" name="select" class="form-select">
                            <?php foreach ($options as $option) : ?>
                                <option value="<?= $option["id_category"] ?>"><?= $option["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-12  form-floating mb-3">
                    <input class="form-control" id="image_url" name="iamge_url" type="text" placeholder="Image de la page" value="<?= base_url() . "/assets/article.svg" ?>" />
                    <label for="image_url">Image de la page</label>
                </div>
                <div class=" fullwidth editor mt-2">
                    <textarea id="content" class="" name="description" style="width:100%; height:400px">
                </textarea>
                </div>
                <div class="row fullwidth mt-2">
                    <div class="row align-items-center">
                        <div id="modify" class=" hidden col-sm-12 col-md-3"><a onclick="modifyTableau()" class=" btn btn-outline-primary">Modifier</a></div>
                        <div id="add" class=" col-sm-12 col-md-3 "><a onclick="addTableau()" class=" btn btn-outline-primary">Ajouter</a></div>
                        <div class="col-sm-12 col-md-3 "><button type="button" class=" btn btn-primary">Sauver</button></div>
                        <div class="col-sm-12 col-md-6 ">
                            <input type="checkbox" id="publish" name="publish" checked>
                            <label class="" for="publish">Publier</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="vr"></div>
        <div class="col-12 col-md-6">
            <div class="row mb-2">
                <div class="col-12 col-md-2">
                    <a onclick="onNew()" class="btn btn-primary"><i class="bi bi-plus-circle"></i></i></a>
                </div>
            </div>
            <div class="row mb-1">
                <div id="lblTitle" class="col-12 col-md-5"><?= session()->title ?>
                </div>
                <div id="lblType" class="col-12 col-md-6">Chapitre...
                </div>
            </div>
            <table class=" table table-bordered table-hover" id="table">
                <thead class=" table <?= $headerColor ?>">
                    <tr>
                        <th scope="col">Chapitre</th>
                        <th scope="col">Catégorie</th>
                        <th scope="col">Actions</th>
                        <th class="hidden">Code</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= $base ?>/js/sceditor.min.js"></script>
<script src="<?= $base ?>/js/languages/fr.js"></script>
<script src="<?= $base ?>/js/bbcode.min.js"></script>
<script src="<?= $base ?>/js/monocons.min.js"></script>

<script>
    const modalDelete = new bootstrap.Modal('#modalDelete');
    const formDelete = document.getElementById('modalDelete');
    let action = document.getElementById('action');
    let current_page = document.getElementById('id_page');
    //
    let table = document.getElementById('table');
    let title = document.getElementById('title');
    let type = document.getElementById('type');
    //
    let lblTitle = document.getElementById('lblTitle');
    let lblType = document.getElementById('lblType');
    //
    let select = document.getElementById('select');
    let content = document.getElementById('content');
    //let dataI = document.getElementById('data');
   // let pages = [];
    let btnModify = document.getElementById("modify");
    let btnAdd = document.getElementById("add");
    let msg_delete = document.getElementById("msg_delete");
    //
    let number = document.getElementById("number");
    //
    let str = "";
    let page_num = 0
    let annexe_num = 0;
    let area = "";
    let mode = "new";
    let modified = false;
    let chapter;
    let rowSelected;

   /* class Page {
        constructor(name, content, image_url = "") {
            this.name = name;
            this.content = content;
        }
    }*/

    function initEditor() {
        sceditor.create(content, {
            format: 'bbcode',
            width: '100%',
            height: '330px',
            icons: 'monocons',
            style: '<?= $base ?>/css/default.min.css',
            locale: 'fr-FR'
        });
    }
    // Gestion des pages avec numérotation intégrée
    function addTableau() {

        area = sceditor.instance(content).val();
        let libelle = type[type.selectedIndex].text;
        let index = type[type.selectedIndex].value;
        let max_page = parseInt(localStorage.page_num);
        let max_annexe = parseInt(localStorage.annexe_num);

        if (index == 1) {
            type.value = 2;
        } else if (index == 2) {
            page_num++;
            if (page_num <= max_page) {
                libelle = libelle + " " + page_num.toString();
            } else {
                type.value = 3;
                libelle = "Conclusion";
                type.selectedIndex = 3;
            }
        } else if (index == 3) {
            type.value = 4;
            type.selectedIndex = 4;

        } else if (index == 4) {
            annexe_num++;
            if (annexe_num <= max_annexe) {
                libelle = libelle + " " + annexe_num.toString();
            } else {
                type.selectedIndex = 1;
            }
        }
        addRow(libelle, select[select.selectedIndex].text, area);
        select.value = 1;
        ClickModifiy();
        AddBtnDelete();
        modified = false;
        sceditor.instance(content).val("");
    }

    function modifyTableau() {
        area = sceditor.instance(content).val();
        if (rowSelected != null) {
            rowSelected.cells[3].innerHTML = area;
        }
        onNew();
        modified = false;
    }

    let tbody = document.createElement('tbody');

    function addRow(td_page, td_category, td_content) {

        let tr = document.createElement('tr');
        //
        let td1 = document.createElement('td'); // Page
        let td2 = document.createElement('td');
        let td3 = document.createElement('td');
        let btn = document.createElement('button');
        let td4 = document.createElement('td');
        td4.classList.add('hidden');
        //
        let text1 = document.createTextNode(td_page);
        let text2 = document.createTextNode(td_category);
        let text3 = document.createTextNode("");
        let text4 = document.createTextNode(td_content);
        //
        td1.appendChild(text1);
        td2.appendChild(text2);
        //
        btn.innerHTML = "<i class='bi bi-trash3'>";
        td3.appendChild(btn);
        btn.classList.add("btn");
        td4.appendChild(text4);
        //
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        //
        tbody.appendChild(tr);
        table.appendChild(tbody);
        modified = false;
    }

    // Sauvegarder des données
    // function save() {
    //     let rows = table.rows;
    //     for (let i = 1; i < rows.length; i++) {
    //         let col = rows[i].cells;
    //         let page= new Page(col[0].innerHTML,col[1].innerHTML,col[2].innerHTML );
    //         pages.push(page);
           
    //     }
    //     return false;
    // }

    formDelete.onsubmit = () => {
        if (rowSelected != null) {
            rowSelected.remove();
        }
        modalDelete.hide();
        return false;
    }

    function onResetPage() {
        type.value = 1;
        number.value = "";
        var rowCount = table.rows.length;
        for (var i = 1; i < rowCount; i++) {
            table.deleteRow(rowCount - i);
        }
        modified = false;
    }

    type.addEventListener('click', () => {
        let value = event.target.value;
        switch (value) {
            case "1": // Introduction
            case "3": // Introduction
                number.value = "";
                break;
            case "2": // Chapitre
                number.value = localStorage.page_num;
                break;
            case "4": // Annexe
                number.value = localStorage.annexe_num;
                break;
        }
    });

    // gestion des ellipses en js
    String.prototype.trunc =
        function(n) {
            return this.substr(0, n - 1) + (this.length > n ? '...' : '');
        };
        
        number.onchange = () => {
        if (type.value == 2) {
            localStorage.page_num = number.value;
        }
        if (type.value == 4) {
            localStorage.annexe_num = number.value;
        }
    }
    //
    function ClickModifiy() {
        let rows = table.getElementsByTagName("tr");
        for (let i = 1; i < rows.length; i++) {
            let rowCurrent = rows[i];
            rowCurrent.onclick = () => {
                rowSelected = rowCurrent; // on récupère en global le row sélectionné
                sceditor.instance(content).val(rowCurrent.cells[3].innerHTML);
                btnAdd.classList.add("hidden");
                btnModify.classList.remove("hidden");// on affiche le bouton modifier
                lblType.innerHTML = rowCurrent.cells[0].innerHTML
            }
        }
    }

    function AddBtnDelete() {
        let rows = table.getElementsByTagName("tr");
        for (let i = 1; i < rows.length; i++) {
            let rowCurrent = rows[i];
            rowCurrent.cells[2].onclick = () => {
                showModalDelete(rowCurrent);
            }
        }
    }
    
    function showModalDelete(row) {
        rowSelected = row;
        chapter = row.cells[0].innerHTML;
        msg_delete.innerHTML = "Voulez-vous supprimer " + chapter + "?";
        modalDelete.show();
    }

    function onNew() {
        sceditor.instance(content).val("");
        sceditor.instance(content).focus();
        btnAdd.classList.remove("hidden");
        btnModify.classList.add("hidden");
    }

    initEditor();
    sceditor.instance(content).bind('keypress', function(e) {
        modified = true;
    });
    lblTitle.value = "<?= session()->title; ?>";
</script>
<?= $this->endSection() ?>