<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-2"><?= $title ?></h1>
<table class="table">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th scope="col">Aperçu</th>
            <th scope="col">Sujet</th>
            <th scope="col">Créé le</th>
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($listarticles as $article) : ?>
        <tr>
            <td>
                <form action="/article/preview" method="post">
                    <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                    <button type="submit" class="btn mr-2 float-end"><i class="bi bi-eye"></i></button>
                </form>
            </td>
            <td><?= $article['subject'] ?></td>
            <td><?= dateTimeFormat($article['datetime']) ?></td>
        </tr>
    <?php $i++;
    endforeach ?>

</table>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>