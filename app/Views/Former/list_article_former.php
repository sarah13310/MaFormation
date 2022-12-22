<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<table class="table">
<thead class="t_former">    
<tr>
    <th scope="col">Sujet</th>
    <th scope="col">Description</th>
    <th scope="col">Date et heure</th>
</tr>
</thead>
<?php $i = 0;
    foreach ($listarticles as $article) : ?>
        <tr>
            <td><?= $article['subject'] ?></td>
            <td><?= $article['description'] ?></td>
            <td><?= $article['datetime'] ?></td>
        </tr>
     <?php $i++;
endforeach ?>

</table>
<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>
