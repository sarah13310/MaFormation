<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<table class="table">
    <thead class="t_former">
        <tr>
            <th scope="col">Aperçu</th>
            <th scope="col">Sujet</th>
            <th scope="col">Description</th>
            <th scope="col">Date et heure</th>
            <th scope="col">Auteur</th>
            
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($listpublishes as $publishe) : ?>
        <tr>
            <td>
                <form action="/publishes/preview" method="post">
                    <input type="hidden" name="id_publication" value="<?= $publishe['id_publication'] ?>">
                    <button type="submit" class="btn mr-2 float-end"><i class="bi bi-arrow-up-right-circle-fill"></i></button>
                </form>
            </td>
            <td><?= $publishe['subject'] ?></td>
            <td><?= $publishe['description'] ?></td>
            <td><?= $publishe['datetime'] ?></td>
            <?php $k = 0;
            foreach ($publishe['user'] as $user) : ?>
                <td><?= $user['name']. " ".  $user['firstname'] ?></td>
            <?php $k++;
            endforeach ?>
            <td>
                <thead class="t_skill">
                    <tr>
                        <th scope="col">Aperçu</th>
                        <th scope="col">Sujet</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date et heure</th>
                    </tr>
                </thead>
                <?php $j = 0;
                foreach ($publishe['article'] as $article) : ?>
        <tr>
            <td>
                <form action="/articles/preview" method="post">
                    <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                    <button type="submit" class="btn mr-2 float-end"><i class="bi bi-arrow-up-right-circle-fill"></i></button>
                </form>
            </td>
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