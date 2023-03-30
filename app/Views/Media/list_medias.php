<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<h1 class="mb-3  text-center"><?= $title ?></h1>
<div class="container">
    <div class="row w-75">
        <div class="col">
            <label>Auteurs : </label>
            <select name="authors" id="authors">
                <option selected="selected">Tous</option>
                <?php foreach ($authors as $author) : ?>
                    <option value="<?= $author['author'] ?>"><?= $author['author'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col">
            <label>Catégories : </label>
            <select name="tag" id="tag">
                <option selected="selected">Tous</option>
                <?php foreach ($tag as $t) : ?>
                    <option value="<?= $t['name'] ?>"><?= $t['name'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col">
            <label>Ordre alphabétique : </label>
            <select name="az" id="az">
                <option selected="selected">--</option>
                <option>A-Z</option>
                <option>Z-A</option>
            </select>
        </div>
    </div>
    <div id='main' class="row align-items-center justify-content-center">
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/filter.js"></script>
<script>


    loadData("<?= $media_json ?>");

    let select_authors = document.getElementById('authors');

    let select_tag = document.getElementById('tag');

    let select_az = document.getElementById('az');

    let sel_author = "Tous";

    let sel_tag = "Tous";


    let selectors = {
        "author": select_authors,
        "tag": select_tag,
        "status": null,
        "distributor": null,
        "former": null,
        "company": null,
        "city": null,
        "cp": null,
        "alpha": select_az,
        "day": null,
        "month": null,
        "year": null
    };

    select_authors.addEventListener('change', (event) => {
        sel_author = select_authors[select_authors.selectedIndex].value;

        filtre(selectors);

    })

    select_tag.addEventListener('change', (event) => {
        sel_tag = select_tag[select_tag.selectedIndex].value;

        filtre(selectors);

    })


    select_az.addEventListener('change', (event) => {
        let sel = select_az[select_az.selectedIndex].value;
        if (sel === "--") {
            showAll();
            return;
        }
        filtre(selectors);
    })


    function CreateItem(parent, items) {
        let item = document.createElement("div");
        item.classList.add(["card"], ["mb-2"], ["flex-row"], ["w-75"]);
        let img = document.createElement("img");
        img.classList.add(["mt-2"], ["mb-2"], ["card-img-left"], ["p-4"]);
        img.style = "width:28%";
        img.src = items.image_url;
        let body = document.createElement("div");
        body.classList.add("card-body");
        let title = document.createElement("h5");
        title.classList.add("card-title");
        title.innerText = items.name;
        let author = document.createElement("small");
        author.innerText = items.author;
        let div = document.createElement("div");
        div.classList.add("mt-3");
        let description = document.createElement("p");
        description.innerText = items.description;
        description.classList.add('card-description');

        description.style = "height: 6rem";
        let button = document.createElement("a");
        button.href = items.url;
        button.classList.add(["btn"], ["mr-2"], ["float-end"]);
        button.setAttribute("role", "button");
        button.innerHTML = "Voir plus";
        //
        item.append(img);
        item.append(body);
        body.append(title);
        body.append(author);
        body.append(div);
        body.append(button);
        div.append(description);
        parent.appendChild(item);
    }

    /* setTimeout(() => {
         trie();
     }, 8000)*/
</script>
<?= $this->endSection() ?>