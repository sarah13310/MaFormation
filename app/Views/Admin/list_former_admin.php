<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<table class="table">
<thead class="t_former">    
<tr>
    <th scope="col">Nom</th>
    <th scope="col">Prénom</th>
    <th scope="col">Adresse</th>
    <th scope="col">Ville</th>
    <th scope="col">Code postal</th>
    <th scope="col">Pays</th>
    <th scope="col">Mail</th>
    <th scope="col">Téléphone</th>
</tr>
</thead>
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
            <thead class="t_skill">  
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Contenu</th>
                    <th scope="col">Date</th>
                    <th scope="col">Organisme</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Code postal</th>
                    <th scope="col">Pays</th>
                    </tr>
            </thead>       
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
