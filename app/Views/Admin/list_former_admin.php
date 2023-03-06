<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<div>
    <div class="d-flex">
        <h1 class="col mb-2 noselect"><i class="bi bi-mortarboard"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2 ">
    <div class="mb-1 col noselect " id="option"></div>
</div>
<table class="table noselect border rounded-1">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Adresse</th>
            <th scope="col">Ville</th>
            <th scope="col">CP</th>
            <th scope="col">Mail</th>
            <th scope="col">Téléphone</th>
            <th style="height:40px;width:60px;" scope="col"></th>
        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>
<div class="pagination">
    <ul></ul>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/paginate2.js"></script>
<script>
    getStoragePage(localStorage.page_former);

    option.append(OptionPagination());

    function DisplayNone() {
        let rows = 6;
        if (buffer.length == 0) {
            let tr = document.createElement("tr");
            tr.innerHTML = `<td colspan=${rows}><img src='<?= constant("NO_ITEMS") ?>'></td>`;
            tr.style = "height:250px;text-align:center";
            tbody.append(tr);
            tbody.innerHTML += "<td class='h4 text-muted' colspan=4 style='border-top-style: hidden;text-align:center'>Aucun élément</td>";
            pagination.remove();
        }
    }

    loadData('<?= $former_json ?>', "formateurs", localStorage.page_former);

    function Row(parent, data, i) {
        let tr = document.createElement("tr");
        let nextTr = null;
        let td1 = document.createElement("td");
        td1.innerText = data.name + " " + data.firstname;
        let td2 = document.createElement("td");
        td2.innerText = data.address;

        let td3 = document.createElement("td");
        td3.innerText = data.city;

        let td4 = document.createElement("td");
        td4.innerText = data.cp;

        let td5 = document.createElement("td");
        td5.innerText = data.mail;

        let td6 = document.createElement("td");
        td6.innerText = data.phone;

        let td7 = document.createElement("td");
        nextTr = null;
        if (data.skills.length > 0) {
            let button = document.createElement("button");
            button.classList = "btn btn-primary bi-plus btn-plus";
            button.setAttribute("type", 'button');
            button.setAttribute("data-bs-toggle", 'collapse');
            button.setAttribute("data-bs-target", `#collapse${i}`);
            button.setAttribute("onclick", 'expand(this)');
            td7.append(button);
            //
            nextTr = document.createElement("tr");
            nextTr.classList = "collapse";
            let nextCol = document.createElement("td");
            nextCol.setAttribute("colspan", "7");
            //
            let subTable = document.createElement("table");
            subTable.classList = "table border rounded-1";
            subTable.setAttribute("id", `colapse${i}`)
            let subHead = document.createElement("thead");
            let subTH = document.createElement("tr");
            let Col1 = document.createElement("td");
            let Col2 = document.createElement("td");
            let Col3 = document.createElement("td");
            let Col4 = document.createElement("td");
            let Col5 = document.createElement("td");
            Col1.innerText = "Diplôme";
            Col2.innerText = "Organisme";
            Col3.innerText = "Adresse";
            Col4.innerText = "CP";
            Col5.innerText = "Ville";
            subHead.append(subTH);
            subHead.classList = "table-secondary";
            subTH.append(Col1);
            subTH.append(Col2);
            subTH.append(Col3);
            subTH.append(Col4);
            subTH.append(Col5);
            //
            let subBody = document.createElement("tbody");
            for (let i = 0; i < data.skills.length; i++) {
                Row2(subBody, data.skills[i]);
            }
            nextTr.append(nextCol);
            nextCol.append(subTable);
            subTable.append(subHead);
            subTable.append(subBody);
        }
        tbody.append(tr);
        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);
        tr.append(td5);
        tr.append(td6);
        tr.append(td7);

        if (nextTr !== null) {
            tbody.append(nextTr);
        }
    }

    function Row2(parent, data) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        td1.innerText = data.name;
        let td2 = document.createElement("td");
        td2.innerText = data.organism;
        let td3 = document.createElement("td");
        td3.innerText = data.address;
        let td4 = document.createElement("td");
        td4.innerText = data.cp;
        let td5 = document.createElement("td");
        td5.innerText = data.city;
        parent.append(tr);
        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);
        tr.append(td5);
        return tr;
    }

    tbody.addEventListener("page", (e) => {
        localStorage.page_former=e.detail.current;
    });
</script>
<?= $this->endSection() ?>