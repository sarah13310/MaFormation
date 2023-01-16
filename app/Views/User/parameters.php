<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="ms-4 mb-3"><?= $title ?></h1>
<hr>
<?php if (session()->get('success')) : ?>
    <div id="success" class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>

<div class="mt-4 container">
    <div class="row">
        <div class="col-12 col-md-6">
            <form name="parameters" action="/user/parameters" method="post">

                <!-- luminosité -->
                    <label for="brightness">Luminosité</label>
                    <input type="range" class="form-range mb-4" name="brightness" id="brightness" >
                <!-- contraste -->
                    <label for="contrast">Contraste</label>
                    <input type="range" class="form-range mb-4" name="contrast" id="contrast" >
                <!-- contraste -->
                    <label for="saturation">Saturation</label>
                    <input type="range" class="form-range mb-4" name="saturation" id="saturation" >
                
                <div class="form-floating mb-3">
                    <select class='form-select' disabled id='gender' name="gender" aria-label='Genre'>
                        <option value='0' selected>France</option>
                        <option value='1'>Angleterre</option>
                        <option value='2'>Allemagne</option>
                        <option value='3'>Espagne</option>
                    </select>
                    <label for="gender">Pays</label>
                </div>
                <div>
                    <button id="btnModify" type="submit" class="btn <?= $buttonColor ?>">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>

<script src="<?= base_url() . '/js/infos.js' ?>" type="module"></script>
<?= $this->endSection() ?>