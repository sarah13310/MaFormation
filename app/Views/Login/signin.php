
<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<?php require_once ("util.php"); ?>

<div class="container d-flex align-items-center justify-content-center">
    <form class="" action="/signin" method="post">
        <h3><?= $title ?></h3>
        <hr>
        <div class="row">
            <div class="col-xs-3 col-12 mt-0 from-wrapper ">
                <?php if (session()->get('success')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif;?>
                <?php if (session()->getFlashdata('infos') !== null) : ?>
                    <div class="alert alert-warning alert-dismissible fade show js-alert" role="alert">
                        <strong>Login : </strong><?= session()->getFlashdata('infos') ?>
                        <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif;?>
                <div class="row">
                    <div class="col-xs-4 col-6 mt-2 ">
                        <input class="form-control mb-2" type="text" name="name" id="name" placeholder="Votre Nom (*)" value="<?= set_value('name') ?>">
                        <input class="form-control mb-2" type="text" name="firstname" id="firstname" placeholder="Prénom (*)" value="<?= set_value('firstname') ?>">
                        <input class="form-control mb-2" type="textarea" name="address" id="address" placeholder="Adresse" value="<?= set_value('address') ?>">
                        <input class="form-control mb-2" type="text" name="city" id="city" placeholder="Ville" value="<?= set_value('city') ?>">
                        <input class="form-control mb-2" type="text" name="cp" id="cp" placeholder="Code postal" value="<?= set_value('cp') ?>">
                        <input class="form-control mb-2" type="text" name="country" id="country" placeholder="Pays" value="<?= set_value('country') ?>">
                        <input class="form-control mb-2" type="text" name="phone" id="phone" placeholder="Téléphone" value="<?= set_value('phone') ?>">
                        <input class="form-control mb-2" type="text" name="mail" id="mail" placeholder="E-mail (*)" value="<?= set_value('mail') ?>">
                        <input class="form-control mb-2" type="password" name="password" id="password" placeholder="Mot de passe (*)" value="<?= set_value('password') ?>">
                        <input class="form-control mb-2" type="password" name="password_confirm" placeholder="Confirmer mot de passe (*)" id="password_confirm" value="">
                    </div>
                    <div class="col-xs-4 col-6 mt-2 ">
                        <select class="form-select mb-2" id="dropDownId" name="index" onchange="display()">
                            <?= createOptionType();?>                           
                        </select>
                        <div id="snone">
                        </div>
                        <div id="sformer" style="display: none;">
                            <input class="form-control mb-2" type="text" name="f_name" id="f_name" placeholder="Titre de la certification (*)" value="<?= set_value('f_name') ?>">
                            <input class="form-control mb-2" type="textarea" name="f_content" id="f_content" placeholder="Contenu de la certification" value="<?= set_value('f_content') ?>">
                            <input class="form-control mb-2" type="date" name="f_date" id="f_date" placeholder="Date de la certification (*)" value="<?= set_value('f_date') ?>">
                            <input class="form-control mb-2" type="text" name="f_organism" id="f_organism" placeholder="Nom de l'organisme (*)" value="<?= set_value('f_organism') ?>">
                            <input class="form-control mb-2" type="textarea" name="f_address" id="f_address" placeholder="Adresse de l'organisme (*)" value="<?= set_value('f_address') ?>">
                            <input class="form-control mb-2" type="text" name="f_city" id="f_city" placeholder="Ville de l'organisme (*)" value="<?= set_value('f_city') ?>">
                            <input class="form-control mb-2" type="text" name="f_cp" id="f_cp" placeholder="Code postal de l'organisme (*)" value="<?= set_value('f_cp') ?>">
                            <input class="form-control mb-2" type="text" name="f_country" id="f_country" placeholder="Pays de l'organisme " value="<?= set_value('f_country') ?>">
                        </div>
                        <div id="scompany" style="display:none;">
                            <input class="form-control mb-2" type="text" name="c_name" id="c_name" placeholder="Nom de l'entreprise (*)" value="<?= set_value('c_name') ?>">
                            <input class="form-control mb-2" type="textarea" name="c_address" id="c_address" placeholder="Adresse de l'entreprise (*)" value="<?= set_value('c_address') ?>">
                            <input class="form-control mb-2" type="text" name="c_city" id="c_city" placeholder="Ville de l'entreprise (*)" value="<?= set_value('c_city') ?>">
                            <input class="form-control mb-2" type="text" name="c_cp" id="c_cp" placeholder="Code postal de l'entreprise (*)" value="<?= set_value('c_cp') ?>">
                            <input class="form-control mb-2" type="text" name="c_siret" id="c_siret" placeholder="Numéro de Siret (**)" value="<?= set_value('c_siret') ?>">
                            <input class="form-control mb-2" type="text" name="c_kbis" id="c_kbis" placeholder="Kbis (**)" value="<?= set_value('c_kbis') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="newsletters" checked <?= set_checkbox('newsletters', '1'); ?>>
                        <label for="newsletters">S'inscrire à la newsletters</label>
                        <p>(*)  Obligatoire<br>(**) Entreprise non inscrite</p>                        
                    </div>
                    <?php if (isset($validation)) : ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row mb-3">
                        <div class="col-12 col-sm-4">
                            <button class="btn btn-primary" type="submit">S'inscrire</button>
                        </div>
                        <div class="align-self-center col-12 col-sm-8 text-right">
                            <a href="login">Se connecter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    function display() {
        var e = document.getElementById("dropDownId");
        var index = e.selectedIndex;
        if (index == 0) {
            document.getElementById("snone").style.display = 'block'
            document.getElementById("sformer").style.display = 'none'
            document.getElementById("scompany").style.display = 'none'
            //document.getElementById("smember").style.display = 'none'
        } else if (index == 1) {
            document.getElementById("snone").style.display = 'none'
            document.getElementById("sformer").style.display = 'block'
            document.getElementById("scompany").style.display = 'none'
            //document.getElementById("smember").style.display = 'none'
        } else if (index == 2) {
            document.getElementById("snone").style.display = 'none'
            document.getElementById("sformer").style.display = 'none'
            document.getElementById("scompany").style.display = 'block'
            //document.getElementById("smember").style.display = 'none'
        } else if (index == 3) {
            document.getElementById("snone").style.display = 'none'
            document.getElementById("sformer").style.display = 'none'
            document.getElementById("scompany").style.display = 'none'
            //document.getElementById("smember").style.display = 'block'
        }
    }
</script>
<?= $this->endSection() ?>