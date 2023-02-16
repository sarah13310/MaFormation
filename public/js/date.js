function dateTimeFormat(date) {
    
    let s = "Aucune date renseignée";
    if (date != null || date.length>=12) {
            let data = date.split(' ');
        let hm = data[1].split(':');
        let mydate = data[0].split('-');
        if (mydate[2]=="00"){
            mydate[2]="01"
        }
        if (mydate[0]=="0000"){
            mydate[0]="1970"
        }
        s = "Le " + mydate[2] + " " + getMonth(mydate[1]) + " " + mydate[0] + " à " + hm[0] + "h" + hm[1];
    }
    return s;
}

function dateFormat(date) {
    
    let s = "Aucune date renseignée";
    if (date !== null ||  date.length>=12) {
        let mydate = date.split('-');
        s = mydate[2] + " " + getMonth(mydate[1]) + " " + mydate[0];
    }
    return s;
}

// Le mois en format texte
function getMonth(month)
{
    strMonth = "";
    switch (parseInt(month)) {
        case 1:
            strMonth = "Janvier";
            break;
        case 2:
            strMonth = "Février";
            break;
        case 3:
            strMonth = "Mars";
            break;
        case 4:
            strMonth = "Avril";
            break;
        case 5:
            strMonth = "Mai";
            break;
        case 6:
            strMonth = "Juin";
            break;
        case 7:
            strMonth = "Juillet";
            break;
        case 8:
            strMonth = "Août";
            break;
        case 9:
            strMonth = "Septembre";
            break;
        case 10:
            strMonth = "Octobre";
            break;
        case 11:
            strMonth = "Novembre";
            break;
        case 12:
            strMonth = "Décembre";
            break;
        default:
            strMonth = "Janvier";
            break;

    }
    return strMonth;
}