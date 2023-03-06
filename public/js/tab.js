/************* Gestion du tableau ************* */


class Tab extends HTMLElement {

    constructor(tag, title, createPagination) {
        this.createPagination = createPagination;
        this.title = title; // affiche le nombre d'éléments
        this.tbody = document.getElementById(tag);// corps de la table
        this.pagination = document.querySelector(".pagination ul"); //avec ul
        this.option = document.getElementById('option'); // selection du nombre d'articles affichés
        this.totalPages = 0; // nombre total de pages
        this.items_per_page = 10;// nombre d'articles affichés par page
        this.items_display = null;// page affichée avec un nombre d'éléments (de 10 à 25) par page 
    }
    /** Chargement du tableau */
    loadData(file_json, title = "particuliers") {
        fetch(file_json, {
            mode: "cors", credentials: 'same-origin', headers: {
                'Content-Type': 'application/json'
            },
        })
            .then(res => res.json())
            .then(data => {
                this.buffer = data;
                this.RefreshPage();
                this.totalPages = Math.ceil(this.buffer.length / this.items_per_page);;
                this.pagination.innerHTML = this.createPagination(this.totalPages, 1);
                this.NbTitle(buffer.length, title);
                this.DisplayNone();
            }).catch(err => {
                console.log(err);
            });
    }

    /** Affiches le nombre total d'éléménts  */
    NbTitle(count, title = "particuliers") {
        if (buffer !== null) {
            let h6 = document.getElementsByTagName("h6");
            if (count == 0) {
                h6[0].outerText = "";
            } else {
                if (count == 1) {
                    if (title[title.length - 1] === 's') {
                        title = title.substring(0, title.length - 1);
                    }
                }
                h6[0].innerHTML = `<span class="noselect badge-1"><i>${count} ${title}</i></span>`;
            }
        }
    }

    /** On ouvre le panneau associé au bouton [+]  */
    expand(item) {
        const tr = item.parentElement.parentElement;
        let collapse = tr.nextElementSibling.classList.toggle("collapse");
        if (collapse) {
            tr.style.borderBottom = "1px solid lightgray";
            item.classList.remove("bi-dash");
            item.classList.add("bi-plus");
        } else {
            tr.style.borderBottom = "1px solid transparent";
            item.classList.remove("bi-plus");
            item.classList.add("bi-dash");
        }
    }

    /** Recalcule les articles à afficher par page */
    RecalcPage(items, items_per_page = 10) {
        let start = items_per_page * (current_page - 1);
        let end = start + items_per_page;
        this.items_display = items.slice(start, end);
    }

    /** Rafraîchit la page */
    RefreshPage() {
        //this.ApplyTheme();
        this.RecalcPage(this.buffer, this.items_per_page);
        while (this.tbody.lastElementChild) {
            this.tbody.removeChild(tbody.lastElementChild);
        }
        for (let i = 0; i < this.items_display.length; i++) {
            Row(tbody, this.items_display[i], i + 1);
        }
        this.ApplyTheme();
    }

    /** Gestion des themes */
    getTheme(type, css = "button") {
        switch (type) {
            case 9:
            case 11:
                css += "_user";
                break;
            case 7:
                css += "_former";
                break;
            case 5:
                css += "_admin";
                break;
            case 3:
                css += "_superadmin";
                break;
            default:
                css += "_default";
                break;
        }
        return css;
    }

    ApplyTheme(type) {
        const buttons = document.querySelectorAll(".btn-primary");
        buttons.forEach((button) => {
            button.classList.replace("btn-primary", getTheme(type));
        })
    }

    setDisplayNone(displaynone) {
        this.Displaynone = displaynone;
    }

    setRow(row) {
        this.Row = row;
    }

    setItemPerPage(items_per_page) {
        this.items_per_page = items_per_page;
        this.RefreshPage();
    }

}


