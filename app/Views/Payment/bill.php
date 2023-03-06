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
        <table class="table w-75 table-hover border rounded-1">
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
    <script src="<?= base_url() ?>/js/paginate2.js"></script>
    <script>
        getStoragePage(localStorage.page_bill);
        option.append(OptionPagination());

        loadData('<?= $bill_json ?>', "factures", localStorage.page_bill);
        ApplyTheme(<?= session()->type ?>);

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

        tbody.addEventListener('page', () => {
            localStorage.page_bill = e.detail.current;
        });

    </script>

    <?= $this->endSection() ?>