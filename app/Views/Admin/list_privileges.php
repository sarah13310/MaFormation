<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-2" ><?= $title ?></h1>
<table class="table" id="table_admin">
    <thead class="<?= $headerColor?>">
        <tr>
            <th class="hidden" scope="col">Id</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Adresse</th>
            <th scope="col">Ville</th>
            <th scope="col">Code postal</th>
            <th scope="col">Pays</th>
            <th scope="col">Mail</th>
            <th scope="col">Téléphone</th>
            <th scope="col">Type</th>
            <th class="hidden" scope="col">Droits</th>
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($listformers as $former) : ?>
        <tr>
            <td class="hidden"><?= $i ?></td>
            <td><?= $former['name'] ?></td>
            <td><?= $former['firstname'] ?></td>
            <td><?= $former['address'] ?></td>
            <td><?= $former['city'] ?></td>
            <td><?= $former['cp'] ?></td>
            <td><?= $former['country'] ?></td>
            <td><?= $former['mail'] ?></td>
            <td><?= $former['phone'] ?></td>
            <td>
                <?php if ($former['type'] == 3) : ?>
                    <?= "Super administrateur" ?>
                <?php else : ?>
                    <?= "Administrateur" ?>
                <?php endif ?>
            </td>
            <td class="hidden"><?= $former['rights'] ?></td>
        </tr>
    <?php $i++;
    endforeach ?>
</table>

<table class="table mt-4" id="table_rights">
    <thead class="t_former">
        <tr>
            <th scope="col">Administrateur</th>
            <th scope="col">Formateurs</th>
            <th scope="col">Particuliers</th>
            <th scope="col">Entreprises</th>
            <th scope="col">Factures</th>
            <th scope="col">Diapos</th>
        </tr>
    </thead>
    <?php $rights = getRights($listformers[0]['rights']) ?>
    <tr id="rights">
        <td><?= translateRights($rights[0]) ?></td>
        <td><?= translateRights($rights[1]) ?></td>
        <td><?= translateRights($rights[2]) ?></td>
        <td><?= translateRights($rights[3]) ?></td>
        <td><?= translateRights($rights[4]) ?></td>
        <td><?= translateRights($rights[5]) ?></td>
    </tr>
</table>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    function setupToolTip() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    }

    function getRights(right) {
        return right.split(' ');
    }

    const FLAG_WRITE = "10000";
    const FLAG_READ = "01000";
    const FLAG_UPDATE = "000100";
    const FLAG_DELETE = "000010";
    const FLAG_EXPORT = "000001";

    function hex2bin(hex) {
        return ("00000" + (parseInt(hex, 16)).toString(2)).substr(-8);
    }

    function translateRights(right) {

        let icons = "<td><div style='display:flex;'>";
        let mask = hex2bin(right);

        if (mask & FLAG_WRITE) {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Ajout'><i class='bi bi-plus-circle-fill'></i></div>";
        } else {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Ajout'><i class='bi bi-plus-circle'></i></div>";
        }
        icons += "&nbsp";
        if (mask & FLAG_READ) {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Lecture'><i class='bi bi-info-circle-fill'></i></div>";
        } else {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Lecture'><i class='bi bi-info-circle'></i></div>";
        }
        icons += "&nbsp";
        if (mask & FLAG_UPDATE) {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mise à jour'><i class='bi bi-check-circle-fill'></i></div>";
        } else {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mise à jour'><i class='bi bi-check-circle'></i></div>";
        }
        icons += "&nbsp";
        if (mask & FLAG_DELETE) {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Suppression'><i class='bi bi-dash-circle-fill'></i></div>";
        } else {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Suppression'><i class='bi bi-dash-circle'></i></div>";
        }
        icons += "&nbsp";
        if (mask & FLAG_EXPORT) {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Exportation'><i class='bi bi-arrow-up-circle-fill'></i></div>";
        } else {
            icons += "<div data-bs-toggle='tooltip' data-bs-placement='bottom' title='Exportation'><i class='bi bi-arrow-up-circle'></i></div>";
        }
        icons += "</div></td>";

        return icons;
    }

    function addRowHandlers() {
        var table = document.getElementById("table_admin");
        var table_rights = document.getElementById("table_rights");
        var rows = table.getElementsByTagName("tr");
        var rows_rights = table_rights.getElementsByTagName("tr");

        for (i = 0; i < rows.length; i++) {
            var currentRow = table.rows[i];
            var createClickHandler = function(row) {
                return function() {
                    var cell = row.getElementsByTagName("td")[0];
                    var id = cell.innerHTML;
                    var cell2 = row.getElementsByTagName("td")[10];
                    var right = cell2.innerHTML;
                    rights = getRights(right);
                    let str = "";
                    rights.forEach(element => {
                        str += translateRights(element);
                    });

                    rows_rights[1].innerHTML = str;
                    setupToolTip()
                };
            };
            currentRow.onclick = createClickHandler(currentRow);
        }
    }
    addRowHandlers();
    setupToolTip()
</script>
<?= $this->endSection() ?>