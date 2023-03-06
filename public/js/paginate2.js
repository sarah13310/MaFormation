// Le 20-02-2023
//
let tbody = document.getElementById("tbody");// corps de la table
const pagination = document.querySelector(".pagination ul"); //avec ul
let option = document.getElementById('option'); // selection du nombre d'articles affichés
let buffer = null; // buffer de résultat brute (toutes les données)
//
let step_page = 1; // 
let current_page = 1; // page courante
let items_per_page = 10; // nb articles par pages
//
let table = document.getElementById('table'); // la table
let items_display = null; // articles affichés par page
let totalPages = 20; // nb d'articles 


//localStorage
function getStoragePage(page) {
  if (page) {
    current_page = parseInt(page);
  }
  else {
    page = 1;
  }
}

/** Pagination */
function createPagination(totalPages, page = 1) {
  let liTag = '';
  let active;
  /*if (localStorage.page) {
    page = current_page;
  }*/
  let beforePage = page - 1;
  let afterPage = page + 1;

  current_page = page;
  RefreshPage();

  if (totalPages == 1) {
    if (pagination)
      pagination.remove();
  }

  if (page >= 1) { //show the next button if the page value is greater than 1
    if (page == 1) {
      liTag += `<li class="noselect me-2 btn prev" ><span><i class="'bi bi-chevron-left"></i> Préc</span></li>`;
    }
    else {
      //localStorage.page = page - 1;
      liTag += `<li class="noselect me-2 btn prev" onclick="createPagination(totalPages, ${page - 1})"><span><i class="'bi bi-chevron-left"></i> Préc</span></li>`;
    }
  }

  if (page > 2) { //if page value is less than 2 then add 1 after the previous button
    liTag += `<li class="first numb" onclick="createPagination(totalPages, 1)"><span>1</span></li>`;
    if (page > 3) { //if page value is greater than 3 then add this (...) after the first li or page
      liTag += `<li class="dots"><span>...</span></li>`;
    }
  }
  // how many pages or li show before the current li
  if (page == totalPages) {
    beforePage = beforePage - 2;
  } else if (page == totalPages - 1) {
    beforePage = beforePage - 1;
  }
  // how many pages or li show after the current li
  if (page == 1) {
    afterPage = afterPage + 2;
  } else if (page == 2) {
    afterPage = afterPage + 1;
  }

  for (let i = beforePage; i <= afterPage; i++) {
    if (i > totalPages) { //if i is greater than totalPage length then continue
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

  if (page < totalPages - 1) { //si page est moins que totalPage value by -1 then show the last li or page
    if (page < totalPages - 2) { //if page value is less than totalPage value by -2 then add this (...) before the last li or page
      liTag += `<li class="dots"><span>...</span></li>`;
    }
    liTag += `<li class="last numb" onclick="createPagination(totalPages, ${totalPages})"><span>${totalPages}</span></li>`;
  }

  if (page <= totalPages) { //show the next button if the page value is less than totalPage(20)

    if (page == totalPages) {
      liTag += `<li class="noselect ms-2 btn next"><span>Suiv <i class="'bi bi-chevron-right"></i></span></li>`;
    }
    else {
      //localStorage.page = page + 1;
      liTag += `<li class="noselect ms-2 btn next" onclick="createPagination(totalPages, ${page + 1})"><span>Suiv <i class="'bi bi-chevron-right"></i></span></li>`;
    }
  }

  tbody.dispatchEvent(new CustomEvent('page',
    {
      bubbles: true, detail: { current: current_page }
    }));
  if (pagination)
    pagination.innerHTML = liTag; //add li tag inside ul tag
  
    return liTag; //return the li tag
}

/** */
function OptionPagination() {
  let select = document.createElement("select");
  select.classList = "pagination-select";
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
    items_per_page = parseInt(sel.value);
    totalPages = Math.ceil(buffer.length / items_per_page);
    RefreshPage();
    if (pagination)
      pagination.innerHTML = createPagination(totalPages, 1);
  });
  return select;
}

/************* Gestion du tableau ************* */
/** Chargement du tableau */
function loadData(file_json, title = "particuliers", page = null) {
  fetch(file_json, {
    mode: "cors", credentials: 'same-origin', headers: {
      'Content-Type': 'application/json'
      // 'Content-Type': 'application/x-www-form-urlencoded',
    },
  })
    .then(res => res.json())
    .then(data => {
      buffer = data;
      RefreshPage();
      totalPages = Math.ceil(buffer.length / items_per_page);
      if (page) {
        current_page = parseInt(page);
        if (current_page > totalPages)
          current_page = 1
        page = current_page;
      }
      if (pagination)
        pagination.innerHTML = createPagination(totalPages, current_page);
      NbTitle(buffer.length, title);
      DisplayNone();
    }).catch(err => {
      console.log(err);
    });
}

/** Affiches le nombre total d'éléménts  */
function NbTitle(count, title = "particuliers") {
  if (buffer !== null) {
    let h6 = document.getElementsByTagName("h6");
    if (count == 0) {
      h6[0].outerText = "";
    } else {
      if (count == 1) {
        if (title[title.length - 1] === 's') {
          title = title.substring(0, title.length - 1);
        }
      }
      if (h6.length>0)
        h6[0].innerHTML = `<span class="noselect badge-1"><i>${count} ${title}</i></span>`;
    }
  }
}

/** On ouvre le panneau associé au bouton [+]  */
function expand(item) {
  const tr = item.parentElement.parentElement;
  let collapse = tr.nextElementSibling.classList.toggle("collapse");
  if (collapse) {
    tr.style.borderBottom = "1px solid lightgray";
    item.classList.remove("bi-dash");
    item.classList.add("bi-plus");
  } else {
    tr.style.borderBottom = "1px solid transparent";
    item.classList.remove("bi-plus");
    item.classList.add("bi-dash");
  }
}

/** Recalcule les articles à afficher par page */
function RecalcPage(items, items_per_page = 10) {
  let start = items_per_page * (current_page - 1);
  let end = start + items_per_page;
  items_display = items.slice(start, end);
}

/** Rafraîchit la page */
function RefreshPage() {
  //ApplyTheme();
  RecalcPage(buffer, items_per_page);
  while (tbody.lastElementChild) {
    tbody.removeChild(tbody.lastElementChild);
  }
  for (let i = 0; i < items_display.length; i++) {
    Row(tbody, items_display[i], i + 1);
  }
  ApplyTheme();
}

/** Gestion des themes */
function getTheme(type, css = "button") {
  switch (type) {
    case 9:
    case 11:
      css += "_user";
      break;
    case 7:
      css += "_former";
      break;
    case 5:
      css += "_admin";
      break;
    case 3:
      css += "_superadmin";
      break;
    default:
      css += "_default";
      break;
  }
  return css;
}

function ApplyTheme(type) {
  const buttons = document.querySelectorAll(".btn-primary");
  buttons.forEach((button) => {
    button.classList.replace("btn-primary", getTheme(type));
  }) 
}

function ModalTheme(type) {
  const headers = document.querySelectorAll(".modal-header");
  headers.forEach((header) => {
      header.classList.add(getTheme(type, "header"));
  })
}




