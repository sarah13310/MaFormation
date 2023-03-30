<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<h1 class="mt-2 mb-3"> <?= $title ?></h1>
<div class="container">
    <div class="row">
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
            <label>Auteurs : </label>
            <select name="distributor" id="distributor">
                <option selected="selected">Tous</option>
                <?php foreach ($distributor as $d) : ?>
                    <option value="<?= $d['name'] . " " . $d['firstname'] ?>"><?= $d['name'] . " " . $d['firstname'] ?></option>
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
        <div class="col" id="filterdate">
        </div>
    </div>
    <div id='main' class="row align-items-center justify-content-center">
        <form action="/publishes/list/details" method="post" name="form_detail">
            <input type="hidden" name="id_publication" value="">

        </form>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/filter.js"></script>
<script src="<?= base_url() ?>/js/filterdate.js"></script>
<script src="<?= base_url() ?>/js/date.js"></script>
<script>
    loadData("<?= $publish_json ?>");

    let dateselect = document.getElementById('filterdate');
    let filterdate = new FilterDate(new Date());

    dateselect.append(filterdate);

    let d = filterdate.day;
    let m = filterdate.month;
    let y = filterdate.year;

    let select_distributor = document.getElementById('distributor');

    let select_tag = document.getElementById('tag');

    let select_az = document.getElementById('az');

    let sel_distributor = "Tous";

    let sel_tag = "Tous";

    alpha_prop = "subject";

    let selectors = {
        "author": null,
        "tag": select_tag,
        "status": null,
        "distributor": select_distributor,
        "former": null,
        "company": null,
        "city": null,
        "cp": null,
        "alpha": select_az,
        "day": d,
        "month": m,
        "year": y
    };

    filterdate.addEventListener('onDate', (event) => {
        d = event.detail.jour;
        m = event.detail.mois;
        y = event.detail.annee;

        filtre(selectors);

    });



    select_distributor.addEventListener('change', (event) => {
        sel_distributor = select_distributor[select_distributor.selectedIndex].value;

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
        let card = document.createElement("div");
        card.classList.add(["card"], ["mb-2"], ["flex-row"]);

        let img = document.createElement("img");
        img.classList.add(["mt-2"], ["mb-2"], ["card-img-left"], ["p-4"]);
        img.style = "width:33%";
        img.src = items.image_url;

        let body = document.createElement("div");
        body.classList.add(["card-body"], ["d-flex"], ["flex-column"]);

        let title = document.createElement("h5");
        title.classList.add("card-title");
        title.innerText = items.subject;

        let distributor = document.createElement("small");
        distributor.innerText = items.user[0].name + " " + items.user[0].firstname + " le " + dateTimeFormat(items.datetime);

        let div = document.createElement("div");
        div.classList.add("mt-3");

        let description = document.createElement("p");
        description.innerText = items.description;
        description.classList.add('card-description');
        description.style = "height: 6rem";



        let button = document.createElement("a");
        button.classList.add(["btn"], ["mr-2"], ["float-end"], ["mt-auto"], ["btn-primary"], ["align-self-end"]);
        button.setAttribute("role", "button");
        button.innerText = "Voir plus";

        button.addEventListener("click", () => {
            form_detail.id_publication.value = items.id_publication;
            form_detail.submit();
        })
        //
        card.append(img);
        card.append(body);
        body.append(title);
        body.append(distributor);
        body.append(div);
        body.append(button);
        div.append(description);
        parent.appendChild(card);
    }
</script>

<?= $this->endSection() ?>