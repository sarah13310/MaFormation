//
class DropState extends HTMLElement {

    static get observedAttributes() { return ['state']; }

    constructor(id = -1) {
        super();
        this.identifiant = parseInt(id);
        //
        this.index = 0;
        this.drop = document.createElement("div");
        this.span = document.createElement("span");
        this.menu = document.createElement("div");
        this.items = ["...", "validé", "en cours", "refusé"];

        this.ul = document.createElement("ul");
        this.ul.classList = "ul-menu";
        this.ul.style = "list-style:none;";
        //this.menu.classList = "collapse";
        this.drop.classList = "dropstate";
        this.span.innerText = "...";

        for (let i = 1; i < this.items.length; i++) {
            let li = document.createElement("li");
            li.classList = "li-menu";
            li.innerText = this.items[i];
            li.addEventListener("click", () => {
                this.span.innerText = "...";
                if (li.innerText == "en cours") {
                    this.index = 2;
                }
                if (li.innerText == "validé") {
                    this.index = 1;
                }
                if (li.innerText == "refusé") {
                    this.index = 3;
                }
                this.setState(this.index);
                this.menu.classList.toggle("collapse");
            });
            this.ul.append(li);
        }
        //
        this.menu.append(this.ul);
        this.drop.append(this.span);
        this.drop.append(this.menu);
        this.drop.addEventListener("click", () => {
            this.menu.classList.toggle("collapse");
        });
        this.append(this.drop);
    }

    setState(index) {
        this.index = parseInt(index);
        this.dispatchEvent(new CustomEvent('state',
            {
                bubbles: true, detail: { value: this.index, identifiant: this.identifiant }
            }));
        if (this.index === 1) {
            this.span.classList.remove("state-blue");
            this.span.classList.add("state-green");
            this.span.classList.remove("state-red");
        }

        if (this.index === 2) {
            this.span.classList.add("state-blue");
            this.span.classList.remove("state-green");
            this.span.classList.remove("state-red");
        }

        if (this.index === 3) {
            this.span.classList.remove("state-blue");
            this.span.classList.remove("state-green");
            this.span.classList.add("state-red");
        }
        this.span.innerText = this.items[this.index];
        this.menu.classList.toggle("collapse");
    }

    attributeChangedCallback(name, oldvalue, newvalue) {
        if (name === "state" && oldvalue !== newvalue) {
            this.setState(parseInt(newvalue));
            this.menu.classList.toggle("collapse");
        }
        if (name === "id" && oldvalue !== newvalue) {
            this.id=parseInt(newvalue);
        }
    }
}

customElements.define("drop-state", DropState);
