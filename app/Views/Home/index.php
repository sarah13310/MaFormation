<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/img/img1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Débutant</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assets/img/img2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Expérimenté</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assets/img/img3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Entreprise</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div class="infohome">
<img src="assets/img/97e1ffb95c4e03e98046c612ba4d0f5e.jpg" class="d-block w-100" alt="Info Home"/>
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
<img src="assets/img/74d010acd89ad141193a1a85f28eba1a.jpg" class="d-block w-100" alt="Info Funding"/>
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
    <button onclick="location = '/financement'">Me financer</button>
</div>    


<?= $this->endSection() ?>


<?= $this->section('js') ?>

<?= $this->endSection() ?>
