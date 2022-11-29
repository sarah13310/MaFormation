<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<div class="container d-flex align-items-center justify-content-center">
    <form action="/company" method="post">
        <div>
            <h4><?= $title ?></h4>
            <hr>
            <div id="chrono" class="alert alert-info" role="alert"></div>
            <div class="form-group">
                <label for="c_siret">Siret de l'entreprise</label>
                <input type="text" class="form-control mb-2" name="c_siret" id="c_siret" value="<?= set_value('c_siret') ?>">
            </div>
            <div class="form-group">
                <label for="c_kbis">Kbis de l'entreprise</label>
                <input type="text" class="form-control mb-2" name="c_kbis" id="c_kbis" value="<?= set_value('c_kbis') ?>">
            </div>
            <?php if (isset($confirmation)) : ?>
                <div class="col-12">
                    <div class="alert alert-danger" role="alert">
                        <?= $confirmation->listErrors() ?>
                    </div>
                </div>
            <?php endif ?>
            <div>
                <button type="submit" class="btn btn-primary mb-3">Confirmer</button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    /* -- -- -- Décompte -- -- -- */
    var cpt = 120;
    var x;

    function decompte() {
        if (cpt >= 0) {
            if (cpt > 1) {
                var sec = " secondes.";
            } else {
                var sec = " seconde.";
                document.location="signin";
            }
            chrono=document.getElementById("chrono");
            chrono.class="alert alert-info";
            chrono.innerHTML = "Redirection dans " + cpt + sec;
            cpt--;
            x = setTimeout("decompte()", 1000);
        } else {
            clearTimeout(x);
        }
    }
    /* -- -- -- Fin -- -- -- */
    document.addEventListener("DOMContentLoaded", function(event) {
        decompte();
    });
</script>

<?= $this->endSection() ?>