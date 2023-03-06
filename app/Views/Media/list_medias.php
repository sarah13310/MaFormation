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
    <div id='main' class="row align-items-center justify-content-center">
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    let buffer = null;

    const main = document.getElementById("main");
    fetch("<?= $media_json ?>")
        .then(res => res.json())
        .then(data => {
            buffer = data;
            for (let i = 0; i < data.length; i++) {
                cardinfo = data[i];
                CreateCard(main, cardinfo);
            }
        });

    function clearAllCard() {
        while (main.lastElementChild) {
            main.removeChild(main.lastElementChild);
        }
    }

    function trie( reverse=false) {
        clearAllCard();
        cards = buffer;
        if (reverse){
            cards.reverse();
        }
        else{
            cards.sort();
        }
        for (let i = 0; i < cards.length; i++) {
            cardinfo = cards[i];
            CreateCard(main, cardinfo);
        }
    }

    function selectCardByAuthor(cardName) {
        clearAllCard();
        cards = buffer;
        cards = cards.filter(item => {
            return (item.author == cardName);           
        });
        for (let i = 0; i < cards.length; i++) {
            cardinfo = cards[i];
            CreateCard(main, cardinfo);
        }
    }

    function showAll(){
        clearAllCard();
        cards = buffer;        
        for (let i = 0; i < cards.length; i++) {
            cardinfo = cards[i];
            CreateCard(main, cardinfo);
        }
    }

    let select_authors = document.getElementById('authors');
    select_authors.addEventListener('change', (event) => {
        let sel = select_authors[select_authors.selectedIndex].value;
        if (sel === "Tous") {
            showAll();
        } else {        
            selectCardByAuthor(sel);
        }
    })

    
    function CreateCard(parent, cardinfos) {
        let card = document.createElement("div");
        card.classList.add(["card"], ["mb-2"], ["flex-row"], ["w-75"]);
        let img = document.createElement("img");
        img.classList.add(["mt-2"], ["mb-2"], ["card-img-left"], ["p-4"]);
        img.style = "width:28%";
        img.src = cardinfos.image_url;
        let body = document.createElement("div");
        body.classList.add("card-body");
        let title = document.createElement("h5");
        title.classList.add("card-title");
        title.innerText = cardinfos.name;
        let author = document.createElement("small");
        author.innerText = cardinfos.author;
        let div = document.createElement("div");
        div.classList.add("mt-3");
        let description = document.createElement("p");
        description.innerText = cardinfos.description;
        description.classList.add('card-description');

        description.style = "height: 6rem";
        let button = document.createElement("a");
        button.href = cardinfos.url;
        button.classList.add(["btn"], ["mr-2"], ["float-end"]);
        button.setAttribute("role", "button");
        button.innerHTML = "Voir plus";
        //
        card.append(img);
        card.append(body);
        body.append(title);
        body.append(author);
        body.append(div);
        body.append(button);
        div.append(description);
        parent.appendChild(card);
    }

    /* setTimeout(() => {
         trie();
     }, 8000)*/
</script>
<?= $this->endSection() ?>