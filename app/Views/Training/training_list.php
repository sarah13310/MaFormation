<?= $this->extend('layouts/profil') ?>

<?= $this->section('header') ?>
<link href='<?= base_url() ?>/css/theme.css' rel='stylesheet' />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>

<table class="table table-hover">
    <thead class="<?=$headerColor?>">
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Description</th>
            <th scope="col">Date et heure</th>
            <th scope="col">Voir</th>
        </tr>
    </thead>
    <?php foreach ($trainings as $training) : ?>
        <form action="\training\view" method="POST">
            <tr>
                <td scope="col"><?= $training['title'] ?></td>
                <td scope="col"><?= $training['description'] ?></td>
                <td scope="col"><?= $training['date'] ?></td>
                <td class="view" scope="col"><button class="<?= $theme_button ?>" type="submit" value="<?= $training['id_training'] ?>" name='id_training'><i class="bi bi-eye"></i></button></td>
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