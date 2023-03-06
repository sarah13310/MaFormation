class Paginate extends HTMLElement {
    static get observedAttributes() { return ['page']; }

    constructor(tag = 'tbody', buffer = null) {
        this.step_page = 1; // 
        this.current_page = 1; // page courage
        this.items_per_page = 10; // nb articles par pages
        //
        this.table = document.getElementById('table'); // la table
        this.items_display = null; // articles affichés par page
        this.totalPages = 20; // nb d'articles 
        this.buffer = buffer;
        if (this.buffer) {
            this.totalPages = Math.ceil(this.buffer.length / this.items_per_page);
        }
        //this.tbody = document.getElementById(tag);// corps de la table
        this.pagination = document.querySelector(".pagination ul"); //avec ul
        //this.option = document.getElementById('option'); // selection du nombre d'articles affichés
    }

    setBuffer(buffer) {
        this.buffer = buffer;
    }

    setItemsPerPage(items_per_page) {
        this.items_per_page = items_per_page;
        if (this.buffer)
            this.totalPages = Math.ceil(this.buffer.length / this.items_per_page);
        this.createPagination(this.current_page);
    }

    setPage(page) {
        this.current_page = page;
        this.createPagination(this.current_page);
    }

    attributeChangedCallback(name, oldvalue, newvalue) {
        if (name === "page" && oldvalue !== newvalue) {
            this.setPage(parseInt(newvalue));
        }
    }

    createPagination(page = 10) {
        let liTag = '';
        let active;
        let beforePage = page - 1;
        let afterPage = page + 1;
        current_page = page;
        this.RefreshPage();

        if (this.totalPages == 1) {
            this.pagination.remove();
        }

        if (page >= 1) { //affiche le bouton prochain
            if (page == 1) {
                liTag += `<li class="me-2 btn prev" ><span><i class="'bi bi-chevron-left"></i> Préc</span></li>`;
            }
            else {
                liTag += `<li class="me-2 btn prev" onclick="createPagination(totalPages, ${page - 1})"><span><i class="'bi bi-chevron-left"></i> Préc</span></li>`;
            }
        }

        if (page > 2) { //if page est moins que 2 alors on ajoute 1 après le bouton précédent
            liTag += `<li class="first numb" onclick="createPagination(totalPages, 1)"><span>1</span></li>`;
            if (page > 3) { //if page est plus grand que 3 alors on ajoute (...) après la page
                liTag += `<li class="dots"><span>...</span></li>`;
            }
        }
        // combien de pages à montrer après la courante
        if (page == this.totalPages) {
            beforePage = beforePage - 2;
        } else if (page == this.totalPages - 1) {
            beforePage = beforePage - 1;
        }
        // combien de pages à montrer après la courante
        if (page == 1) {
            afterPage = afterPage + 2;
        } else if (page == 2) {
            afterPage = afterPage + 1;
        }

        for (let i = beforePage; i <= afterPage; i++) {
            if (i > this.totalPages) { //si i est plus grand que totalPage alors on continue
                continue;
            }
            if (i == 0) { //si  i vaut 0 alors on additionne 1 à i 
                i = i + 1;
            }
            if (page == i) { //si page est égale à i alors on assigne active 
                active = "active";
            } else { //sinon on laisse active à vide
                active = ""; 
            }
            liTag += `<li class="numb ${active}" onclick="createPagination(totalPages, ${i})"><span>${i}</span></li>`;
        }

        if (page < this.totalPages - 1) { //si page est moins que totalPage value by -1 then show the last li or page
            if (page < this.totalPages - 2) { //if page  est moins que totalPage-2 alors on ajoute (...) avant la dernière page
                liTag += `<li class="dots"><span>...</span></li>`;
            }
            liTag += `<li class="last numb" onclick="createPagination(totalPages, ${totalPages})"><span>${totalPages}</span></li>`;
        }

        if (page <= this.totalPages) { //on affiche le bouton prochain

            if (page == this.totalPages) {
                liTag += `<li class="ms-2 btn next"><span>Suiv <i class="'bi bi-chevron-right"></i></span></li>`;
            }
            else {
                liTag += `<li class="ms-2 btn next" onclick="createPagination(totalPages, ${page + 1})"><span>Suiv <i class="'bi bi-chevron-right"></i></span></li>`;
            }
        }

        this.dispatchEvent(new CustomEvent('change',
            {
                bubbles: true, detail: { current: this.current_page }
            }));
        this.pagination.innerHTML = liTag; //ajoute tag li à l'intérieur ul tag
        return liTag; //retourne le tag li 
    }

    setRefreshPage(func) {
        this.RefreshPage = func;
    }

}