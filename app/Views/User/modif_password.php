<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="ms-4 mb-3"><?= $title ?></h1>
<div class="container">
    <form action="/user/profil/password" method="post">
        <div class='col-6 form-floating mb-3'>
            <input type="password" class="form-control mb-2" name="password" id="password" placeholder='Mot de passe actuel'>
            <label for="password">Mot de passe actuel</label>
        </div>
        <div class='col-6 form-floating mb-3'>
            <input type="password" class="form-control mb-2" name="newpassword" id="newpassword" placeholder="Retaper nouveau mot de passe">
            <label for="newpassword">Nouveau mot de passe</label>
        </div>
        <div class='col-6 form-floating mb-3'>
            <input type="password" class="form-control mb-2" name="renewpassword" id="renewpassword" placeholder="Retaper nouveau mot de passe">
            <label for="renewpassword">Retaper nouveau mot de passe</label>
        </div>
        <div>
            <button type="submit" class="btn <?= $buttonColor ?>">Modifier</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>

<?= $this->endSection() ?>