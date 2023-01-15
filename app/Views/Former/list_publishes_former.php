<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<div class="container-fluid">
    <table class="table">
        <thead class="t_former">
            <tr>
                <th class="col" scope="col">Aperçu</th>
                <th class="col" scope="col">Sujet</th>
                <th class="col" scope="col">Description</th>
                <th class="col" scope="col">Date et heure</th>
            </tr>
        </thead>
        <?php
        foreach ($listpublishes as $publishe) : ?>
            <tr>
                <td class="col">
                    <form action="/publishes/preview" method="post">
                        <input type="hidden" name="id_publication" value="<?= $publishe['id_publication'] ?>">
                        <button type="submit" class="btn mr-2 float-end"><i class="bi bi-arrow-up-right-circle-fill"></i></button>
                    </form>
                </td>
                <td class="col"><?= $publishe['subject'] ?></td>
                <td class="col"><?= $publishe['description'] ?></td>
                <td class="col"><?= $publishe['datetime'] ?></td>
                <td class="col">
                    <thead class="t_skill">
                        <tr>
                            <th class="col" scope="col">Aperçu</th>
                            <th class="col" scope="col">Sujet</th>
                            <th class="col" scope="col">Description</th>
                            <th class="col" scope="col">Date et heure</th>
                        </tr>
                    </thead>
                    <?php $j = 0;
                    foreach ($publishe['article'] as $article) : ?>
            <tr>
                <td class="col">
                    <form action="/articles/preview" method="post">
                        <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                        <button type="submit" class="btn mr-2 float-end"><i class="bi bi-arrow-up-right-circle-fill"></i></button>
                    </form>
                </td>
                <td class="col"><?= $article['subject'] ?></td>
                <td class="col"><?= $article['description'] ?></td>
                <td class="col"><?= $article['datetime'] ?></td>
            </tr>
        <?php $j++;
                    endforeach ?>
        </td>
        </tr>
    <?php endforeach ?>

    </table>
</div>
<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>