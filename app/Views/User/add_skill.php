<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="ms-4 mb-3"><i class="fs-4 bi-magic"></i>&nbsp;&nbsp;<?= $title ?></h1>
<hr>
<?php if (session()->get('success')) : ?>
    <div id="success" class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>

<div class="mt-4 container">
    <div class="row">

        <div class="col-12 col-md-6">
            <form name="modif" action="/user/skill/add" method="post">
                <input type="hidden" id="id_certificate" name="id_certificate">
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="name" id="name" placeholder='Titre de formation'>
                    <label for="name">Titre de formation</label>
                </div>
                <!-- date -->
                <div class='col form-floating mb-3'>
                    <input type="date" class="form-control mb-2" name="date" id="date" placeholder='Date de formation'>
                    <label for="date">Date de formation</label>
                </div>
                <!-- description -->
                <div class='col form-outline mb-3'>
                    <textarea class="form-control mb-2" rows="3" name="content" id="content" placeholder="Description"></textarea>

                </div>
                <!-- organisme de formation -->
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="organism" id="organism" placeholder="Nom de l'organisme">
                    <label for="organism">Nom de l'organisme</label>
                </div>
                <!-- adresse -->
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="address" id="address" placeholder="Adresse de l'organisme">
                    <label for="address">Adresse de l'organisme</label>
                </div>
                <!-- ville -->
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="city" id="city" placeholder="Ville de l'organisme">
                    <label for="city">Ville de l'organisme</label>
                </div>
                <!-- cp -->
                <div class='col form-floating mb-3'>
                    <input type="text" class="form-control mb-2" name="cp" id="cp" placeholder="Code postale">
                    <label for="cp">Code postale</label>
                </div>
                <!-- pays -->
                <div class='col form-floating mb-3'>
                    <input type="text" readonly class="form-control mb-2" name="country" id="country" value="France" placeholder="Code postale">
                    <label for="country">Pays</label>
                </div>
                <div>
                    <button id="btnModify" type="submit" class="btn <?= $buttonColor ?>">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>

<script src="<?= base_url() . '/js/infos.js' ?>" type="module"></script>
<?= $this->endSection() ?>