<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<table>
<tr>
    <td>Nom</td>
    <td>Prénom</td>
    <td>Adresse</td>
    <td>Ville</td>
    <td>Code postal</td>
    <td>Pays</td>
    <td>Mail</td>
    <td>Téléphone</td>
    <td>Certificat</td>
</tr>

<?php $i = 0;
    foreach ($listformers as $former) : ?>
        <tr>
            <td><?= $former['name'] ?></td>
            <td><?= $former['firstname'] ?></td>
            <td><?= $former['address'] ?></td>
            <td><?= $former['city'] ?></td>
            <td><?= $former['cp'] ?></td>
            <td><?= $former['country'] ?></td>
            <td><?= $former['mail'] ?></td>
            <td><?= $former['phone'] ?></td>
            <td>
                <tr>
                    <td>Nom</td>
                    <td>Contenu</td>
                    <td>Date</td>
                    <td>Organisme</td>
                    <td>Adresse</td>
                    <td>Ville</td>
                    <td>Code postal</td>
                    <td>Pays</td>
                    </tr>
                    <?php $j = 0; foreach ($former['skills'] as $skill) : ?>
                    <tr>
                        <td><?= $skill['name'] ?></td>
                        <td><?= $skill['content'] ?></td>
                        <td><?= $skill['date'] ?></td>
                        <td><?= $skill['organism'] ?></td>
                        <td><?= $skill['address'] ?></td>
                        <td><?= $skill['city'] ?></td>
                        <td><?= $skill['cp'] ?></td>
                        <td><?= $skill['country'] ?></td>                 
                    </tr>
                    <?php $j++; endforeach ?>
            </td>
        </tr>
     <?php $i++;
endforeach ?>

</table>
<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>
