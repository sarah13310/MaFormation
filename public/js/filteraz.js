/** WebComponent
 *  FilterAlpha
 *  créé le 30/03/2023
 *  Gestion des noms
 *  dans un système de filtre alphabétique
 */

class FilterAlpha extends HTMLElement {
  // déclaration des propriétés
  static get observedAttributes() {
    return ["value"];
  }

  constructor(value = 0, choice = ["---", "A-Z", "Z-A"]) {
    super(); // constructeur parent indipensable
    this.order = 0;
    this.choice = choice;
    this.index = 0;
  }

  connectedCallback() {
    this.container = document.createElement("div");
    this.buttonAlpha = document.createElement("div");
    this.selectFilter = document.createElement("select");
    this.container.append(this.buttonAlpha);
    this.container.append(this.selectFilter);
    this.append(this.container);
    this.buttonAlpha.innerHTML =
      '<i style="font-size: 1.4rem;" class="bi bi-x"></i>';
    for (let i = 0; i < this.choice.length; i++) {
      this.selectFilter.innerHTML += `<option ${this.choice[i]}>${this.choice[i]}</option>`;
    }
    this.container.style =
      "display:flex;align-items:center;gap:4px;padding:2px 6px;margin:8px;border:1px solid #e2e0e0;border-radius:4px";
    this.selectFilter.style = "padding:3px 8px; ";
    this.selectFilter.addEventListener("change", (e) => {
      e.preventDefault();
      this.index = Number(e.target.value);
      switch (e.target.value) {
        case this.choice[0]:
          this.index = 0;
          break;
        case this.choice[1]:
          this.index = 1;
          break;
        case this.choice[2]:
          this.index = 2;
          break;
      }
      this.updateButton();
      this.dispatchEvent(
        new CustomEvent("onSort", {
          bubbles: true,
          detail: { value: e.target.value },
        })
      );
    });
    this.buttonAlpha.addEventListener("click", (e) => {
      this.selectFilter.value = "--";
      this.index++;
      if (this.index > 2) this.index = 0;
      this.updateButton();
      this.selectFilter.value = this.choice[this.index];
      this.dispatchEvent(
        new CustomEvent("onSort", {
          bubbles: true,
          detail: { value: this.index },
        })
      );
    });
  }

  updateButton() {
    switch (this.index) {
      case 0:
        this.buttonAlpha.innerHTML =
          '<i style="font-size: 1.4rem;" class="bi bi-x"></i>';
        break;
      case 1:
        this.buttonAlpha.innerHTML =
          '<i style="font-size: 1.4rem;" class="bi bi-sort-alpha-down"></i>';
        break;
      case 2:
        this.buttonAlpha.innerHTML =
          '<i style="font-size: 1.4rem;" class="bi bi-sort-alpha-down-alt"></i>';
        break;
    }
  }

  get value() {
    return this.selectFilter.value;
  }
  // Gestion des propriétés
  attributeChangedCallback(name, oldvalue, newvalue) {
    if (name === "value" && oldvalue !== newvalue) {
      this.selectFilter.value = newvalue;
    }
  }
}

customElements.define("filter-alpha", FilterAlpha); // tag personnalisé <filter-date>
