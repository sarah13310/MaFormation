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
<div class="row w-50">
    <div class="col">
        <select name="tag" id="tag">
            <option selected="selected">Tous</option>
            <?php foreach ($tag as $t) : ?>
                <option value="<?= $t['name'] ?>"><?= $t['name'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="col">
        <select name="az" id="az">
            <option selected="selected">--</option>
            <option>A-Z</option>
            <option>Z-A</option>
        </select>
    </div>
    <div class="col" id="filterdate">
    </div>
</div>
<table id="table " class="table border w-75 noselect">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th style="width:80px" scope="col">Aperçu</th>
            <th style="width:280px" scope="col">Sujet</th>
            <th scope="col">Créé le</th>
        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>
<form name="form_preview" action="/article/preview" method="post">
    <input type="hidden" name="id_article">
</form>
<!-- <div class="w-75" id="pagination"></div> -->
<div class="pagination w-75">
    <ul class=""></ul>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/date.js"></script>
<script src="<?= base_url() ?>/js/paginate2.js"></script>
<script src="<?= base_url() ?>/js/filterdate.js"></script>
<script>
    /** gestion des filtres */
    let dateselect = document.getElementById('filterdate');
    let filterdate = new FilterDate(new Date());

    dateselect.append(filterdate);

    let d = filterdate.day;
    let m = filterdate.month;
    let y = filterdate.year;

    filterdate.addEventListener('onDate', (event) => {
        d = event.detail.jour;
        m = event.detail.mois;
        y = event.detail.annee;
        selectDate(d, m, y);
    });

    function selectDate(d, m, y) {
        clearAllRow();
        rows = buffer;
        if (rows === null)
            return;
        rows = rows.filter(item => {
            let rowdate = new Date(item.datetime).getDate();
            return (rowdate == d);
        });

        rows = rows.filter(item => {
            let rowmonth = new Date(item.datetime).getMonth();
            return (rowmonth + 1 == m);
        });

        rows = rows.filter(item => {
            let rowyear = new Date(item.datetime).getFullYear();
            return (rowyear == y);
        });

        FillRow();
    }

    function selectRowByAz() {
        clearAllRow();
        rows = buffer;

        rows.sort(function(a, b) {
            if (a.subject < b.subject) {
                return -1;
            }
            if (a.subject > b.subject) {
                return 1;
            }
            return 0;
        });
        FillRow();
    }

    function selectRowByZa() {
        clearAllRow();
        rows = buffer;

        rows.sort(function(a, b) {
            if (a.subject < b.subject) {
                return 1;
            }
            if (a.subject > b.subject) {
                return -1;
            }
            return 0;
        });
        FillRow();
    }

    function FillRow() {
        for (let i = 0; i < rows.length; i++) {
            rowinfo = rows[i];
            Row(tbody, rowinfo);
        }
    }

    function clearAllRow() {
        while (tbody.lastElementChild) {
            tbody.removeChild(tbody.lastElementChild);
        }
    }

    function showAll() {
        clearAllRow();
        rows = buffer;
        FillRow();
    }

    function selectRow(rowTag) {
        clearAllRow();
        rows = buffer;

        if (rowTag !== "Tous") {
            rows = rows.filter(item => {
                return (item.tag[0].name === rowTag);
            });
        }
        FillRow();
    }
    // Evenements des select
    let select_tag = document.getElementById('tag');
    let sel_tag = "Tous";
    //
    select_tag.addEventListener('change', (event) => {
        sel_tag = select_tag[select_tag.selectedIndex].value;

        selectRow(sel_tag);

    })

    let select_az = document.getElementById('az');
    select_az.addEventListener('change', (event) => {
        let sel = select_az[select_az.selectedIndex].value;
        if (sel === "--") {
            showAll();
        }
        if (sel === "A-Z") {
            selectRowByAz();
        } else {
            selectRowByZa();
        }
    })


    /** Gestion pagination */
    getStoragePage(localStorage.page_article);
    option.append(OptionPagination());
    loadData('<?= $article_json ?>', "articles", localStorage.page_article);

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


    function Row(parent, data) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        let a = document.createElement("a");
        a.innerHTML = "<i class='bi bi-eye'>";
        a.classList = "btn btn-plus";
        a.addEventListener("click", () => {
            form_preview.id_article.value = data.id_article;
            form_preview.submit();
        });
        let td2 = document.createElement("td");
        td2.innerText = data.subject;
        let td3 = document.createElement("td");
        td3.innerText = dateTimeFormat(data.datetime);
        tbody.append(tr);
        tr.append(td1);
        td1.append(a);
        tr.append(td2);
        tr.append(td3);
    }
    tbody.addEventListener("page", (e) => {
        localStorage.page_article = e.detail.current;
    })
</script>
<?= $this->endSection() ?>