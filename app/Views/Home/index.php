<?= $this->extend('layouts/default') ?>
<?= $this->section('header') ?>
<link rel="stylesheet" href="<?= base_url() ?>/css/carousel.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<!-- Carousel des formations -->

<div id="carouselTraining" class="carousel slide" data-bs-ride="carousel">
  <?= $trainings ?>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselTraining" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselTraining" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Carousel des articles -->

<div id="carouselArticles" class="carousel slide" data-bs-ride="carousel">
  <?= $articles ?>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselArticles" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselArticles" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></i></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<!--  -->
<div class="d-flex justify-content-center">
  <div class="w-50 m-2 p-2 text-center">
    <img src="<?= base_url() ?>/assets/img/97e1ffb95c4e03e98046c612ba4d0f5e.jpg" class="w-50 m-2" alt="Info Home" />
    <p>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
      Habitant morbi tristique senectus et netus. Proin fermentum leo vel orci porta.
      Lacus sed turpis tincidunt id aliquet risus feugiat in.
      Lacinia at quis risus sed vulputate. Nulla facilisi nullam vehicula ipsum.
      Ultrices vitae auctor eu augue ut. Et netus et malesuada fames ac turpis egestas integer eget.
      Arcu non odio euismod lacinia at. Porttitor lacus luctus accumsan tortor posuere ac ut.
      Fermentum dui faucibus in ornare quam viverra. Nibh ipsum consequat nisl vel pretium.
    </p>
  </div>
</div>
<div class="d-flex justify-content-center">
  <div class="w-50 m-2 p-2 text-center">
    <img src="<?= base_url() ?>/assets/img/7ad690549ef9ac94a7d292587006dc5b.jpg" class="w-50 m-2" alt="Info Funding" />
    <p>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
      Habitant morbi tristique senectus et netus. Proin fermentum leo vel orci porta.
      Lacus sed turpis tincidunt id aliquet risus feugiat in.
      Lacinia at quis risus sed vulputate. Nulla facilisi nullam vehicula ipsum.
      Ultrices vitae auctor eu augue ut. Et netus et malesuada fames ac turpis egestas integer eget.
      Arcu non odio euismod lacinia at. Porttitor lacus luctus accumsan tortor posuere ac ut.
      Fermentum dui faucibus in ornare quam viverra. Nibh ipsum consequat nisl vel pretium.
    </p>
    <button class="btn btn-outline-primary" onclick="location = '/funding'">Me financer</button>
  </div>
</div>
<section class="m-2">
  <form name="form_newsletters" action="/newsletters" method="post">
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
          <input class="required form-control mb-2" type="text" name="mail" id="mail" placeholder="Adresse mail" value="">
        </div>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-auto">
        <!-- Submit button -->
        <button onclick="onValidateMail(form_newsletters, 'error');" type="button" class="btn btn-outline-dark mb-4">
          Souscrire
        </button>
      </div>
      <div id='error' class="collapse col-8 alert alert-danger" role="alert"></div>
      <!--Grid column-->
    </div>
    <!--Grid row-->
  </form>
</section>
<!-- Section: Form -->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/validator.js"></script>
<script src="<?= base_url() ?>/js/carousel.js"></script>
<script>
  
  new MultiCarousel(".carousel .carousel-item", "#carouselTraining", 3);
  new MultiCarousel(".carousel .carousel-item", "#carouselArticles", 3);
  
</script>
<?= $this->endSection() ?>