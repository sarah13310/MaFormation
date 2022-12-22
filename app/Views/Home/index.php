<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('header') ?>
<link rel="stylesheet" href="<?= base_url() ?>/css/carousel.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<!-- Carousel des formations -->

  <div id="carouselCaptions" class="carousel slide" data-bs-ride="carousel">
    <?= $trainings ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

<!-- Carousel des articles -->
<?php if (count($articles) > 0) : ?>
  <div id="carouselCaptions" class="carousel slide" data-bs-ride="carousel">
    <?= listCarousel($articles) ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
<?php endif ?>

<!--  -->
<div class="infohome">
  <img src="<?= base_url() ?>/assets/img/97e1ffb95c4e03e98046c612ba4d0f5e.jpg" class="d-block w-100" alt="Info Home" />
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    Habitant morbi tristique senectus et netus. Proin fermentum leo vel orci porta.
    Lacus sed turpis tincidunt id aliquet risus feugiat in.
    Lacinia at quis risus sed vulputate. Nulla facilisi nullam vehicula ipsum.
    Ultrices vitae auctor eu augue ut. Et netus et malesuada fames ac turpis egestas integer eget.
    Arcu non odio euismod lacinia at. Porttitor lacus luctus accumsan tortor posuere ac ut.
    Fermentum dui faucibus in ornare quam viverra. Nibh ipsum consequat nisl vel pretium.
    Odio aenean sed adipiscing diam donec. Lorem mollis aliquam ut porttitor leo a diam.
    Ultrices eros in cursus turpis massa tincidunt.
    Porttitor massa id neque aliquam. Morbi non arcu risus quis varius quam.</p>
</div>
<div class="infofund">
  <img src="<?= base_url() ?>/assets/img/7ad690549ef9ac94a7d292587006dc5b.jpg" class="d-block w-100" alt="Info Funding" />
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    Habitant morbi tristique senectus et netus. Proin fermentum leo vel orci porta.
    Lacus sed turpis tincidunt id aliquet risus feugiat in.
    Lacinia at quis risus sed vulputate. Nulla facilisi nullam vehicula ipsum.
    Ultrices vitae auctor eu augue ut. Et netus et malesuada fames ac turpis egestas integer eget.
    Arcu non odio euismod lacinia at. Porttitor lacus luctus accumsan tortor posuere ac ut.
    Fermentum dui faucibus in ornare quam viverra. Nibh ipsum consequat nisl vel pretium.
    Odio aenean sed adipiscing diam donec. Lorem mollis aliquam ut porttitor leo a diam.
    Ultrices eros in cursus turpis massa tincidunt.
    Porttitor massa id neque aliquam. Morbi non arcu risus quis varius quam.</p>
  <button class="btn btn-outline-primary" onclick="location = '/funding'">Me financer</button>
</div>
<section class="">
  <form action="/" method="post">
    <!--Grid row-->
    <div class="row d-flex justify-content-center">
      <!--Grid column-->
      <div class="col-auto">
        <p class="pt-2">
          <strong>S'abonner à la lettre d'informations</strong>
        </p>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-md-5 col-12">
        <!-- Email input -->
        <div class="form-outline form-white mb-4">
          <input class="form-control mb-2" type="text" name="mail" id="mail" placeholder="Adresse mail" value="">
        </div>
      </div>
      <!--Grid column-->

      <?php if (isset($validation)) : ?>
        <div class="col-12">
          <div class="alert alert-danger" role="alert">
            <?= $validation->listErrors() ?>
          </div>
        </div>
      <?php endif; ?>
      <!--Grid column-->
      <div class="col-auto">
        <!-- Submit button -->
        <button type="submit" class="btn btn-outline-dark mb-4">
          Souscrire
        </button>
      </div>
      <!--Grid column-->
    </div>
    <!--Grid row-->
  </form>
</section>
<!-- Section: Form -->


<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/carousel.js"></script>
<?= $this->endSection() ?>