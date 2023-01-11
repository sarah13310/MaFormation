<?= $this->extend('layouts/default') ?>

<?= $this->section('header') ?>
<link href='<?= base_url() ?>/css/training.css' rel='stylesheet' />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="container" class="container mx-auto w-100 mt-0 noselect">
    <div class="col bargraph-title text-center">
        <?= $title ?>
    </div>
    <div class="col" id="bargraph">
        <div class="row mb-2 p-2 align-items-center">
            <?php if ($count > 0) : ?>
                <div id="home" class="col-1 d-flex justify-content-center"><button class="btn btn-primary rounded2"><i class="bi bi-house bi-bold"></i></button></div>
                <?php for ($i = 0; $i < $count; $i++) : ?>
                    <div class="col bargraph d-flex"></div>
                <?php endfor; ?>
                <div id="trophy" class="col-1 d-flex justify-content-center"><button class="btn btn-primary rounded2"><i class="bi bi-trophy bi-bold"></i></button></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col">
        <div id="menu" class="row">
            <div class="col-12 col-md-8  side-left ">
                <div class="card mb-2 mt-2 gradient-darkgray ">

                    <div class="mx-auto mb-2 " style="height:300px;">
                        <img src="<?= $training['image_url'] ?>" class=" img-fluid rounded mt-2 mb-2" style="height:290px;">
                    </div>

                    <div class="card-body" style="background:white;">
                        <h5 class="card-title"><?= $training['title'] ?></h5>
                        <small><?= "Ecrit le " . $date ?></small>
                        <div class="mt-3">
                            <p class="card-description" style="height: auto"><?= $training['description'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col side-right mb-3">
                <div class="col content-menu-title ">
                    <div class="row align-items-center">
                        <div class="col-1 d-flex justify-content-center noselect">
                            <button id="btn-left" class="btn-arrow btn-arrow-left noselect">
                                < </button>
                        </div>
                        <div class="col text-center">
                            <b> <?= $title ?></b>
                        </div>
                        <div class="col-1 d-flex justify-content-center noselect">
                            <button id="btn-right" class="btn-arrow btn-arrow-right noselect">></button>
                        </div>
                    </div>
                    <div class="col">
                        <ul class="list-group list-group-flush">
                            <?php $i = 1;
                            foreach ($pages as $page) : ?>
                                <li class="list-item"><a><?= $i . ". " . $page['title'] ?></a></li>
                            <?php $i++;
                            endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>

<script>
    const listnum = document.getElementsByClassName('list-item');
    let btn_left = document.getElementById('btn-left');
    let btn_right = document.getElementById('btn-right');
    let selected = getFirst();
    let index = 0;

    function getFirst() {
        return listnum[0];
    }

    function getLast() {
        return listnum[listnum.length - 1];
    }

    function prevItem() {
        index--;
        if (index < 0)
            index = listnum.length - 1;
        return listnum[index];
    }

    function nextItem() {
        index++;
        if (index >= listnum.length)
            index = 0;
        return listnum[index];
    }

    btn_left.addEventListener("click", () => {
        UnSelectAll();
        if (selected) {
            selected = prevItem();

            if (selected)
            {
                selected.classList.toggle("focus");
                selected.click();
            }
        }
    });

    btn_right.addEventListener("click", () => {
        UnSelectAll();
        if (selected) {
            selected = nextItem();
            if (selected){
                selected.classList.toggle("focus");
                selected.click();
            }
        }
    });


    function UnSelectAll() {
        for (let i = 0; i < listnum.length; i++) {
            listnum[i].classList.remove("focus");
        }
    }


    for (let i = 0; i < listnum.length; i++) {
        listnum[i].addEventListener("click", () => {
            UnSelectAll();
            let sel = listnum[i].classList.toggle("focus");
            if (sel) {
                selected = listnum[i];
            }
        });
    };
</script>

<?= $this->endSection() ?>