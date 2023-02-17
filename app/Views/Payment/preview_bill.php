<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>

<div>
    <div class="d-flex w-75">
        <h1 class="col noselect"><i class="bi bi-currency-euro"></i>&nbsp;&nbsp;<?= $title ?></h1>
        <h6 class="col d-flex flex-row-reverse mt-2"></h6>
    </div>
    <hr class="mt-1 mb-2 w-75">
</div>

<iframe src="<?= $pdf_file ?>" width="70%" height="700px"></iframe>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>

</script>

<?= $this->endSection() ?>