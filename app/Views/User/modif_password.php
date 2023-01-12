<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<?= $this->endSection() ?>
<div class="form-group">
    <label for="name">Mot de passe actuel</label>
    <input type="text" class="form-control mb-2" name="password" id="password">
</div>
<div class="form-group">
    <label for="name">Nouveau mot de passe</label>
    <input type="text" class="form-control mb-2" name="newpassword" id="newpassword">
</div>
<div class="form-group">
    <label for="name">Retaper nouveau mot de passe</label>
    <input type="text" class="form-control mb-2" name="renewpassword" id="renewpassword">
</div>


<?= $this->section('js') ?>

<?= $this->endSection() ?>