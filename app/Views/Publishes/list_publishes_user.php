<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-2"><?= $title ?></h1>

<table class="table">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th scope="col">Aperçu</th>
            <th scope="col">Sujet</th>
            <th scope="col">Créé le</th>
            <th scope="col">Voir les articles</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        foreach ($publishes as $publishe) : ?>
            <tr>
                <td>
                    <form action="/publishes/preview" method="post">
                        <input type="hidden" name="id_publication" value="<?= $publishe['id_publication'] ?>">
                        <button type="submit" class="btn mr-2 float-end"><i class="bi bi-eye"></i></button>
                    </form>
                </td>
                <td><?= $publishe['subject'] ?></td>
                <td><?= dateTimeFormat($publishe['datetime']) ?></td>
                <td><button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>">
                        <i class="bi bi-plus"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td colspan=3>
                    <table class="table collapse" id="collapse<?= $i ?>">
                        <thead class="<?= $headerColor ?>">
                            <tr>
                                <th scope="col">Aperçu</th>
                                <th scope="col">Sujet</th>
                                <th scope="col">Créé le</th>
                            </tr>
                        </thead>
                        <?php $j = 0;
                        foreach ($publishe['article'] as $article) : ?>
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
                        <?php $j++;
                        endforeach ?>
                </td>
            <tr>
</table>
<?php $i++;
        endforeach ?>
</tbody>
</table>



<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>