// classe abstraite
class InputValidator extends HTMLElement {

    constructor(text, keyword = "", type="text") {
        this.text = text;
        this.min = 8;
        this.max = 32;
        this.keyword = keyword;
        this.icon="";
        this.type=type;
        this.input=document.createElement("input");
        this.input.setAttribute("type", type);
        if (this.icon.length>0){
            this.input.innerHTML=this.icon;
            this.input.style="padding-left:32px";
        }

    }

    pattern(pattern) {
        this.pattern = pattern;
    }

    setMin(min) {
        this.min = min;
    }

    setMin(max) {
        this.max = max;
    }

    isValide() {
        let msg = "";
        this.text = this.input.value;

        if (text.length <= min) {
            if (this.keyword.length > 0) {
                msg = `${this.keyword} `;
            }
            msg += "trop court!";
        }

        if (text.length >= max) {
            if (this.keyword.length > 0) {
                msg = `${this.keyword} `;
            }
            msg += "trop long!";
        }

        if (text.length == 0) {
            if (this.keyword.length > 0) {
                msg = `${this.keyword} `;
            }
            msg += "vide!";
        }

        if (this.pattern.length > 0) {
            if (!text.match(this.pattern)) {
                msg = `Format ${this.keyword} invalide!`;
            }
        }
        return msg;
    }

    validate() {
        let err = isValid(this.text);
        if (err == "") {
            this.dispatchEvent('valide', {
                bubbles: true, detail: { value: this.text, status: 1 }
            });

        } else {
            this.dispatchEvent('error', {
                bubbles: true, detail: { value: err, status: 0 }
            });
        }
    }
}


class InputText extends InputValidator {
    constructor(text, keyword) {
        super(text, keyword);
        
    }
}


class InputPassword extends InputValidator {
    constructor(text, keyword) {
        super(text, keyword, "password");
    
    }
}


class InputMail extends InputValidator {
    constructor(text, keyword = "mail") {
        super(text, keyword, "mail");
        this.pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    
    }
}

class InputTel extends InputValidator {
    constructor(text, keyword = "numéro") {
        super(text, keyword);        
        this.pattern = /^\+?([0-9]{2})\)?[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})$/;
        
    }
}


customElements.define("input-text", InputText);
customElements.define("input-password", InputPassword);
customElements.define("input-mail", InputMail);
customElements.define("input-tel", InputTel);