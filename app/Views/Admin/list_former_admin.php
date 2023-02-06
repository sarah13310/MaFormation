<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<hr class="mt-1 mb-2">
<table class="table border">
    <thead class="<?=$headerColor ?>">
        <tr>
            <th scope="col"></th>
            <th scope="col">Nom</th>
            <th scope="col">Adresse</th>
            <th scope="col">Ville</th>
            <th scope="col">CP</th>
            <th scope="col">Mail</th>
            <th scope="col">Téléphone</th>
        </tr>
    </thead>
    <?php foreach ($listformers as $former) : ?>
        <tr>
            <td><button onclick="expand(this)" class="btn bi-plus <?= $buttonColor ?>  <?= (count($former['skills']) > 0) ? "" : "hidden" ?>"></button></td>
            <td><?= $former['name'] . " " . $former['firstname'] ?></td>
            <td><?= $former['address'] ?></td>
            <td><?= $former['city'] ?></td>
            <td><?= $former['cp'] ?></td>

            <td><?= $former['mail'] ?></td>
            <td><?= $former['phone'] ?></td>
        </tr>
        <?php if (count($former['skills']) > 0) : ?>
            <tr class="collapse">
                <td colspan=7 >
                    <table class=" table border2" >
                        <thead class=" <?=$headerExtraColor ?>">
                            <tr>
                                <th scope="col">Diplôme</th>                                
                                <th scope="col">Obtenu le </th>
                                <th scope="col">Organisme</th>
                                <th scope="col">Adresse</th>
                                <th scope="col">Ville</th>
                                <th scope="col">CP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($former['skills'] as $skill) : ?>
                                <tr>
                                    <td><?= $skill['name'] ?></td>                                    
                                    <td><?= dateFormat($skill['date']) ?></td>
                                    <td><?= $skill['organism'] ?></td>
                                    <td><?= $skill['address'] ?></td>
                                    <td><?= $skill['city'] ?></td>
                                    <td><?= $skill['cp'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        <?php endif ?>
    <?php endforeach ?>

</table>
<?= $this->endSection() ?>



<?= $this->section('js') ?>
<script>
    function expand(item) {
        const tr = item.parentElement.parentElement;
        let collapse = tr.nextElementSibling.classList.toggle("collapse");
        if (collapse) {
            tr.style.borderBottom="1px solid lightgray";
            item.classList.remove("bi-dash");
            item.classList.add("bi-plus");
        } else {
            tr.style.borderBottom="1px solid transparent";
            item.classList.remove("bi-plus");
            item.classList.add("bi-dash");
        }
    }
</script>
<?= $this->endSection() ?>