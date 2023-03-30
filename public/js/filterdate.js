/** WebComponent
 *  FilterDate
 *  créé le 24/02/2023
 *  rev: le 30/03/2023
 *  Gestion des dates avec une utilisation
 *  dans un système de filtre composite [ jour ] [ mois ] [ année ]
 */

class FilterDate extends HTMLElement {
    // déclaration des propriétés
    static get observedAttributes() {
        return ['day', 'month', "year"];
    }

    constructor(date = new Date(), years = ["----", 2022, 2023, 2024]) {
        super();// constructeur parent indipensable
        this.date = date;
        this.years = years;
    }

    connectedCallback() {
        this.container = document.createElement("div");

        this.buttonDate = document.createElement('div');
        this.selectDay = document.createElement('select');
        this.selectMonth = document.createElement('select');
        this.selectYear = document.createElement('select');

        this.container.style = "display:flex;align-items:center;gap:4px;padding:2px 6px;margin:8px;border:1px solid #e2e0e0;border-radius:4px";
        this.selectDay.style = "padding:3px 8px; ";
        this.selectMonth.style = "margin-right:2px;padding:3px 8px;";
        this.selectYear.style = "padding:3px 8px;";

        this.container.append(this.buttonDate);
        this.container.append(this.selectDay);
        this.container.append(this.selectMonth);
        this.container.append(this.selectYear);

        this.append(this.container);

        this.initEvents();
        this.day = this.date.getDate();
        this.month = this.date.getMonth();
        this.year = this.date.getFullYear();

        this.renderDay();
        this.renderMonth();
        this.renderYear();
        this.renderDateButton();
        this.selectDay.value = parseInt(this.date.getDate());
        this.selectMonth.value = parseInt(this.date.getMonth());
        this.selectYear.value = parseInt(this.date.getFullYear());

    }

    updateDate() {
        if (isNaN(this.day)||isNaN(this.month)||isNaN(this.year)) return;
        this.renderDay();
        if (this.day > this.nbDays)
            this.day = this.nbDays;

        this.dispatchEvent(new CustomEvent('onDate',
            {
                bubbles: true, detail: {jour: this.day, mois: (this.month + 1), annee: this.year}
            }))

        this.selectDay.value = this.day;
        //this.selectMonth.value = this.month;
    }

    /** init des évènements */
    initEvents() {

        this.selectDay.addEventListener("change", (e) => {
            e.preventDefault();
            if (isNaN(e.target.value)){
                this.dispatchEvent(new Event('onNoDate'));
                this.day="--";
                return;
            }
            this.day = parseInt(e.target.value);
            this.updateDate();
        })
        this.selectMonth.addEventListener("change", (e) => {
            e.preventDefault();
            if (isNaN(e.target.value)){
                this.dispatchEvent(new Event('onNoDate'));
                this.month="--";
                return;
            }
            this.month = parseInt(e.target.value);
            this.updateDate();
        })
        this.selectYear.addEventListener("change", (e) => {
            e.preventDefault();
            if (isNaN(e.target.value)){
                this.dispatchEvent(new Event('onNoDate'));
                this.year="----";
                return;
            }
            this.year = parseInt(e.target.value);
            this.updateDate();
        })
    }

    renderDateButton() {
        this.buttonDate.innerHTML = "<i style=\"font-size: 1.4rem;\" class=\"fa-sm bi bi-calendar-x\"></i>";
        this.buttonDate.addEventListener("click",
            (e) => {
                this.selectDay.value = "0";
                this.selectMonth.value = "0";
                this.selectYear.value = "----";
                this.day="--";
                this.month="--";
                this.year="----";
            }
        )
    }

    /* affichage des jours */
    renderDay() {
        this.clearDays();
        let sTag = `<option value="0">--</option>`;
        this.nbDays = new Date(this.year, this.month + 1, -1).getDate() + 1;
        for (let i = 1; i <= this.nbDays; i++) {
            //let option = document.createElement("option");
            //option.innerText = i.toString();
            //option.setAttribute("value", i.toString());
            // this.selectDay.append(option);
            sTag += `<option value="${i.toString()}">${i.toString()}</option>`;
        }
        this.selectDay.innerHTML = sTag;
    }

    /** suppression des jours */
    clearDays() {
        while (this.selectDay.lastElementChild)
            this.selectDay.removeChild(this.selectDay.lastElementChild);
    }

    /** affichage des mois */
    renderMonth() {
        let sTag = `<option value="0">--</option>`;
        for (let i = 1; i < 13; i++) {
            //let option = document.createElement("option");
            const mydate = new Date(Date.UTC(this.date.getFullYear(), i - 1, 1));
            const monthname = mydate.toLocaleString('default', {month: 'long'});
            //option.innerText = monthname;
            //option.setAttribute("value", i.toString());
            //this.selectMonth.append(option);
            sTag += `<option value="${(i - 1).toString()}">${monthname}</option>`;
        }
        this.selectMonth.innerHTML = sTag;
    }

    /** affichge des années */
    renderYear() {
        for (let i = 0; i < this.years.length; i++) {
            let option = document.createElement("option");
            option.innerText = this.years[i];
            option.setAttribute("value", this.years[i].toString());
            this.selectYear.append(option);
        }
    }

    // Gestion des propriétés
    attributeChangedCallback(name, oldvalue, newvalue) {
        if (name === "day" && oldvalue !== newvalue) {
            this.selectDay.value = parseInt(newvalue);
        }
        if (name === "month" && oldvalue !== newvalue) {
            this.selectMonth.value = parseInt(newvalue);
        }
        if (name === "year" && oldvalue !== newvalue) {
            this.selectYear.value = parseInt(newvalue);
        }
    }
}

customElements.define("filter-date", FilterDate);// tag personnalisé <filter-date>