<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<div>
<h1 class="ms-6"><?= $title ?></h1>
<hr class="mt-1 fade-2">
</div>
<div class="row p-3 align-items-center justify-content-center">
    <div class="col-lg-5 col-md-8 my-2">
        <div class="f_contact text-center p-2">
            <h4>Notre formulaire :</h4>
            <form class="row"  action="/contact" method="post">
                <div class="col-12 mt-2">
                    <div>
                        <input class="form-control mb-2" type="text" name="name" id="name" placeholder="Votre Nom" value="<?= set_value('name') ?>">
                        <input class="form-control mb-2" type="text" name="mail" id="mail" placeholder="E-mail" value="<?= set_value('mail') ?>">
                        <div class="col-xs-4 col-6 mt-2 ">
                            <select class="form-select mb-2" id="dropDownId" name="index" onchange="display()">
                                <?= $options ?>
                            </select>
                        </div>
                        <textarea class="form-control mb-2" rows="9" name="content" id="content" placeholder="Message" value="<?= set_value('content') ?>"></textarea>
                    </div>
                    <?php if (isset($validation)) : ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row mb-3">
                        <div>
                            <button class="btn btn-primary" type="submit">Envoyer le message</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-5 col-md-8 my-2">
        <div class="l_contact text-center p-2">
            <h4>Nous localiser :</h4>
            <div class="d-flex justify-content-center align-items-center">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2903.838772440316!2d5.358507574858747!3d43.2966979754174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12c9c09a8f9df3ed%3A0xa5f38246ce5239fe!2sMucem%20-%20Mus%C3%A9e%20des%20civilisations%20de%20l&#39;Europe%20et%20de%20la%20M%C3%A9diterran%C3%A9e!5e0!3m2!1sfr!2sfr!4v1671033326577!5m2!1sfr!2sfr" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>