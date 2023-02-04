<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-1"><?= $title ?></h1>
<hr class="mb-3">
<div class="row">
    <div class="col-12 col-md-8">
        <table class="table table-hover border">
            <thead class="<?= $headerColor ?>">
                <tr>
                    <th class="hidden" scope="col">Id</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Localité</th>
                    <th class="hidden"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td class="hidden"><?= $user['id_user'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['firstname'] ?></td>
                        <td><?= $user['address'] ?></td>
                        <td><?= $user['city'] . " <i>" . $user['cp'] . "</i>" ?></td>
                        <td class="hidden"></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="col-12 col-md-4"></div>
    <div>
    </div>
    <?= $this->endSection() ?>


    <?= $this->section('js') ?>

    <?= $this->endSection() ?>