<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="ms-4 mb-2"><i class="bi bi-speedometer2"></i>&nbsp;&nbsp;<?= $title ?></h1>
<?php if (session()->get('success')) : ?>
    <div id="success" class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>

<div class="container">
    <form action="/user/profil/contact" method="post">
        <div class="row">
            <div class="col">
                <div class='form-floating mb-3'>
                    <input type="text" class="form-control" name="name" id="name" placeholder='Nom' value='<?= session()->name ?>'>
                    <label for="name">Nom</label>
                </div>
                <div class='form-floating mb-3'>
                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder='Prénom' value='<?= session()->firstname ?>'>
                    <label for="name">Prénom</label>
                </div>
                <div class='form-floating mb-3'>
                    <input type="text" class="form-control" name="address" id="address" placeholder='Adresse' value='<?= session()->address ?>'>
                    <label for="name">Adresse</label>
                </div>
                <div class='form-floating mb-3'>
                    <input type="text" class="form-control" name="cp" id="cp" placeholder='Code postal' value='<?= session()->cp ?>'>
                    <label for="cp">CP</label>
                </div>
                <div class='form-floating mb-3'>
                    <input type="text" class="form-control" name="city" id="city" placeholder='Ville' value='<?= session()->city ?>'>
                    <label for="city">Ville</label>
                </div>
                <div class='form-floating mb-3'>
                    <input type="text" class="form-control" name="country" id="country" placeholder='Pays' value="France">
                    <label for="country">Pays</label>
                </div>
            </div>
            <div class="col">
                <div class='form-floating mb-3'>
                    <input type="text" class="form-control" name="mail" id="mail" placeholder='Mail' value='<?= session()->mail ?>'>
                    <label for="mail">Mail</label>
                </div>
                <div class='form-floating mb-3'>
                    <input type="text" class="form-control" name="site" id="site" placeholder='Site' value="www.maformation.com">
                    <label for="site">Site</label>
                </div>
                <div class='form-floating mb-3'>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder='Téléphone' value='<?= session()->phone ?>'>
                    <label for="phone">Téléphone</label>
                </div>
                <div class='form-floating mb-3'>
                    <input type="date" class="form-control" name="birthday" id="birthday" placeholder='Anniversaire' value='<?= session()->birthday ?>'>
                    <label for="birthday">Anniversaire</label>
                </div>
                <div class="form-floating mb-3">
                    <select class='form-select' id='gender' name="gender" aria-label='Genre'>
                        <option value='0' <?= (session()->gender == 0) ? "selected" : "" ?>>Madame</option>
                        <option value='1' <?= (session()->gender == 1) ? "selected" : "" ?>>Monsieur</option>
                        <option value='' <?= (session()->gender == '') ? "selected" : "" ?>>Non renseigné</option>
                    </select>
                    <label for="gender">Genre</label>
                </div>
            </div>
        </div>
        <div>
            <button type="submit" class="btn <?= $buttonColor ?>">Modifier</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() . '/js/infos.js' ?>" type="module"></script>
<?= $this->endSection() ?>