<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<?= $this->endSection() ?>
<div class="form-group">
    <label for="name">Nom</label>
    <input type="text" class="form-control mb-2" name="name" id="name">
</div>
<div class="form-group">
    <label for="name">Prénom</label>
    <input type="text" class="form-control mb-2" name="firstname" id="firstname">
</div>

<div class="col-md-6">
    <div class='form-floating mb-3'>
        <input type="text" class="form-control" name="address" id="address" placeholder='Adresse'>
        <label for="name">Adresse</label>
    </div>
    <div class='form-floating mb-3'>
        <input type="text" class="form-control" name="cp" id="cp" placeholder='Code postal'>
        <label for="cp">CP</label>
    </div>
    <div class='form-floating mb-3'>
        <input type="text" class="form-control" name="city" id="city" placeholder='Ville'>
        <label for="city">Ville</label>
    </div>
    <div class='form-floating mb-3'>
        <input type="text" class="form-control" name="country" id="country" placeholder='Pays'>
        <label for="country">Pays</label>
    </div>
</div>
<div class="col-md-6">
    <div class='form-floating mb-3'>
        <input type="text" class="form-control" name="mail" id="mail" placeholder='Mail'>
        <label for="mail">Mail</label>
    </div>
    <div class='form-floating mb-3'>
        <input type="text" class="form-control" name="site" id="site" placeholder='Site'>
        <label for="site">Site</label>
    </div>
    <div class='form-floating mb-3'>
        <input type="text" class="form-control" name="phone" id="phone" placeholder='Téléphone'>
        <label for="phone">Téléphone</label>
    </div>
    <div class='form-floating mb-3'>
        <input type="date" class="form-control" name="birthday" id="birthday" placeholder='Anniversaire'>
        <label for="birthday">Anniversaire</label>
    </div>
    <div class="form-floating mb-3">
        <select class='form-select' id='gender' name="gender" aria-label='Genre'>
            <option value='0'>Madame</option>
            <option value='1'>Monsieur</option>
            <option value='Null' selected>Non renseigné</option>
        </select>
        <label for="gender">Genre</label>
    </div>
</div>


<?= $this->section('js') ?>

<?= $this->endSection() ?>