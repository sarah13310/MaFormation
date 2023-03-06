<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<div>
    <div class="d-flex w-75">
        <h1 class="col mb-2 noselect"><i class="bi bi-grid"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2 w-75">
    <div class="mb-1 col noselect " id="option"></div>
</div>

<table class="table noselect border w-75">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th style="width:80px" scope="col">Aperçu</th>
            <th style="width:280px" scope="col">Sujet</th>
            <th scope="col">Créé le</th>
            <th scope="col">Voir les articles</th>
        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>
<form name="form_preview" action="/publishes/preview" method="post">
    <input type="hidden" name="id_publication">
</form>
<form name="form_preview2" action="/article/preview" method="post">
    <input type="hidden" name="id_article">
</form>
<div class="pagination w-75">
    <ul class=""></ul>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/date.js"></script>
<script src="<?= base_url() ?>/js/paginate2.js"></script>
<script>

    getStoragePage(localStorage.page_article);
    
    option.append(OptionPagination());

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

    loadData('<?= $publishe_json ?>', "publications", localStorage.page_publication);

    function Row(parent, data, i) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        let a = document.createElement("a");
        let nextTr = null;

        a.innerHTML = "<i class='bi bi-eye'>";
        a.classList.add("btn");
        a.addEventListener("click", () => {
            form_preview.id_publication.value = data.id_publication;
            form_preview.submit();
        });
        let td2 = document.createElement("td");
        td2.innerText = data.subject;
        let td3 = document.createElement("td");
        td3.innerText = dateTimeFormat(data.datetime);
        let td4 = document.createElement("td");
        td4.style="text-align:center";
        
        nextTr = null;
        if (data.article.length > 0) {
            let button = document.createElement("button");
            button.classList = "btn btn-primary bi-plus btn-plus";
            button.setAttribute("type", 'button');
            button.setAttribute("data-bs-toggle", 'collapse');
            button.setAttribute("data-bs-target", `#collapse${i}`);
            button.setAttribute("onclick", 'expand(this)');
            td4.append(button);
            //
            nextTr = document.createElement("tr");
            nextTr.classList = "collapse";
            let nextCol = document.createElement("td");
            nextCol.setAttribute("colspan", "4");
            //
            let subTable = document.createElement("table");
            subTable.classList = "table border";
            subTable.setAttribute("id", `colapse${i}`)
            let subHead = document.createElement("thead");
            let subTH = document.createElement("tr");
            let Col1 = document.createElement("td");
            let Col2 = document.createElement("td");
            let Col3 = document.createElement("td");
            Col1.innerText = "Aperçu";
            Col2.innerText = "Sujet";
            Col3.innerText = "Créé le ";
            subHead.append(subTH);
            subHead.classList = "table-secondary";
            subTH.append(Col1);
            subTH.append(Col2);
            subTH.append(Col3);
            //
            let subBody = document.createElement("tbody");
            //
            for (let i = 0; i < data.article.length; i++) {
                Row2(subBody, data.article[i]);
            }
            //subBody.append(subTR);
            nextTr.append(nextCol);
            nextCol.append(subTable);
            subTable.append(subHead);
            subTable.append(subBody);
        }
        tbody.append(tr);
        tr.append(td1);
        td1.append(a);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);
        if (nextTr !== null) {
            tbody.append(nextTr);
        }
    }

    function Row2(parent, data) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        let a = document.createElement("a");
        a.innerHTML = "<i class='bi bi-eye'>";
        a.classList.add("btn");
        a.addEventListener("click", () => {
            form_preview2.id_article.value = data.id_article;
            form_preview2.submit();
        });
        let td2 = document.createElement("td");
        td2.innerText = data.subject;
        let td3 = document.createElement("td");
        td3.innerText = dateTimeFormat(data.datetime);
        //let td4 = document.createElement("td");
        parent.append(tr);
        tr.append(td1);
        td1.append(a);
        tr.append(td2);
        tr.append(td3);
        //tr.append(td4);
        return tr;
    }

    tbody.addEventListener("page", (e) => {
        localStorage.page_publication=e.detail.current;
    });
</script>
<?= $this->endSection() ?>