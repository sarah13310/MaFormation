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

<div class="row noselect">
    <div class="w-90 table-responsive">
        <table class="table noselect border ">
            <thead class="<?= $headerColor ?>">
                <tr id="trheader">
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Localité</th>
                    <th scope="col">Pays</th>
                    <th class="<?= $showDetails ?>" scope="col"></th>
                </tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
        <div class="pagination">
            <ul class=""></ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="<?= base_url() . '/js/paginate2.js' ?>"></script>
<script>
    const trheader = document.getElementById("trheader");

    let company = <?= $company ?>;
    //
    option.append(OptionPagination());

    
    loadData('<?= $user_json ?>',"particuliers");
   
    function DisplayNone() {
        const trheader = document.getElementById("trheader");
        let rows = trheader.children.length;
        if (buffer.length == 0) {
            let tr = document.createElement("tr");
            tr.innerHTML = `<td colspan=${rows}><img src='<?= constant("NO_ITEMS") ?>'></td>`;
            tr.style = "height:250px;text-align:center";
            tbody.append(tr);
            tbody.innerHTML += "<td class='h4 text-muted' colspan=4 style='border-top-style: hidden;text-align:center'>Aucun élément</td>";
            pagination.remove();
        }
    }

    function Row(parent, data, i) {
        let nextTr = null;
        let tr = document.createElement("tr")
        tr.innerHTML = `<td>${data.user.name}</td> <td>${data.user.firstname}</td>`
        tr.innerHTML += `<td>${data.user.address}&nbsp;${data.user.cp}</td> <td>${data.user.city}</td><td>${data.user.country}</td>`;
        // si on est dans le profil entreprise alors cette condition est vérifiée 
        // on récupère les informations propres à l'entreprise
        if ((data.company.length === 0) && (company === true)) {
            tr.innerHTML += "<td></td>";
        }

        if (data.company.length > 0 && company === true) {
            tr.innerHTML += "<td> <a class='btn btn-primary bi-plus'role='button' onclick='expand(this)'></i></a> </td>";
            nextTr = document.createElement("tr");
            nextTr.classList = "collapse";
            let colspan = document.createElement("td");
            colspan.setAttribute("colspan", "4");
            let table = document.createElement("table");
            table.classList = "table"
            table.setAttribute("border", "");
            table.innerHTML += "<thead class='table-primary'><tr><th>Companie</th><th>Adresse</th><th>Ville</th></tr></thead>";
            table.innerHTML += "<tbody>";
            //
            for (let i = 0; i < data.company.length; i++) {
                table.innerHTML += `<tr><td>${data.company[i].name}</td><td>${data.company[i].address}&nbsp;${data.company[i].cp}</td><td>${data.company[i].city}</td></tr>`;
            }
            table.innerHTML += "</tbody>";
            colspan.append(table);
            nextTr.append(colspan);
        }

        tbody.append(tr);
        if (nextTr !== null) {
            tbody.append(nextTr);
        }
    }
    
    ApplyTheme(<?=session()->type?>);
    
</script>
<?= $this->endSection() ?>