<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-1"><?= $title ?></h1>
<hr class="mb-3">
<div class="row">
    <div class="col-12 col-md-8 table-responsive">
        <table class="table border ">
            <thead class="<?= $headerColor ?>">
                <tr>
                    <th class="<?= $showDetails ?>" scope="col"></th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Localité</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $item) : ?>
                    <tr>
                        <td class="<?= $showDetails ?>"><button onclick="expand(this)" class="btn bi-plus <?= $buttonColor ?>"></button></td>
                        <td><?= $item['user']['name'] ?></td>
                        <td><?= $item['user']['firstname'] ?></td>
                        <td><?= $item['user']['address'] ?></td>
                        <td><?= $item['user']['city'] . " <i>" . $item['user']['cp'] . "</i>" ?></td>
                    </tr>
                    <?php if ($count > 0) : ?>
                        <tr class="collapse">
                            <td colspan=4>
                                <table class="table border " style="width:120%; ">
                                    <thead class="<?= $buttonColor ?>" >
                                        <tr >
                                            <th scope="col">Société</th>
                                            <th scope="col">Adresse</th>
                                            <th scope="col">Localité</th>
                                            <th scope="col">CP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><?= $item['company']['name'] ?></td>
                                        <td><?= $item['company']['address'] ?></td>
                                        <td><?= $item['company']['city']  ?></td>
                                        <td><?= "<i>" . $item['company']['cp'] . "</i>" ?></td>
                                    </tbody>
                                </table>
                            <td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="col-12 col-md-4"></div>
    <div>
    </div>
    <?= $this->endSection() ?>


    <?= $this->section('js') ?>
    <script>        
        function expand(item) {
            const tr = item.parentElement.parentElement;
            let collapse = tr.nextElementSibling.classList.toggle("collapse");
            if (collapse){
                tr.style.borderBottom="1px solid lightgray";
                item.classList.remove("bi-dash");
                item.classList.add("bi-plus");
            }
            else{          
                tr.style.borderBottom="1px solid transparent";      
                item.classList.remove("bi-plus");
                item.classList.add("bi-dash");
            }                
        }
    </script>
    <?= $this->endSection() ?>