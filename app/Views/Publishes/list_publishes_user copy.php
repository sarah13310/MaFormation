<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-2"><i class="bi bi-grid"></i>&nbsp;&nbsp;<?= $title ?></h1>

<table class="table">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th scope="col">Aperçu</th>
            <th scope="col">Sujet</th>
            <th scope="col">Créé le</th>
            <th scope="col">Voir les articles</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        foreach ($publishes as $publishe) : ?>
            <tr>
                <td>
                    <form action="/publishes/preview" method="post">
                        <input type="hidden" name="id_publication" value="<?= $publishe['id_publication'] ?>">
                        <button type="submit" class="btn mr-2 float-end"><i class="bi bi-eye"></i></button>
                    </form>
                </td>
                <td><?= $publishe['subject'] ?></td>
                <td><?= dateTimeFormat($publishe['datetime']) ?></td>
                <td><button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>">
                        <i class="bi bi-plus"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td colspan=3>
                    <table class="table collapse" id="collapse<?= $i ?>">
                        <thead class="<?= $headerColor ?>">
                            <tr>
                                <th scope="col">Aperçu</th>
                                <th scope="col">Sujet</th>
                                <th scope="col">Créé le</th>
                            </tr>
                        </thead>
                        <?php $j = 0;
                        foreach ($publishe['article'] as $article) : ?>
                            <tr>
                                <td>
                                    <form action="/article/preview" method="post">
                                        <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                                        <button type="submit" class="btn mr-2 float-end"><i class="bi bi-eye"></i></button>
                                    </form>
                                </td>
                                <td><?= $article['subject'] ?></td>
                                <td><?= dateTimeFormat($article['datetime']) ?></td>
                            </tr>
                        <?php $j++;
                        endforeach ?>
                </td>
            <tr>
</table>
<?php $i++;
        endforeach ?>
</tbody>
</table>



<?= $this->endSection() ?>



<?= $this->section('js') ?>
<script>
    let body = document.getElementById("body");
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
        while (body.lastElementChild) {
            body.removeChild(body.lastElementChild);
        }
        for (let i = 0; i < items_display.length; i++) {
            Row(body, items_display[i]);
        }
    }

    fetch("<?= $article_json ?>")
        .then(res => res.json())
        .then(data => {
            buffer = data;
            RefreshPage();
            totalPages = Math.ceil(buffer.length / items_per_page);;
            element.innerHTML = createPagination(totalPages, 1);
        });

    function Row(parent, data) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        let a = document.createElement("a");
        a.innerHTML = "<i class='bi bi-eye'>";
        a.classList.add("btn");
        a.addEventListener("click", () => {
            form_preview.id_article.value = data.id_article;
            form_preview.submit();
        });
        let td2 = document.createElement("td");
        td2.innerText = data.subject;
        let td3 = document.createElement("td");
        td3.innerText = dateTimeFormat(data.datetime);
        body.append(tr);
        tr.append(td1);
        td1.append(a);
        tr.append(td2);
        tr.append(td3);
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