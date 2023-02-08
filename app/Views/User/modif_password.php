<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="ms-4 mb-3"><?= $title ?></h1>
<?php if (session()->get('success')) : ?>
    <div id="success" class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>
<div class="container">
    <form name="form_password" action="/user/profil/password" method="post">
        <div class='d-flex col-6 form-floating mb-3'>
            <input type="password" class="form-control mb-2" name="password" id="password" placeholder='Mot de passe actuel'>
            <label for="password">Mot de passe actuel</label>
            <i onclick="onViewDelay('#password', this)" class="bi bi-eye-slash togglePassword"></i>
        </div>
        <div class='d-flex col-6 form-floating mb-3'>
            <input type="password" class="form-control mb-2" name="newpassword" id="newpassword" placeholder="Retaper nouveau mot de passe">
            <label for="newpassword">Nouveau mot de passe</label>
            <i onclick="onView('#newpassword', this)" class="bi bi-eye-slash togglePassword"></i>
        </div>
        <div class='d-flex col-6 form-floating mb-3'>
            <input type="password" class="form-control mb-2" name="renewpassword" id="renewpassword" placeholder="Retaper nouveau mot de passe">
            <label for="renewpassword">Retaper nouveau mot de passe</label>
            <i onclick="onView('#renewpassword', this)" class="bi bi-eye-slash togglePassword"></i>
        </div>
        <div>
            <button onclick="onValidate(form_password,'error');" type="button" class="btn <?= $buttonColor ?>">Modifier</button>
        </div>

        <div id='error' class="mt-3 collapse col-6 alert alert-danger" role="alert"><?= $error ?></div>

    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script src="<?= base_url() . '/js/password.js' ?>"></script>
<script src="<?= base_url() . '/js/validator.js' ?>"></script>
<script>
    const error_msg = document.getElementById('error');
    error_msg.innerText = "<?= $error ?>";
    if (error_msg.innerText != "") {
        error_msg.classList.toggle("collapse");
        setTimeout(() => {
            error_msg.classList.toggle("collapse");
            if (elemsel) {
                elemsel.classList.toggle("err");
            }
        }, 2000);
    }

    /**
     * onValidate
     *
     * @return void
     */
    function onValidate(form, id) {
        let err = "";
        

        err = isValidPassword(form_password.password);

        if (!err) {
            err = isValidPassword(form_password.newpassword);
        }

        if (!err) {
            err = isValidPassword(form_password.renewpassword);
        }

        if (form_password.newpassword.value !== form_password.renewpassword.value && !err) {
            err = "mots de passe différents!";
            form_password.renewpassword.focus();
        }

        if (err == "") {
            form.submit();
        } else {
            error_msg.innerText = err;
            error_msg.classList.toggle("collapse");

            setTimeout(() => {
                error_msg.classList.toggle("collapse");
                if (elemsel) {
                    elemsel.classList.toggle("err");
                }
            }, 2000);
        }
    }
</script>
<?= $this->endSection() ?>