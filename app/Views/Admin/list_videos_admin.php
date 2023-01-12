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
            <th scope="col">Diffuseur</th>
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($listvideos as $video) : ?>
        <tr>
            <td><?= $video['name'] ?></td>
            <td><?= $video['description'] ?></td>
            <td><?= $video['author'] ?></td>
            <td><a href="<?= $video['url'] ?>"><i class="bi bi-arrow-up-right-circle-fill"></i></a></td>
            <?php $j = 0;
            foreach ($video['user'] as $user) : ?>
                <td><?= $user['name'] . " " . $user['firstname'] ?></td>
            <?php $j++;
            endforeach ?>
        </tr>
    <?php $i++;
    endforeach ?>

</table>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>