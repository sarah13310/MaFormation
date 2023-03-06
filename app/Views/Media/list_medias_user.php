<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<div class="noselect">
    <div class="d-flex ">
        <h1 class="col mb-2 noselect"><i class="bi bi-grid"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2">
    <div class="mb-1 col noselect " id="option"></div>
</div>
<div class="row w-50">
    <div class="col">
        <select name="authors" id="authors">
            <option selected="selected">Tous</option>
            <?php foreach ($authors as $author) : ?>
                <option value="<?= $author['author'] ?>"><?= $author['author'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
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
</div>
<table class="table border noselect" id="mytable">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th scope="col">Image</th>
            <th scope="col">Nom</th>
            <th scope="col">Auteur</th>

        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>
<div class="pagination">
    <ul class=""></ul>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() . '/js/paginate2.js' ?>"></script>
<script>
    /** Gestion des filtres */
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

    function FillRow() {
        for (let i = 0; i < rows.length; i++) {
            rowinfo = rows[i];
            Row(tbody, rowinfo);
        }
    }

    function selectRow(rowAuthor, rowTag) {
        clearAllRow();
        rows = buffer;

        if (rowAuthor !== "Tous") {
            rows = rows.filter(item => {
                return (item.author === rowAuthor);
            });
        }

        if (rowTag !== "Tous") {
            rows = rows.filter(item => {
                return (item.tag[0].name === rowTag);
            });
        }
        FillRow();
    }

    function selectRowByAz() {
        clearAllRow();
        rows = buffer;
        rows.sort(function(a, b) {
            if (a.name < b.name) {
                return -1;
            }
            if (a.name > b.name) {
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
            if (a.name < b.name) {
                return 1;
            }
            if (a.name > b.name) {
                return -1;
            }
            return 0;
        });
        FillRow();
    }

    let select_authors = document.getElementById('authors');

    let select_tag = document.getElementById('tag');

    let sel_author = "Tous";

    let sel_tag = "Tous";

    select_authors.addEventListener('change', (event) => {
        sel_author = select_authors[select_authors.selectedIndex].value;
        selectRow(sel_author, sel_tag);

    })

    select_tag.addEventListener('change', (event) => {
        sel_tag = select_tag[select_tag.selectedIndex].value;
        selectRow(sel_author, sel_tag);

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

    /** Gestion de la pagination */
    getStoragePage(localStorage.page_media);
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

        tr.innerHTML += `<td>${data.name}</td> <td>${data.author}</td>`
        tbody.append(tr);
        loadImages();
    }

    loadData('<?= $media_json ?>', "médias", localStorage.page_media);
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
    });
</script>

<?= $this->endSection() ?>