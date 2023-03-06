

class RightPanelEx extends HTMLElement {

    static get observedAttributes() { return ['right', 'title', 'readonly']; }

    constructor(title = "RightPanelEx" ,readonly=false) {
        super();
        this.shadow = this.attachShadow({ mode: 'open' });
        this.title = title;
        this.readonly=readonly;
        
        this.add = null;
        this.del = null;
        this.update = null;
        this.read = null;
        this.exp = null;

        this.action_add = false;
        this.action_del = false;
        this.action_update = false;
        this.action_read = false;
        this.action_exp = false;

        this.rights = 0;
    }

    connectedCallback() {

        this.shadow.innerHTML = `
        <head>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        </head>
        <style>  
        
        .panel {
            display:block;
            border-radius: 8px;
	        border: 1px solid lightgray;
	        box-shadow: 1px 1px 4px rgb(134, 134, 134);
	        width: 176px;
	        height: 200px;
	        /*margin-right: 14px;*/
        }

        .title {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 100%;
            height: 18%;	
            background: #570157;
            color: white;
            cursor:pointer;
        }

        .body{
            display:block;
            width: 100%;
            height: 80%;
            margin-left:12px;
        }

        .btn{
            cursor:pointer;
    
        }
       
        .on{
            color:darkmagenta;
            font-weight: 550;
        }
        
        .off{
            color:darkgray;
            font-weight: normal;
        }

        .btn:hover{
            color:ineherit;
            filter:brightness(0.6);
        }

        </style>
        <template id="template-rightpanel">
            <div id="container" class="panel">
                <div id="bar"   class="title"></div>
                <div id="body"  class="body">
                    <div>&nbsp;</div>
                    <right-button id="add" class="btn off bi-add-off" text="Ajouter"></right-button>
                    <right-button type="READ" id="read" class="btn off bi-read-off "text="Lire"></right-button>
                    <right-button type="UPDATE" id="update" class="btn off bi-update-off" text="Mise à jour"></right-button>
                    <right-button type="DELETE" id="del" class="btn off bi-delete-off" text="Supprimer"></right-button>
                    <right-button type="EXPORT" id="exp" class="btn off bi-export-off" text="Exporter"></right-button>
                </div>
            </div>    
        </template>    
        <div id=result></div>
        `;

        this.template_content = this.shadow.querySelector("#template-rightpanel").content;
        this.result = this.shadow.querySelector("#result");
        const clone = document.importNode(this.template_content, true);
        this.result.appendChild(clone);
        this.bar = this.result.querySelector("#bar");
        this.bar.innerText = this.title;
        //
        this.add = this.result.querySelector("#add");        
        this.del = this.result.querySelector("#del");        
        this.read = this.result.querySelector("#read");        
        this.update = this.result.querySelector("#update");        
        this.exp = this.result.querySelector("#exp");        

        this.add.addEventListener('toggle', () => {
            this.action_add = !this.action_add;          
            this.calcRight();
        })

        this.del.addEventListener('toggle', () => {
            this.action_del = !this.action_del;
            this.calcRight();
        })

        this.update.addEventListener('toggle', () => {
            this.action_update = !this.action_update;
            this.calcRight();
        })

        this.read.addEventListener('toggle', () => {
            this.action_read = !this.action_read;
            this.calcRight();
        })

        this.exp.addEventListener('toggle', () => {
            this.action_exp = !this.action_exp;
            this.calcRight();
        })
    }

    calcRight() {
        this.rights = 16 * Number(this.action_add);
        this.rights += 8 * Number(this.action_read);
        this.rights += 4 * Number(this.action_update);
        this.rights += 2 * Number(this.action_del);
        this.rights += 1 * Number(this.action_exp);
        this.dispatchEvent(new CustomEvent('rights',
            {
                bubbles: true, detail: { value: this.rights }
            }));
    }

    setRight(rights) {
        this.rights = rights;
        let high = parseInt(this.rights[0]);
        let low = parseInt(this.rights[1], 16);
        let hValue = (high * 16) + low;
        this.add.classList.remove("off");
        this.add.setState(false);
        this.read.classList.remove("off");
        this.read.setState(false);
        this.update.classList.remove("off");
        this.update.setState(false);
        this.del.classList.remove("off");
        this.del.setState(false);
        this.exp.classList.remove("off");
        this.exp.setState(false);

        if (high & 0x1) {
           // console.log("FLAG_WRITE");
            this.add.classList.add("on");
            this.add.classList.remove("off");
            this.add.setState(true);
        }
        if (hValue & 0x8) {
            //console.log("FLAG_READ");
            this.read.classList.add("on");
            this.read.classList.remove("off");
            this.read.setState(true);
        }
        if (hValue & 0x4) {
            //console.log("FLAG_UPDATE");
            this.update.classList.add("on");
            this.update.classList.remove("off");
            this.update.setState(true);
        }
        if (hValue & 0x2) {
            //console.log("FLAG_DELETE");
            this.del.classList.add("on");
            this.del.classList.remove("off");
            this.del.setState(true);
        }
        if (hValue & 0x1) {
            //console.log("FLAG_EXPORT");
            this.exp.classList.add("on");
            this.exp.classList.remove("off");
            this.exp.setState(true);
        }

    }

    setTitle(title) {
        this.title = title;
        this.bar.innerText = this.title;
    }

    setReadOnly(readonly){
        this.readonly=readonly;
        this.add.setReadOnly(readonly);
        this.read.setReadOnly(readonly);
        this.update.setReadOnly(readonly);
        this.del.setReadOnly(readonly);
        this.exp.setReadOnly(readonly);
    }

    attributeChangedCallback(name, oldvalue, newvalue) {
        if (name === "right" && oldvalue !== newvalue) {
            this.setRight(newvalue);
        }
        if (name === "title" && oldvalue !== newvalue) {
            this.setTitle(newvalue);
        }
        if (name === "readonly" && oldvalue !== newvalue) {
            this.setReadOnly(newvalue);
        }
    }

}

customElements.define("right-panel-ex", RightPanelEx);
