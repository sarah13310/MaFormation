<?php

function ratings($number, $max = 10)
{
    if ($number > $max) {
        $number = $max;
    }
    if ($number < 0) {
        $number = 0;
    }
    $number = $number / ($max / 5);
    $max = $max / ($max / 5);
    $str = "";
    for ($i = 0; $i < $max; $i++) {
        $str .= ($i < $number) ? "<i class='bi bi-star-fill'></i>" : "<i class='bi bi-star'></i>";
    }
    return $str;
}

function dateFormat($date)
{
    $strDate="";
    $data=explode('-',$date);
    $strDate=$data[2]. " ".getMonth($data[1]). " " .$data[0];
    return$strDate;
}

function getMonth($month)
{
    $strMonth = "";
    switch (intVal($month)) {
        case 1:
            $strMonth = "Janvier";
            break;
        case 2:
            $strMonth = "Février";
            break;
        case 3:
            $strMonth = "Mars";
            break;
        case 4:
            $strMonth = "Avril";
            break;
        case 5:
            $strMonth = "Mai";
            break;
        case 6:
            $strMonth = "Juin";
            break;
        case 7:
            $strMonth = "Juillet";
            break;
        case 8:
            $strMonth = "Août";
            break;
        case 9:
            $strMonth = "Septembre";
            break;
        case 10:
            $strMonth = "Octobre";
            break;
        case 11:
            $strMonth = "Novembre";
            break;
        case 12:
            $strMonth = "Décembre";
            break;
    }
    return $strMonth;
}
