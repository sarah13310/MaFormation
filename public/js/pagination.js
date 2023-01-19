// on récupère les éléments de table
var table = document.getElementById("mytable"),
// le nombre de lignes par page
n = 10,
// le nombre de lignes du tableau
rowCount = table.rows.length,
// on récupère le nom du tag de la première cellule (dans la première ligne)
firstRow = table.rows[0].firstElementChild.tagName,
// le booléen var pour vérifier si la table a une ligne d'en-tête
hasHead = (firstRow === "TH"),
// un tableau pour contenir chaque ligne
tr = [],
// une boucle pour commencer à compter à partir de la ligne[1] (2e ligne) si la première ligne a une balise d'en-tête
i, ii, j = (hasHead) ? 1 : 0,
// on contient la première ligne si elle a un (<TH>) ou rien si (<TD>)
th = (hasHead ? table.rows[(0)].outerHTML : "");
// on compte le nombre de pages
var pageCount = Math.ceil(rowCount / n);
// si on n'a qu'une page, alors on n'aura rien à faire..
if (pageCount > 1) {
// on attribue à chaque ligne outHTML (tag name et innerHTML) au tableau
for (i = j, ii = 0; i < rowCount; i++, ii++)
    tr[ii] = table.rows[i].outerHTML;
// on crée un bloc div pour contenir les boutons
table.insertAdjacentHTML("afterend", "<div id='buttons'></div>");
// la page par défaut est la première
sort(1);
}

// ($p) est le numéro de page sélectionné. il sera généré lorsqu'un utilisateur cliquera sur un bouton
function sort(p) {
/* on crée ($rows) une variable pour contenir le groupe de lignes
  à afficher sur la page sélectionnée,
  ($s) le point de départ (la première ligne de chaque page)
 */
var rows = th,
    s = ((n * p) - n);
for (i = s; i < (s + n) && i < tr.length; i++)
    rows += tr[i];

// maintenant le tableau a un groupe de lignes traitées
table.innerHTML = rows;
// on crée les boutons de pagination
document.getElementById("buttons").innerHTML = pageButtons(pageCount, p);
// le css
document.getElementById("id" + p).setAttribute("class", "active");
}

// ($pCount) : nombre de pages,($cur) : page courante
function pageButtons(pCount, cur) {
/* cette variable désactivera le bouton "Précédent" sur la 1ère page
   et bouton "Suivant" sur la dernière */
var prevDis = (cur == 1) ? "disabled" : "",
    nextDis = (cur == pCount) ? "disabled" : "",
    /* ce ($buttons) contiendra chaque bouton nécessaire
      il créera chaque bouton et définira l'attribut onclick
      à la fonction "sort" avec un numéro spécial ($p)
     */
    buttons = "<input type='button' class='btn btn-outline-primary' value='<< Précédent' onclick='sort(" + (cur - 1) + ")' " + prevDis + ">";
for (i = 1; i <= pCount; i++)
    buttons += "<input type='button' class='btn btn-outline-primary' id='id" + i + "'value='" + i + "' onclick='sort(" + i + ")'> ";
buttons += "<input type='button' class='btn btn-outline-primary' value='Suivant >>' onclick='sort(" + (cur + 1) + ")' " + nextDis + ">";
return buttons;
}