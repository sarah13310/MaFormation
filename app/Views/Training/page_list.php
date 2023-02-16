<?= $this->extend('layouts/profil') ?>

<?= $this->section('content') ?>
<!-- fenetre modale suppression -->
<?= $modalDelete ?>
<!-------------------------------->
<div class="d-flex">
    <h1 class="col-9 mb-2 noselect"><i class="bi bi-grid"></i>&nbsp;&nbsp;<?= $title ?></h1>
    <div class="ms-4 col">
        <a href="/training/list" type="button" class="btn <?= $buttonColor ?>">Retour aux formations</a>
    </div>
</div>
<hr class="mt-1 mb-2">

<?php if (session()->get('success')) : ?>
    <div id="success" class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>

<div class="container">
    <h6><?=session()->title_training ?></h6>
    <div class="mt-2 col">
        <table class="table border table-hover">
            <thead class=<?= $headerColor ?>>
                <tr>
                    <th>Aperçu</th>
                    <th>Nom de la page</th>
                    <th>couverture de la page</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page) : ?>
                    <tr>
                        <td>
                            <a type="button" onclick="onView(<?= $page['id_page'] ?>)" class="col-1 btn mr-2 "><i class='bi bi-eye'></button>
                        </td>
                        <td><?= $page['title'] ?></td>
                        <td><?= $page['image_url'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <form name='form_view'>
            <input type="hidden" name="id_page">
        </form>
    </div>
    <div class="col">
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script defer src="<?= base_url() . '/js/infos.js' ?>"></script>
<script>
   
    function onView(id_page) {
        form_view.method="POST";
        form_view.id_page.value = id_page;
        form_view.action = "/training/page/view";
        form_view.submit();
    }
</script>

<?= $this->endSection() ?>