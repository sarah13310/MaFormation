<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>

<div>
    <div class="d-flex w-75">
        <h1 class="col mb-2 noselect"><i class="bi bi-currency-euro"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2 w-75">
    <div class="mb-1 col noselect " id="option"></div>
</div>

<div class="row">
    <div class="col">
        <table class="table w-75 table-hover border">
            <thead class="<?= $headerColor ?>">
                <tr>
                    <th class="hidden" scope="col">Id</th>
                    <th scope="col">Apperçu</th>
                    <th scope="col">Référence</th>
                    <th scope="col">Date</th>
                    <th scope="col">Prix</th>
                </tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
    </div>
    <form name="form_preview" action="/user/bill/preview" method="post">
        <input type="hidden" name="id_bill">
        <input type="hidden" name="ref_name">
    </form>
    <div class="pagination w-75">
        <ul class=""></ul>
    </div>

    <?= $this->endSection() ?>


    <?= $this->section('js') ?>
    <script src="<?= base_url() ?>/js/date.js"></script>
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

        function NbTitle(count, title = "factures") {
            if (buffer !== null) {
                let h6 = document.getElementsByTagName("h6");
                if (count == 0) {
                    h6[0].outerText = "";
                } else {
                    h6[0].innerHTML = `<h6><i>${count} ${title}</i></h6>`;
                }
            }
        }

        option.append(OptionPagination());

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

        function RecalcPage(items, items_per_page = 10) {
            let start = items_per_page * (current_page - 1);
            let end = start + items_per_page;
            items_display = items.slice(start, end);
        }

        function RefreshPage() {
            RecalcPage(buffer, items_per_page);
            while (tbody.lastElementChild) {
                tbody.removeChild(tbody.lastElementChild);
            }
            for (let i = 0; i < items_display.length; i++) {
                Row(tbody, items_display[i]);
            }
        }

        fetch("<?= $bill_json ?>")
            .then(res => res.json())
            .then(data => {
                buffer = data;
                //RefreshPage();
                totalPages = Math.ceil(buffer.length / items_per_page);;
                element.innerHTML = createPagination(totalPages, 1); // le refresh se fait dans cette fonction
                NbTitle(buffer.length);
            });

        function Row(parent, data) {
            let tr = document.createElement("tr");
            let td1 = document.createElement("td");
            let a = document.createElement("a");
            a.innerHTML = "<i class='bi bi-eye'>";
            a.classList.add("btn");
            a.addEventListener("click", () => {
                form_preview.id_bill.value = data.id_bill;
                form_preview.ref_name.value = data.ref_name;
                form_preview.submit();
            });
            //
            let td2 = document.createElement("td");
            td2.innerText = data.ref_name;
            //
            let td3 = document.createElement("td");
            td3.innerText = dateTimeFormat(data.datetime);
            //          
            let td4 = document.createElement("td");
            td4.innerText = data.price + ' €';
            //
            tbody.append(tr);
            tr.append(td1);
            td1.append(a);
            tr.append(td2);
            tr.append(td3);
            tr.append(td4);
        }


        function createPagination(totalPages, page = 10) {
            let liTag = '';
            let active;
            let beforePage = page - 1;
            let afterPage = page + 1;
            current_page = page;
            RefreshPage();
            if (totalPages == 1) {
                element.classList.add("collapse");
            }
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

            if (page < totalPages - 1) { //if page value is less than totalPage value by -1 then show the last li or page
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
    </script>

    <?= $this->endSection() ?>