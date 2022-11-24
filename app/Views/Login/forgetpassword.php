<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="modal " tabindex="-1" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Réinitialisation en cours</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Message envoyé!</p>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 from-wrapper">
            <div class="container">
                <h3><?= $title ?></h3>
                <hr>
                <h6>Veuillez entrer votre adresse email ci-dessous pour recevoir le lien de réinitialisation du mot de passe.
                    Email</h6>
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
                <form method="post">
                    <div class="form-group">
                        <label class="mt-2 mb-1" for="email">Adresse Mail</label>
                        <input type="text" class="form-control" name="email" id="email" value="<?= session()->set('email') ?>">
                    </div>
                    <?php if (isset($validation)) : ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row mt-3 mb-3 me-0 ms-0">
                        <div class="col col-sm-4">
                            <a href="/login" class="btn btn-outline-primary ">Retour</a>
                        </div>
                        <div class="col">
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Réinitialiser mon mot de passe</a>
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
    const modal = document.getElementById('myModal');
    modal.addEventListener('show.bs.modal', function(event) {

        setTimeout(() => {
            window.location.href = "/login";
        }, 3000)
    });
</script>

<?= $this->endSection() ?>