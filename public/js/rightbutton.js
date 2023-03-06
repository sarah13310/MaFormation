//
class RightButton extends HTMLElement {

    static get observedAttributes() { return ['state', 'type', 'text', 'class', 'readonly']; }

    constructor(title = "titre2", state = false, type = "ADD", readonly=false) {
        super();
        this.title = title;
        this.state = state;
        this.type = type;
        this.readonly=this.readonly;
        this.container = document.createElement("div");
        this.text = document.createElement("span");
        this.setText(this.title);
        this.setState(this.state);

        this.container.append(this.text);
        this.append(this.container);

        this.container.addEventListener("click", () => {
            
            if (readonly) return;
            this.state =! this.state;
            this.setState(this.state);
            
            this.dispatchEvent(new CustomEvent('toggle',
                {
                    bubbles: true, detail: { current: this.state }
                }));
        })
    }

    setText(title) {
        this.title = title;
        this.text.innerHTML = "&nbsp;&nbsp;&nbsp;" + this.title;
    }

    setState(state) {
        this.state = state;
        switch (this.type) {
            case "ADD":
                if (state)
                    this.text.classList = "on bi bi-plus-circle-fill";
                else
                    this.text.classList = "off bi bi-plus-circle";
                break;
            case "DELETE":
                if (state)
                    this.text.classList = "on bi bi-dash-circle-fill";
                else
                    this.text.classList = "off bi bi-dash-circle";
                break;
            case "UPDATE":
                if (state)
                    this.text.classList = "on bi bi-check-circle-fill";
                else
                    this.text.classList = "off bi bi-check-circle";
                break;
            case "EXPORT":
                if (state)
                    this.text.classList = "on bi bi-arrow-up-circle-fill";
                else
                    this.text.classList = "off bi bi-arrow-up-circle";
                break;
            case "READ":
                if (state)
                    this.text.classList = "on bi bi-info-circle-fill";
                else
                    this.text.classList = "off bi bi-info-circle";
                break;
        }
    }

    setType(type) {
        this.type = type;
        this.setState(this.state);
    }

    setClass(classe) {
        this.classList = classe;
    }

    setReadOnly(readonly) {
        this.readonly = readonly;
    }

    attributeChangedCallback(name, oldvalue, newvalue) {
        if (name === "state" && oldvalue !== newvalue) {
            this.setState(newvalue);
        }
        if (name === "text" && oldvalue !== newvalue) {
            this.setText(newvalue);
        }
        if (name === "type" && oldvalue !== newvalue) {
            this.setType(newvalue);
        }
        if (name === "class" && oldvalue !== newvalue) {
            this.setClass(newvalue);
        }
        if (name === "readonly" && oldvalue !== newvalue) {
            this.setReadOnly(newvalue);
        }
    }

}
customElements.define("right-button", RightButton);
