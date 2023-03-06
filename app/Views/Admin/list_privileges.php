<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-2"><i class="bi bi-stoplights"></i>&nbsp;&nbsp;<?= $title ?></h1>
<hr class="mt-1 mb-2">
<table class="table border rounded-1" id="table_admin">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th class="hidden" scope="col">Id</th>
            <th scope="col">Nom</th>
            <th scope="col">Adresse</th>
            <th scope="col">Ville</th>
            <th scope="col">Code postal</th>
            <th scope="col">Mail</th>
            <th scope="col">Téléphone</th>
            <th scope="col">Type</th>
            <th class="hidden" scope="col">Droits</th>
            <th class="hidden" scope="col">Id</th>
        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>

<div class="row">
    <right-panel-ex class="col" id="admin" title="Administrateurs"></right-panel-ex>
    <right-panel-ex class="col" id="former" title="Formateurs"></right-panel-ex>
    <right-panel-ex class="col" id="customer" title="Particuliers"></right-panel-ex>
    <right-panel-ex class="col" id="company" title="Entreprises"></right-panel-ex>
    <right-panel-ex class="col" id="bill" title="Factures"></right-panel-ex>
    <right-panel-ex class="col" id="slide" title="Diapos"></right-panel-ex>
</div>
<hr class="mt-3 mb-2">
<button id="modify" class=" btn btn-primary">Modifier</button>

<form name="form_validate" action="/user/rights" method="POST">
    <input type="hidden" name="id_user">
    <input type="hidden" name="rights">
</form>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/date.js"></script>
<script src="<?= base_url() ?>/js/paginate2.js"></script>
<script src="<?= base_url() ?>/js/rightpanelEx.js"></script>
<script src="<?= base_url() ?>/js/rightbutton.js"></script>

<script>
    loadData('<?= $right_json ?>', "Administrateurs", 1);
    ApplyTheme(<?= session()->type ?>);
    let id_user = -1;

    function Row(parent, data) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td"); // nom 
        let td2 = document.createElement("td"); // adresse
        let td3 = document.createElement("td"); // ville
        let td4 = document.createElement("td"); // cp
        let td5 = document.createElement("td"); // tel
        let td6 = document.createElement("td"); // mail
        let td7 = document.createElement("td"); // type
        let td8 = document.createElement("td"); // droits
        let td9 = document.createElement("td"); // id
        //
        td1.innerText = data.name + " " + data.firstname;
        td2.innerText = data.address;
        td3.innerText = data.city;
        td4.innerText = data.cp;
        td5.innerText = data.phone;
        td6.innerText = data.mail;
        td7.innerText = (data.type == 3) ? "Super Administrateur" : "Administrateur";
        td8.innerText = data.rights;
        td8.classList = "hidden";
        td9.classList = "hidden";
        td9.innerText = data.id_user;
        //
        tbody.append(tr);
        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);
        tr.append(td5);
        tr.append(td6);
        tr.append(td7);
        tr.append(td8);
        tr.append(td9);
        tr.addEventListener("click", (e) => {
            const tr = e.target.parentElement;
            right_user = tr.children[7].innerText;
            id_user = tr.children[8].innerText;
            console.log(right_user, id_user);
            updatePanels(right_user);
            selectRow(tr);
        })
    }

    function DisplayNone() {}

    function getRights(right) {
        return right.split(' ');
    }


    function hex2bin(hex) {
        return ("00000" + (parseInt(hex, 16)).toString(2)).substr(-8);
    }

    function decimalToHexString(number) {
        if (number < 0) {
            number = 0xFFFFFFFF + number + 1;
        }
        if (number < 16)
            return ("0" + number.toString(16).toUpperCase());
        return number.toString(16).toUpperCase();
    }

    let right_admin = "00";
    let right_former = "00";
    let right_customer = "00";
    let right_company = "00";
    let right_bill = "00";
    let right_slide = "00";
    let right_user = "00 00 00 00 00 00";

    function show_right() {
        right_user = `${right_admin} ${right_former} ${right_customer} ${right_company} ${right_bill} ${right_slide}`;
        return right_user;
    }

    const panel_admin = document.querySelector("#admin");
    panel_admin.addEventListener("rights", (e) => {
        right_admin = decimalToHexString(e.detail.value);
        console.log(show_right());
    });

    const panel_former = document.querySelector("#former");
    panel_former.addEventListener("rights", (e) => {
        right_former = decimalToHexString(e.detail.value);
        console.log(show_right());
    });

    const panel_customer = document.querySelector("#customer");
    panel_customer.addEventListener("rights", (e) => {
        right_customer = decimalToHexString(e.detail.value);
        console.log(show_right());
    });

    const panel_company = document.querySelector("#company");
    panel_company.addEventListener("rights", (e) => {
        right_company = decimalToHexString(e.detail.value);
        console.log(show_right());
    });

    const panel_bill = document.querySelector("#bill");
    panel_bill.addEventListener("rights", (e) => {
        right_bill = decimalToHexString(e.detail.value);
        console.log(show_right());
    });

    const panel_slide = document.querySelector("#slide");
    panel_slide.addEventListener("rights", (e) => {
        right_slide = decimalToHexString(e.detail.value);
        console.log(show_right());
    });

    document.querySelector('#modify').addEventListener("click", () => {
        form_validate.id_user = 0;
        form_validate.rights = right_user;
        form_validate.submit();
    });

    function updatePanels(rights) {
        let r = rights.split(" ");
        panel_admin.setRight(r[0]);
        panel_former.setRight(r[1]);
        panel_customer.setRight(r[2]);
        panel_company.setRight(r[3]);
        panel_bill.setRight(r[4]);
        panel_slide.setRight(r[5]);
    }

    function selectRow(tr) {
        let oldtr = document.querySelector(".row-focus");
        if (oldtr)
            oldtr.classList.remove("row-focus");
        tr.classList = "row-focus";
    }

</script>
<?= $this->endSection() ?>