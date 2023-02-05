<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        div.logo {
            height: 200px;
            width: 155px;
            display: inline-block;
            opacity: 0.08;
            position: absolute;
            top: 2rem;
            left: 50%;
            margin-left: -73px;
        }

        body {
            height: 100%;
            background: #fafafa;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #777;
            font-weight: 300;
        }

        h1 {
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 2.6rem;
            margin-top: 0;
            margin-bottom: 0;
            color: #5a98f3 !important;
        }

        .wrap {
            max-width: 1024px;
            margin: 5rem auto;
            padding: 2rem;
            background: #fff;
            text-align: center;
            border: 1px solid #efefef;
            border-radius: 0.5rem;
            position: relative;
        }
    
       
        p {
            margin-top: 1.5rem;
        }

        

        a:active,
        a:link,
        a:visited {
            color: #0dcaf0;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="text-center text-secondary">

            <h1 class="mb-4 display-1 text-info2 font-title font-weight-bold">Lettre d'informations</h1>
            <h3 class="mb-3 display-4 font-title">“ Votre incription est prise en compte ”</h3>
            <div>
                Vous êtes désormais inscrit(e) à la lettre d'informations du site <i>“Maformation.com”.</i>
                <br>Vous recevez par mail de nouvelles actualités sur nos formations.
            </div>
            <div>
                Vous pouvez revenir à <a href="/">la page d'accueil</a>.
            </div>

        </div>
    </div>
</body>

</html>