let body = document.getElementById("body");
let buffer = null;
//
let step_page = 1;
let current_page = 1;
let items_per_page = 10;
let pagination = document.getElementById('pagination');
let option = document.getElementById('option');
let clip = document.createElement('div');
//clip.style.clip = 'rect(0,0,430px,40px)';
//clip.style.border = "1px solid lightgray"
let table = document.getElementById('table');
let items_display = null;

option.append(OptionPagination());

function DisplayPage(items, items_per_page = 10) {
    let start = items_per_page * (current_page - 1);
    let end = start + items_per_page;
    items_display = items.slice(start, end);
}

function CreateButtonPrev(items, fun) {
    let button = document.createElement("button");
    button.classList.add(["btn"], ["btn-ligth"], ["bi"], ['me-2'], ['bi-chevron-left']);
    button.addEventListener("click", () => {
        current_page -= step_page;
        if (current_page <= 1)
            current_page = 1;
        DisplayPage(buffer, parseInt(items_per_page));
        RefreshPage();
        activeButton(current_page);
    });
    return button;
}

function CreateButtonNext(items) {
    let button = document.createElement("button");
    button.classList.add(["btn"], ["btn-ligth"], ["bi"], ['ms-2'], ['bi-chevron-right']);
    button.addEventListener("click", () => {
        let count_page = Math.ceil(items.length / items_per_page);
        current_page += step_page;
        if (current_page >= count_page - 1)
            current_page = count_page;
        DisplayPage(buffer, parseInt(items_per_page));
        RefreshPage();
        activeButton(current_page);
    })
    return button;
}

function CreateButtonPage(page, items) {
    let button = document.createElement("button");
    button.innerText = page;
    button.classList.add("btn-page");
    button.classList.add(["btn"], ["btn-light"], ["mx-1"]);
    //
    if (current_page === page) {
        button.classList.add("active_page");
    }
    button.addEventListener("click", () => {
        current_page = page;
        DisplayPage(buffer, parseInt(items_per_page));
        RefreshPage();
        activeButton(current_page);
    })
    return button;
}

function activeButton(page) {
    let buttons = document.getElementsByClassName("btn-page");
    let current_btn_active = document.querySelectorAll(".active_page");
    if (current_btn_active.length > 0) {
        current_btn_active[0].classList.remove("active_page");
    }
    buttons[page - 1].classList.add("active_page");
}

function OptionPagination() {
    let select = document.createElement("select");
    let step = 0;
    for (let i = 0; i < 4; i++) {
        let option = document.createElement("option");
        option.value = 10 + step;
        let selected = (items_per_page === option.value) ? "selected" : "";
        if (selected)
            option.setAttribute(selected, "");
        option.innerText = "Par " + (10 + step) + " articles";
        select.append(option);
        step += 5;
    }
    select.addEventListener("change", (ev) => {
        let sel = ev.target[ev.target.selectedIndex];
        items_per_page = sel.value;           
        DisplayPage(buffer, parseInt(items_per_page));
        RefreshPage();
        
        SetupPagination(buffer, parseInt(items_per_page));           
    });
    return select;
}

function BasePagination(items, max_display = 10) {
    let count_page = Math.ceil(items.length / items_per_page);
    if (count_page > 1) {
        
        pagination.append(CreateButtonPrev(items));
        pagination.append(clip);           
        pagination.append(CreateButtonNext(items));
    }
}

function SetupPagination(items, max_display = 10) {
    RemovePagination();
    let count_page = Math.ceil(items.length / items_per_page);
    if (count_page > 1) {            
        
        if (count_page > max_display) {
        
            for (let i = 0; i < count_page; i++) {
                clip.append(CreateButtonPage(i + 1, items));
            }
        } else {
            for (let i = 0; i < count_page; i++) {
                clip.append(CreateButtonPage(i + 1, items));
            }
        }
        
    }
}


function RemovePagination() {
    /*while (pagination.lastElementChild) {
        pagination.removeChild(pagination.lastElementChild);
    }*/
    while (clip.lastElementChild) {
        clip.removeChild(clip.lastElementChild);
    }
}

function RefreshPage() {
    while (body.lastElementChild) {
        body.removeChild(body.lastElementChild);
    }
    for (let i = 0; i < items_display.length; i++) {
        Row(body, items_display[i]);
    }
}

fetch("<?= $article_json ?>")
    .then(res => res.json())
    .then(data => {
        buffer = data;
        DisplayPage(buffer);
        RefreshPage();
        BasePagination(buffer);
        SetupPagination(buffer);
    });

function Row(parent, data) {
    let tr = document.createElement("tr");
    let td1 = document.createElement("td");
    let a = document.createElement("a");
    a.innerHTML = "<i class='bi bi-eye'>";
    a.classList.add("btn");
    a.addEventListener("click", () => {
        form_preview.id_article.value = data.id_article;
        form_preview.submit();
    });
    let td2 = document.createElement("td");
    td2.innerText = data.subject;
    let td3 = document.createElement("td");
    td3.innerText = dateTimeFormat(data.datetime);
    body.append(tr);
    tr.append(td1);
    td1.append(a);
    tr.append(td2);
    tr.append(td3);
}