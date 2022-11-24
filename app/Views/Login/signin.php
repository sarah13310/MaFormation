<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<div>
    <h1><?= $title ?></h1>
    <form class="" action="/signin" method="post">
        <div>
            <div>
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" value="<?= set_value('name') ?>">
            </div>
            <div>
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname" id="firstname" value="<?= set_value('firstname') ?>">
            </div>
            <div>
                <label for="address">Adresse</label>
                <input type="textarea" name="address" id="address" value="<?= set_value('address') ?>">
            </div>
            <div>
                <label for="city">Ville</label>
                <input type="text" name="city" id="city" value="<?= set_value('city') ?>">
            </div>
            <div>
                <label for="cp">Code postal</label>
                <input type="text" name="cp" id="cp" value="<?= set_value('cp') ?>">
            </div>
            <div>
                <label for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" value="<?= set_value('phone') ?>">
            </div>
            <div>
                <label for="mail">E-mail</label>
                <input type="text" name="mail" id="mail" value="<?= set_value('mail') ?>">
            </div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" value="<?= set_value('password') ?>">
            </div>
            <div>
                <label for="password_confirm">Confirmer mot de passe</label>
                <input type="password" name="password_confirm" id="password_confirm" value="">
            </div>
            <div>
                <label for="type">Vous êtes :</label>
                <select id="dropDownId" name="index" onchange="display()">
                    <option value="1" selected="selected">---</option>
                    <option value="2">Un formateur</option>
                    <option value="3">Une entreprise</option>
                    <option value="4">Un particulier</option>
                </select>
                <div id="snone">
                </div>
                <div id="sformer" style="display: none;">
                    <div>
                        <label for="f_name">Nom de la certification</label>
                        <input type="text" name="f_name" id="f_name" value="<?= set_value('f_name') ?>">
                    </div>
                    <div>
                        <label for="f_content">Contenu de la certification</label>
                        <input type="textarea" name="f_content" id="f_content" value="<?= set_value('f_content') ?>">
                    </div>
                    <div>
                        <label for="f_date">Date de la certification</label>
                        <input type="date" name="f_date" id="f_date" value="<?= set_value('f_date') ?>">
                    </div>
                    <div>
                        <label for="f_location">Lieu de la certification</label>
                        <input type="text" name="f_location" id="f_location" value="<?= set_value('f_location') ?>">
                    </div>
                </div>
                <div id="scompany" style="display: none;">
                    <div>
                        <label for="c_name">Nom de l'entreprise</label>
                        <input type="text" name="c_name" id="c_name" value="<?= set_value('c_name') ?>">
                    </div>
                    <div>
                        <label for="c_address">Adresse de l'entreprise</label>
                        <input type="textarea" name="c_address" id="c_address" value="<?= set_value('c_address') ?>">
                    </div>
                    <div>
                        <label for="c_city">Ville de l'entreprise</label>
                        <input type="text" name="c_city" id="c_city" value="<?= set_value('c_city') ?>">
                    </div>
                    <div>
                        <label for="c_cp">Code postal de l'entreprise</label>
                        <input type="text" name="c_cp" id="c_cp" value="<?= set_value('c_cp') ?>">
                    </div>
                    <div>
                        <label for="c_siret">Siret de l'entreprise</label>
                        <input type="text" name="c_siret" id="c_siret" value="<?= set_value('c_siret') ?>">
                    </div>
                    <div>
                        <label for="c_kbis">Kbis de l'entreprise</label>
                        <input type="text" name="c_kbis" id="c_kbis" value="<?= set_value('c_kbis') ?>">
                    </div>
                </div>
                <div id="smember" style="display: none;">
                </div>
            </div>
            <?php if (isset($validation)) : ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
            <div>
                <button type="submit">S'inscrire</button>
            </div>
            <div>
                <a href="login">Se connecter</a>
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
            document.getElementById("smember").style.display = 'none'
        } else if (index == 1) {
            document.getElementById("snone").style.display = 'none'
            document.getElementById("sformer").style.display = 'block'
            document.getElementById("scompany").style.display = 'none'
            document.getElementById("smember").style.display = 'none'
        } else if (index == 2) {
            document.getElementById("snone").style.display = 'none'
            document.getElementById("sformer").style.display = 'none'
            document.getElementById("scompany").style.display = 'block'
            document.getElementById("smember").style.display = 'none'
        } else if (index == 3) {
            document.getElementById("snone").style.display = 'none'
            document.getElementById("sformer").style.display = 'none'
            document.getElementById("scompany").style.display = 'none'
            document.getElementById("smember").style.display = 'block'
        }
    }
</script>
<?= $this->endSection() ?>