<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 from-wrapper">
            <div class="container">
                <h3 >Login</h3>
                <hr>
                <?php if (session()->get('success')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('infos') !== null) : ?>
                    <div class="alert alert-warning alert-dismissible fade show js-alert" role="alert">
                        <strong>Login : </strong><?= session()->getFlashdata('infos') ?>
                        <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <form action="login" method="post">
                    <div class="form-group">
                        <label class="mt-2 mb-1" for="email">Adresse Mail</label>
                        <input type="text" class="form-control" name="email" id="email" value="<?= session()->set('email') ?>">
                    </div>
                    <div class="form-group">
                        <label class="mt-2 mb-1" for="password">Mot de passe</label>
                        <input type="password" class="form-control" name="password" id="password" value="<?= session()->set('password') ?>">
                    </div>
                    <?php if (isset($validation)) : ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="align-self-center col-12 col-sm-8 text-right mt-2">
                            <a href="/forgetpassword">Mot de passe oublié?</a>
                    </div>
                    <div class="row mt-3 mb-3 me-0 ms-0">
                        <div class="col-12 col-sm-4 v-center">
                            <button type="submit" class="btn btn-primary ">Connecter</button>
                        </div>
                        <div class="align-self-center col-12 col-sm-8 text-right v-center">
                            <a href="/signin">Inscrivez-vous!</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<!-- Javascript section -->

<?= $this->section("js") ?>
<script type="text/javascript">
    const infos = document.querySelector('#btn-close');

    if (infos) {
        setTimeout(() => {
            //on ferme l'alerte au bout de 2 secondes
            infos.click();
        }, 2000);
    }
</script>

<?= $this->endSection() ?>