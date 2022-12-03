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
                <tr>
                    <td><?= $skills['name'] ?></td>
                    <td><?= $skills['content'] ?></td>
                    <td><?= $skills['date'] ?></td>
                    <td><?= $skills['organism'] ?></td>
                    <td><?= $skills['address'] ?></td>
                    <td><?= $skills['city'] ?></td>
                    <td><?= $skills['cp'] ?></td>
                    <td><?= $skills['country'] ?></td>                 
                </tr>
            </td>
        </tr>
     <?php $i++;
endforeach ?>

</table>
<?= $this->endSection() ?>



<?= $this->section('js') ?>

<?= $this->endSection() ?>
