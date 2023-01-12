<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<table class="table">
    <thead class="t_former">
        <tr>
            <th scope="col">Sujet</th>
            <th scope="col">Description</th>
            <th scope="col">Date et heure</th>
            <th scope="col">Nom de l'auteur</th>
            <th scope="col">Prénom de l'auteur</th>
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($listpublishes as $publishe) : ?>
        <tr>
            <td><?= $publishe['subject'] ?></td>
            <td><?= $publishe['description'] ?></td>
            <td><?= $publishe['datetime'] ?></td>
            <?php $k = 0;
            foreach ($publishe['user'] as $user) : ?>
                <td><?= $user['name'] ?></td>
                <td><?= $user['firstname'] ?></td>
            <?php $k++;
            endforeach ?>
            <td>
                <thead class="t_skill">
                    <tr>
                        <th scope="col">Sujet</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date et heure</th>
                    </tr>
                </thead>
                <?php $j = 0;
                foreach ($publishe['article'] as $article) : ?>
        <tr>
            <td><?= $article['subject'] ?></td>
            <td><?= $article['description'] ?></td>
            <td><?= $article['datetime'] ?></td>
        </tr>
    <?php $j++;
                endforeach ?>
    </td>
    </tr>
<?php $i++;
    endforeach ?>

</table>
<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>