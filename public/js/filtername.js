/** WebComponent
 *  FilterName
 *  créé le 30/03/2023
 *  Gestion des noms
 *  dans un système de filtre alphabétique
*/

class FilterName extends HTMLElement {
    // déclaration des propriétés
    static get observedAttributes() {
        return ['value', 'text'];
    }

    constructor(text = "Titre", choice = ["Tous", "option1", "option2", "option3", "option4"]) {
        super();// constructeur parent indipensable
        this.text = text;
        this.choice = choice;
    }

    setContent(_content) {
        this.selectFilter.innerHTML = ``;
        this.choice = _content;
        for (let i = 0; i < this.choice.length; i++) {
            this.selectFilter.innerHTML += `<option value="${this.choice[i]}">${this.choice[i]}</option>`;
        }
    }

    connectedCallback() {
        this.container = document.createElement("div");
        this.buttonFilter = document.createElement('div');
        this.textFilter = document.createElement('div');
        this.selectFilter = document.createElement('select');
        this.container.append(this.textFilter);
        this.container.append(this.selectFilter);
        this.container.append(this.buttonFilter);
        this.append(this.container);
        this.textFilter.innerHTML = `<b>${this.text}:&nbsp;</b>`;
        this.buttonFilter.innerHTML = "<i style=\"font-size: 1.4rem;\" class=\"bi bi-x\"></i>";
        this.setContent(this.choice);
        this.container.style = "display:flex;align-items:center;gap:4px;padding:2px 6px;margin:8px;border:1px solid #e2e0e0;border-radius:4px";
        this.selectFilter.style = "padding:3px 8px; ";
        this.selectFilter.addEventListener("change", (e) => {
            e.preventDefault();
            this.dispatchEvent(new CustomEvent('onSort',
                {
                    bubbles: true, detail: { value: e.target.value }
                }));
        });
        this.buttonFilter.addEventListener("click", (e) => {

            this.selectFilter.value = this.choice[0];
            this.dispatchEvent(new CustomEvent('onSort',
                {
                    bubbles: true, detail: { value: this.selectFilter.value }
                }));
        })
    }

    get value() {
        return this.selectFilter.value;
    }

    // Gestion des propriétés
    attributeChangedCallback(name, oldvalue, newvalue) {
        if (name === "value" && oldvalue !== newvalue) {
            this.selectFilter.value = newvalue;
        }
        if (name === "text" && oldvalue !== newvalue) {
            this.text = newvalue;
            if (this.textFilter == null) return;
            this.textFilter.innerHTML = `<b>${this.text}:&nbsp;</b>`;
        }
    }
}

customElements.define("filter-name", FilterName);// tag personnalisé <filter-date>