<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1 class="mb-3  text-center"><?= $title ?></h1>
<div class="container">
    <div>
        <select name="authors" id="authors">
            <option selected="selected">Tous</option>
            <?php foreach ($authors as $author) : ?>
                <option value="<?= $author['author'] ?>"><?= $author['author'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="row align-items-center justify-content-center">
        <?php foreach ($listmedias as $medias) : ?>
            <div class="card mb-2 flex-row w-75">
                <img src="<?= $medias['image_url'] ?>" class="mt-2 mb-2 card-img-left p-4" style="width: 33%;">
                <div class="card-body">
                    <h5 class="card-title"><?= $medias['name'] ?></h5>
                    <small><?= $p . " " . $medias['author'] ?></small>
                    <div class="mt-3">
                        <p class="card-description" style="height: 6rem;"><?= $medias['description'] ?></p>
                    </div>
                    <a class="btn mr-2 float-end" href="<?= $medias['url'] ?>" role="button"><?= $b ?></a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    let select_authors = document.getElementById('authors');
    select_authors.addEventListener('change', (event) => {        
        let sel =select_authors[select_authors.selectedIndex].value;    
        if (sel==="Tous"){
            allSelection();
        }  
        else {
            detectCard(sel);
        }  
    })

    function unAllSelection(){
        const cards= document.querySelectorAll(".card");
        for (let i=0; i< cards.length; i++){
                cards[i].classList.toggle('collapse');            
        }
    }
    function allSelection(){
        const cards= document.querySelectorAll(".card");
        for (let i=0; i< cards.length; i++){
                cards[i].classList.remove('collapse');            
        }
    }
    
    function detectCard(nom){
        unAllSelection();
        const cards= document.querySelectorAll(".card-body");
        for (let i=0; i< cards.length; i++){
            let author=cards[i].children[1].innerText;
            if(author.search(nom)!==-1){
                cards[i].parentElement.classList.remove('collapse');
                break;
            }
        }
    }


</script>
<?= $this->endSection() ?>