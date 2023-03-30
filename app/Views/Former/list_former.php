<?= $this->extend('layouts/default') ?>

<?= $this->section('header') ?>

<style>
    @media (max-width:576px){
        .card{
            height: 280px!important;
            width:200px!important;
        };
    }
    @media (max-width:576px){
        img{
            height: 150px!important;
        };
    }

    @media (max-width:576px){
        .card-title{
            font-size:1rem!important;
        };
    }

    @media (max-width:576px){
        .card-subtitle{
            font-size:0.8rem!important;
        };
    }

    @media (max-width:576px){
        .btn{
            font-size:0.95rem!important;
            margin-bottom: 4px;
        };
    }

</style>

<?= $this->endSection(); ?>
<?= $this->section('content') ?>
<h1 class="text-center mb-2"><?= $title ?></h1>

<div class="container-fluid align-items-center overflow-auto">
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
            <select name="former" id="former">
                <option selected="selected">Tous</option>
                <?php foreach ($former as $d) : ?>
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
    <div id="main" class="mt-3 row justify-content-start">
        <form action="/former/list/cv" method="post" name="form_detail">
            <input type="hidden" name="id_user" value="">
            <input type="hidden" name="mail" value="">
        </form>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="<?= base_url() ?>/js/filter.js"></script>
<script src="<?= base_url() ?>/js/filterdate.js"></script>
<script src="<?= base_url() ?>/js/date.js"></script>
<script>
    loadData("<?= $former_json ?>");

    let dateselect = document.getElementById('filterdate');
    let filterdate = new FilterDate(new Date());

    dateselect.append(filterdate);

    let d = filterdate.day;
    let m = filterdate.month;
    let y = filterdate.year;

    let select_former = document.getElementById('former');

    let select_tag = document.getElementById('tag');

    let select_az = document.getElementById('az');

    let sel_former = "Tous";

    let sel_tag = "Tous";

    let selectors = {
        "author": null,
        "tag": select_tag,
        "status": null,
        "distributor": null,
        "former": select_former,
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



    select_former.addEventListener('change', (event) => {
        sel_former = select_former[select_former.selectedIndex].value;

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

        let col = document.createElement("div");
        col.classList.add(["col-12"], ["col-sm-4"], ["col-md-5"], ["col-lg-5"], ["mb-4"]);

        let card = document.createElement("div");
        card.classList.add(["card"], ["mb-2"], ["flex-col"], ["mx-auto"]);
        card.style = "height:500px; width:400px;";
    

        let card_img = document.createElement("div");
        card_img.classList = "card-img card-img-center";

        let img = document.createElement("img");
        img.classList.add(["p-4"]);
        img.style = "height:300px";
        img.src = items.image_url;

        let body = document.createElement("div");
        body.classList.add(["card-body"], ["d-flex"], ["flex-column"]);

        let former = document.createElement("h5");
        former.classList.add("card-title");
        former.innerText = items.name + " " + items.firstname;

        let certificate = document.createElement("h6");
        certificate.classList.add(["card-subtitle"], ["mb-2"], ["text-muted"]);
        certificate.style = "height:3rem";
        let sTag = "";
        items.skills.forEach(
            item => {
                sTag += item.name + " ";
            }
        )
        certificate.innerText = sTag;


        let button = document.createElement("a");
        button.classList.add(["btn"], ["mr-2"], ["mt-auto"], ["align-self-end"]);
        button.setAttribute("role", "button");
        button.innerText = "Voir plus";

        button.addEventListener("click", () => {
            form_detail.id_user.value = items.id_user;
            form_detail.mail.value = items.mail;
            form_detail.submit();
        })
        //

        col.append(card)
        card.append(card_img);
        card_img.append(img);
        card.append(body);
        body.append(former);
        body.append(certificate);
        body.append(button);
        parent.appendChild(col);
    }
</script>

<?= $this->endSection() ?>