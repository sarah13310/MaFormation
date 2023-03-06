

class RightPanel extends HTMLElement {

    static get observedAttributes() { return ['right', 'title']; }

    constructor(title = "titre") {
        super();
        const shadow = this.attachShadow({ mode: 'open' });
        const style = document.createElement('style');
        style.textContent = `
        
        .panel-rightpanel {
            display:block;
            border-radius: 8px;
	        border: 1px solid lightgray;
	        box-shadow: 1px 1px 4px rgb(134, 134, 134);
	        width: 180px;
	        height: 200px;
	        margin-right: 12px;
        }

        .title-rightpanel {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 100%;
            height: 40px;	
            background: #570157;
            color: white;
        }

        .body-rightpanel{
            display:block;
            width: 100%;
            height: 80%;
        }

        .btn-right{
            width:100%;
            height:23px;
        }

        .btn:hover{
            color:brightness(1.2);
        }

        .btn{
            cursor.pointer;
        }

        `;
        shadow.appendChild(style);
        this.title = title;
        //    
        this.container = document.createElement("div");
        this.bar = document.createElement("div");
        this.body = document.createElement("div");
        //
        this.body.classList = "body-rightpanel";
        this.container.classList = "panel-rightpanel";
        this.bar.classList = "title-rightpanel";
        //
        this.bar.innerText = this.title;
        //        
        shadow.appendChild(this.container);
        this.container.append(this.bar);
        this.container.append(this.body);
        //
        let add = document.createElement('right-button');

        let del = document.createElement('right-button');
        let update = document.createElement('right-button');
        let read = document.createElement('right-button');
        let exp = document.createElement('right-button');
        add.setAttribute("text", "Ajouter");
        add.setAttribute("type", "ADD");
        add.classList="btn";
        
        del.setAttribute("text", "Effacer");
        del.setAttribute("type", "DELETE");
        del.classList="btn";

        update.setAttribute("text", "Mise à jour");
        update.setAttribute("type", "UPDATE");
        update.classList="btn";
        
        read.setAttribute("text", "Lire");
        read.setAttribute("type", "READ");
        read.classList="btn";
        
        
        this.body.append(add);
        this.body.append(del);
        this.body.append(update);
        this.body.append(read);
        this.body.append(exp);


    }

    setRight(rights) {
        this.rights = rights;
    }

    setTitle(title) {
        this.title = title;
        this.bar.innerText = this.title;
    }

    attributeChangedCallback(name, oldvalue, newvalue) {
        if (name === "right" && oldvalue !== newvalue) {
            this.setRight(newvalue);
        }
        if (name === "title" && oldvalue !== newvalue) {
            this.setTitle(newvalue);
        }
    }

}

customElements.define("right-panel", RightPanel);
