<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<div class="row justify-content-center align-items-center">
    <div class="myfunding1 d-flex p-3 m-4 justify-content-center align-items-center">
        <img src="assets/img/funding_1.png" class="float-start" width="320" height="300">
        <div class="p-3">
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit
            </h2>
            <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Turpis egestas maecenas pharetra convallis posuere morbi leo.
            </h4>
        </div>
    </div>
    <div class="myfunding2 d-flex flex-column p-3 m-4 justify-content-center align-items-center">
        <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit
        </h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Turpis egestas maecenas pharetra convallis posuere morbi leo.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Turpis egestas maecenas pharetra convallis posuere morbi leo.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Turpis egestas maecenas pharetra convallis posuere morbi leo.
        </p>
        <button class="myfundingbutton" type="button">Bouton</button>
    </div>
    <div class="myfunding3 d-flex justify-content-center align-items-center">
        <div class="myfundingcard d-block p-3 m-4 text-center">
            <img src="assets/img/funding_2.png" class="m-1" width="120" height=100">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
        </div>
        <div class="myfundingcard d-block p-3 m-4 text-center">
            <img src="assets/img/funding_3.png" class="m-1" width="120" height="100">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
        </div>
        <div class="myfundingcard d-block p-3 m-4 text-center">
            <img src="assets/img/funding_4.png" class="m-1" width="120" height="100">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
        </div>
        <div class="myfundingcard d-block p-3 m-4 text-center">
            <img src="assets/img/funding_4.png" class="m-1" width="120" height="100">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>