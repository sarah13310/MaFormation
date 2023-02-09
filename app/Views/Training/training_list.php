<?= $this->extend('layouts/profil') ?>

<?= $this->section('header') ?>
<link href='<?= base_url() ?>/css/theme.css' rel='stylesheet' />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class=""><i class="bi bi-book"></i>&nbsp;&nbsp;<?= $title ?></h1>
<hr class="mt-1 mb-2 ">

<table class="table table-hover w-75">
    <thead class="<?=$headerColor?>">
        <tr>
            <th class="col" scope="col">Titre</th>            
            <th class="col" scope="col">Date et heure</th>
            <th class="col" scope="col">Voir</th>
        </tr>
    </thead>
    <?php foreach ($trainings as $training) : ?>
        <form action="\training\view" method="POST">
            <tr>
                <td class="col" scope="col"><?= $training['title'] ?></td>
                <td class="col" scope="col"><?= $training['date'] ?></td>
                <td class="view col" scope="col"><button class="btn" type="submit" value="<?= $training['id_training'] ?>" name='id_training'><i class="bi bi-eye"></i></button></td>
            </tr>
        </form>
    <?php endforeach ?>
</table>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    let views = document.getElementsByClassName("view");
    for (let i = 0; i < views.length; i++) {

        views[i].addEventListener("click", () => {
            if (views[i].hasAttribute("id")) {
                let id = views[i].getAttribute("id");
                console.log(id);
            }
        });
    }
</script>


<?= $this->endSection() ?>