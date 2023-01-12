<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-1"><?= $title ?></h1>
<table class="table">
    <thead class="t_former">
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Description</th>
            <th scope="col">Auteur</th>
            <th scope="col">URL</th>
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($listbooks as $book) : ?>
        <tr>
            <td><?= $book['name'] ?></td>
            <td><?= $book['description'] ?></td>
            <td><?= $book['author'] ?></td>
            <td><a href="<?= $book['url'] ?>"><i class="bi bi-arrow-up-right-circle-fill"></i></a></td>
        </tr>
    <?php $i++;
    endforeach ?>

</table>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>