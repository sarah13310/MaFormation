<?= $this->extend('layouts/profil') ?>
<?= $this->section('content') ?>
<h1 class="mb-2"><i class="bi bi-grid"></i>&nbsp;&nbsp;<?= $title ?></h1>
<table id="table" class="table">
    <thead class="<?= $headerColor ?>">
        <tr>
            <th scope="col">Aperçu</th>
            <th scope="col">Sujet</th>
            <th scope="col">Créé le</th>
        </tr>
    </thead>
    <?php $i = 0;
    foreach ($listarticles as $article) : ?>
        <tr>
            <td>
                <form action="/article/preview" method="post">
                    <input type="hidden" name="id_article" value="<?= $article['id_article'] ?>">
                    <button type="submit" class="btn mr-2 float-end"><i class="bi bi-eye"></i></button>
                </form>
            </td>
            <td><?= $article['subject'] ?></td>
            <td><?= dateTimeFormat($article['datetime']) ?></td>
        </tr>
    <?php $i++;
    endforeach ?>

</table>
<div id="pagination"></div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<scrip src="./js/paginate">
    </script>
    <script>
        let table = document.getElementById("table");
        let buffer = null;

        fetch("<?= $article_json ?>")
            .then(res => res.json())
            .then(data => {
                buffer = data;
                for (let i = 0; i < data.length; i++) {
                    let info = data[i];
                    Row(main, info)
                }
            });

        function Row(parent,data) {
            let tr = document.createElement("tr");
            let td1=document.createElement("td");
            td1.className.add(btn);
            td1.innerHTML='<i class="bi bi-eye">';
            
            let td2=document.createElement("td");
            td2.innerText=data.subject;
            let td3=document.createElement("td");
            td3.innerText=data.dateTime;
            table.append(tr);
            tr.append(td1);

            tr.append(td2);
            tr.append(td3);

        }
    </script>
    <?= $this->endSection() ?>