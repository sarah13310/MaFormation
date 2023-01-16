<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-2"><?= $title ?></h1>
<table class="table">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th scope="col">Aperçu</th>
            <th scope="col">Sujet</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Auteur</th>
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($listarticles as $article) : ?>
        <tr>
            <td>
                <form action="/article/preview" method="post">
                    <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                    <button type="submit" class="btn mr-2 float-end"><i class="bi bi-arrow-up-right-circle-fill"></i></button>
                </form>
            </td>
            <td><?= $article['subject'] ?></td>
            <td><?= $article['description'] ?></td>
            <td><?= $article['datetime'] ?></td>
            <?php foreach ($article['user'] as $user) : ?>
                <td><?= $user['name'] . " " . $user['firstname'] ?></td>
            <?php endforeach ?>
        </tr>
    <?php $i++;
    endforeach ?>

</table>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>