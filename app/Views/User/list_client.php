<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>

<div class="noselect">
    <div class="d-flex w-75">
        <h1 class="col mb-2 noselect"><i class="bi bi-grid"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2 w-75">
    <div class="mb-1 col noselect " id="option"></div>
</div>


<div class="row noselect">
    <div class="w-90 table-responsive">
        <table class="table noselect border ">
            <thead class="<?= $headerColor ?>">
                <tr>
                    <th class="<?= $showDetails ?>" scope="col"></th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Localité</th>
                    <th scope="col">Pays</th>
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

<script>
    let tbody = document.getElementById("tbody");
    let buffer = null;
    //
    let step_page = 1;
    let current_page = 1;
    let items_per_page = 10;
    const element = document.querySelector(".pagination ul"); //avec ul
    let option = document.getElementById('option');
    let table = document.getElementById('table');
    let items_display = null;
    let totalPages = 20;

    option.append(OptionPagination());

    function NbTitle(count, title = "particuliers") {
        if (buffer !== null) {
            let h6 = document.getElementsByTagName("h6");
            if (count == 0) {
                h6[0].outerText = "";
            } else {
                h6[0].innerHTML = `<h6><i>${count} ${title}</i></h6>`;
            }
        }
    }

    function OptionPagination() {
        let select = document.createElement("select");
        select.classList = "pagination-select";
        let step = 0;
        for (let i = 0; i < 4; i++) {
            let option = document.createElement("option");
            option.value = 10 + step;
            let selected = (items_per_page === option.value) ? "selected" : "";
            if (selected)
                option.setAttribute(selected, "");
            option.innerText = "Par " + (10 + step) + " articles";
            select.append(option);
            step += 5;
        }
        select.addEventListener("change", (ev) => {
            let sel = ev.target[ev.target.selectedIndex];
            items_per_page = parseInt(sel.value);
            totalPages = Math.ceil(buffer.length / items_per_page);
            RefreshPage();
            element.innerHTML = createPagination(totalPages, 1);
        });
        return select;
    }

    function ApplyTheme() {
        const buttons = document.querySelectorAll(".btn-primary");
        buttons.forEach((button) => {
            button.classList.replace("btn-primary", "<?= $buttonColor ?>");
        })
    }

    function RecalcPage(items, items_per_page = 10) {
        let start = items_per_page * (current_page - 1);
        let end = start + items_per_page;
        items_display = items.slice(start, end);
    }

    function RefreshPage() {
        ApplyTheme();
        RecalcPage(buffer, items_per_page);
        while (tbody.lastElementChild) {
            tbody.removeChild(tbody.lastElementChild);
        }
        for (let i = 0; i < items_display.length; i++) {
            Row(tbody, items_display[i], i + 1);
        }
        ApplyTheme();
    }

    fetch('<?= $user_json ?>')
        .then(res => res.json())
        .then(data => {
            buffer = data;
            RefreshPage();
            totalPages = Math.ceil(buffer.length / items_per_page);;
            element.innerHTML = createPagination(totalPages, 1);
            NbTitle(buffer.length, "particuliers");
        });

    function Row(parent, data, i) {
        let nextTr = null;
        let tr = document.createElement("tr")
        tr.innerHTML = `<td>${data.user.name}</td> <td>${data.user.firstname}</td>`
        tr.innerHTML += `<td>${data.user.address}&nbsp;${data.user.cp}</td> <td>${data.user.city}</td><td>${data.user.country}</td>`;
        // si on est dans le profil entreprise alors cette condition est vérifiée 
        // on récupère les informations propres à l'entreprise
        if (data.company.length > 0) {
            /*tr.innerHTML += `<td><button class='btn btn-primary bi-plus' `;
            tr.innerHTML += ` type='button' data-bs-toggle='collapse' `;
            tr.innerHTML += `data-bs-target='#collapse${i}' onclick='expand(this)' ></button></td>`;*/
            //
            tr.innerHTML+=`<td></td>`;
            nextTr = document.createElement("tr");
            nextTr.classList = "collapse";
            nextTr.innerHTML = `<td colspan='4'><table border id=colapse${i}> `;
            nextTr.innerHTML += `<thead class='table-secondary'><tr> <th>Companie</th> <th>Adresse</th> <th>Ville</th></thead>`;
            nextTr.innerHTML += `<tbody>`;
            //
            for (let i = 0; i < data.company.length; i++) {
                nextTr.innerHTML += `<tr><td>${data.company[i].name}</td><td>${data.company[i].address}&nbsp;${data.company[i].cp}</td><td>${data.company[i].city}</td></tr>`;
            }
            nextTr.innerHTML += `</tbody>`;
        }
        else {
            tr.innerHTML+=`<td></td>`;
        }
        tbody.append(tr);
        if (nextTr !== null) {
            tbody.append(nextTr);
        }
    }


    function createPagination(totalPages, page = 10) {
        let liTag = '';
        let active;
        let beforePage = page - 1;
        let afterPage = page + 1;
        current_page = page;
        RefreshPage();
        if (page > 1) { //show the next button if the page value is greater than 1
            liTag += `<li class="me-2 btn prev" onclick="createPagination(totalPages, ${page - 1})"><span><i class="'bi bi-chevron-left"></i> Préc</span></li>`;
        }

        if (page > 2) { //if page value is less than 2 then add 1 after the previous button
            liTag += `<li class="first numb" onclick="createPagination(totalPages, 1)"><span>1</span></li>`;
            if (page > 3) { //if page value is greater than 3 then add this (...) after the first li or page
                liTag += `<li class="dots"><span>...</span></li>`;
            }
        }

        // how many pages or li show before the current li
        if (page == totalPages) {
            beforePage = beforePage - 2;
        } else if (page == totalPages - 1) {
            beforePage = beforePage - 1;
        }
        // how many pages or li show after the current li
        if (page == 1) {
            afterPage = afterPage + 2;
        } else if (page == 2) {
            afterPage = afterPage + 1;
        }

        for (let i = beforePage; i <= afterPage; i++) {
            if (i > totalPages) { //if i is greater than totalPage length then continue
                continue;
            }
            if (i == 0) { //si  i vaut 0 alors on additionne 1 à i 
                i = i + 1;
            }
            if (page == i) { //si page est égale à i alors on assigne active 
                active = "active";
            } else { //sinon on laisse active à vide
                active = "";
            }
            liTag += `<li class="numb ${active}" onclick="createPagination(totalPages, ${i})"><span>${i}</span></li>`;
        }

        if (page < totalPages - 1) { //si page est moins que totalPage value by -1 then show the last li or page
            if (page < totalPages - 2) { //if page value is less than totalPage value by -2 then add this (...) before the last li or page
                liTag += `<li class="dots"><span>...</span></li>`;
            }
            liTag += `<li class="last numb" onclick="createPagination(totalPages, ${totalPages})"><span>${totalPages}</span></li>`;
        }

        if (page < totalPages) { //show the next button if the page value is less than totalPage(20)
            liTag += `<li class="ms-2 btn next" onclick="createPagination(totalPages, ${page + 1})"><span>Suiv <i class="'bi bi-chevron-right"></i></span></li>`;
        }
        element.innerHTML = liTag; //add li tag inside ul tag

        return liTag; //reurn the li tag
    }

    function expand(item) {
        const tr = item.parentElement.parentElement;
        let collapse = tr.nextElementSibling.classList.toggle("collapse");
        if (collapse) {
            tr.style.borderBottom = "1px solid lightgray";
            item.classList.remove("bi-dash");
            item.classList.add("bi-plus");
        } else {
            tr.style.borderBottom = "1px solid transparent";
            item.classList.remove("bi-plus");
            item.classList.add("bi-dash");
        }
    }
</script>
<?= $this->endSection() ?>