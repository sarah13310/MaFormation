<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-2"><?= $title ?></h1>
<table class="table">
    <thead class="<?=$headerColor?>">
        <tr>
            <th scope="col">Sujet</th>
            <th scope="col">Description</th>
            <th scope="col">Date et heure</th>
            <th scope="col">Auteur</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($publishes as $publishe) : ?>
            <tr>
                <td><?= $publishe['subject'] ?></td>
                <td><?= $publishe['description'] ?></td>
                <td><?= $publishe['datetime'] ?></td>
                <td><?= $user['name'] . "" . $user['firstname'] ?></td>
                <td>
                    <form action="/publishes/preview" method="post">
                        <input type="hidden" name="id_publication" value="<?= $publishe['id_publication'] ?>">
                        <button type="submit" class="btn mr-2 float-end"><i class="bi bi-arrow-up-right-circle-fill"></i></button>
                    </form>
                </td>
               
        <?php endforeach ?>
    </tbody>

</table>
<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>