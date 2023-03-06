<?= $this->extend('layouts/profil') ?>

<?= $this->section('header') ?>
<link href='<?= base_url() ?>/css/theme.css' rel='stylesheet' />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div>
    <div class="d-flex w-75">
        <h1 class="col mb-2 noselect"><i class="bi bi-grid"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2 w-75">
    <div class="mb-1 col noselect " id="option"></div>
</div>

<table class="table border table-hover w-75 rounded-1">
    <thead class="<?= $headerColor ?>">
        <tr style="height:35px;">
            <th class="col" scope="col">Aperçu</th>
            <th class="col" scope="col">Titre</th>
            <th class="col" scope="col">Date et heure</th>
        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>
<form name="form_preview" action="/training/preview" method="post">
    <input type="hidden" name="id_training">
    <input type="hidden" name="title">
    <input type="hidden" name="actions" value="list">
</form>
<div class="pagination w-75">
    <ul class=""></ul>
</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/date.js"></script>
<script src="<?= base_url() ?>/js/paginate2.js"></script>

<script>
    
    option.append(OptionPagination());

    loadData("<?= $training_json ?>","formations");

    function Row(parent, data) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        let a = document.createElement("a");
        a.innerHTML = "<i class='bi bi-eye'>";
        a.classList.add("btn");
        a.addEventListener("click", () => {
            form_preview.id_training.value = data.id_training;
            form_preview.title.value = data.title;
            form_preview.submit();
        });
        let td2 = document.createElement("td");
        td2.innerText = data.title;
        let td3 = document.createElement("td");
        td3.innerText = dateTimeFormat(data.date);
        tbody.append(tr);
        tr.append(td1);
        td1.append(a);
        tr.append(td2);
        tr.append(td3);
    }

    
    
</script>


<?= $this->endSection() ?>