<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-3"><?= $title ?></h1>

<div class="row">
    <div class="col-12 col-md-8">
        <table class="table table-hover border">
            <thead class="<?= $headerColor ?>">
                <tr>
                    <th class="hidden" scope="col">Id</th>
                    <th scope="col">Référence</th>
                    <th scope="col">Date</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Voir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bills as $bill) : ?>
                    <tr>
                        <td class="hidden"><?= $bill['id_bill'] ?></td>
                        <td><?= $bill['ref_name'] ?></td>
                        <td><?= $bill['datetime'] ?></td>
                        <td><?= $bill['price'] . " €" ?></td>
                        <td scope="col"><button>...</button> </td>
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