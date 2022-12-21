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

<h1 class="noselect ms-3"><?= $title ?></h1>
<section class="Content">
    <link rel="stylesheet" href="<?= $base ?>/css/default.min.css" />
    <script src="<?= $base ?>/js/sceditor.min.js"></script>
    <script src="<?= $base ?>/js/languages/fr.js"></script>
    <script src="<?= $base ?>/js/bbcode.min.js"></script>
    <script src="<?= $base ?>/js/monocons.min.js"></script>
    <div class="row">
        <div class="col-12 col-md-6">
            <form id="form_training" action="" method="POST">
                <input type="hidden" id="action" name="action" value="create">
                <input type="hidden" id="data" name="data[]">
                <div class="row justify-content-between">
                    <div class="noselect col-12 col-md-5">
                        <select id="type" name="type" class="form-select mb-3">
                            <?php foreach ($types as $type) : ?>
                                <option value="<?= $type["id"] ?>"><?= $type["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class=" noselect col-12 col-md-5">
                        <input id="number" type="number" max="12" min="1">
                    </div>
                    <div class="col-12 col-md-2">
                        <a onclick="onResetPage()" class="btn btn-primary"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
                <div class="noselect form-group row">
                    <label for="select" class="col-2 col-form-label">Catégorie</label>
                    <div class="col-10">
                        <select id="select" name="select" class="form-select">
                            <?php foreach ($options as $option) : ?>
                                <option value="<?= $option["id_category"] ?>"><?= $option["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="yesselect fullwidth editor mt-2">
                    <textarea id="content" name="description" style="width:100%; height:400px"></textarea>
                </div>
                <div class="row fullwidth  mt-2">
                    <div class="row align-items-center">
                        <div id="modify" class="noselect hidden col-sm-12 col-md-3"><a onclick="modifyTableau()" class="noselect btn btn-outline-primary">Modifier</a></div>
                        <div id="add" class="noselect col-sm-12 col-md-3 "><a onclick="addTableau()" class="noselect btn btn-outline-primary">Ajouter</a></div>
                        <div class="col-sm-12 col-md-3 "><button type="submit" class="noselect btn btn-primary">Sauver</button></div>
                        <div class="col-sm-12 col-md-6 ">
                            <input type="checkbox" id="publish" name="publish" checked>
                            <label class="noselect" for="publish">Publier</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
            <table class="noselect table table-success table-striped table-bordered table-hover" id="table">
                <thead>
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
    let data = document.getElementById('data');
    let btnModify = document.getElementById("modify");
    let btnAdd = document.getElementById("add");
    let msg_delete = document.getElementById("msg_delete");
    //
    let number = document.getElementById("number");
    //
    let str = "";
    let page_num = 0,
        annexe_num = 0;
    let area = "";
    let mode = "new",
        modified = false;


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
            }
        } else if (index == 3) {
            type.value = 4;
            
        } else if (index == 4) {
            annexe_num++;
            if (annexe_num < max_annexe) {
                libelle = libelle + " " + annexe_num.toString();
            } else {
                //on verra plus tard :)
            }
        }

        addRow(libelle, select[select.selectedIndex].text, area);
        select.value = 1;

        AddRowSelect();
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
        //td3.innerHTML = "<button data-bs-toggle='modal' data-bs-target='#modalDelete' ><i class='bi bi-trash3'></i></button>";
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

    function save() {
        let rows = table.rows;
        for (let i = 1; i < rows.length; i++) {
            let col = rows[i].cells;
            data.push(col[0].innerHTML);
            data.push(col[1].innerHTML);
            data.push(col[3].innerHTML);
        }
    }

    form_training.onsubmit = () => {
        save();
        return false;
    }

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

    function AddRowSelect() {
        let rows = table.getElementsByTagName("tr");
        for (let i = 1; i < rows.length; i++) {
            let rowCurrent = rows[i];
            rowCurrent.onclick = () => {
                rowSelected = rowCurrent; // on récupère en global le row sélectionné
                sceditor.instance(content).val(rowCurrent.cells[3].innerHTML);
                btnAdd.classList.add("hidden");
                btnModify.classList.remove("hidden");
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

    let chapter;
    let rowSelected;

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