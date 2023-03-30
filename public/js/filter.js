
let buffer = null;

const main = document.getElementById("main");

function loadData(filename) {
    fetch(filename)
        .then(res => res.json())
        .then(data => {
            buffer = data;
            for (let i = 0; i < data.length; i++) {
                CreateItem(main, data[i]);
            }
        });
}


function clearAll() {
    while (main.lastElementChild) {
        main.removeChild(main.lastElementChild);
    }
}


function filtre(selectors) {

    clearAll();
    items = [...buffer]

    Object.entries(selectors).forEach(entry => {
        const [key, value] = entry;
        if (key === "author") {
            if (value !== null) {
                if (value.value !== "Tous") {
                    items = items.filter(item => {
                        return (item.author === value.value);
                    });
                }
            }
        }
        if (key === "tag") {
            if (value !== null) {
                if (value.value !== "Tous") {
                    items = items.filter(item => {
                        return (item.tag[0].name === value.value);
                    });
                }
            }
        }
        if (key === "status") {
            if (value !== null) {
                if (value.value !== "Tous") {
                    items = items.filter(item => {
                        return (item.status === value.value);
                    });
                }
            }
        }
        if (key === "distributor") {
            if (value !== null) {
                if (value.value !== "Tous") {
                    let dif = value.value.split(" ");
                    dif = dif[0] + dif[1];
                    items = items.filter(item => {
                        return (item.user[0].name + item.user[0].firstname === dif);
                    });
                }
            }
        }
        if (key === "former") {
            if (value !== null) {
                if (value.value !== "Tous") {
                    let dif = value.value.split(" ");
                    dif = dif[0] + dif[1];
                    items = items.filter(item => {
                        return (item.name + item.firstname === dif);
                    });
                }
            }
        }
        if (key === "company") {
            if (value !== null) {
                if (value.value !== "Tous") {
                    items = items.filter(item => {
                        return (item.user.company === value.value);
                    });
                }
            }
        }
        if (key === "city") {
            if (value !== null) {
                if (value.value !== "Tous") {
                    items = items.filter(item => {
                        return (item.user.city === value.value);
                    });
                }
            }
        }
        if (key === "cp") {
            if (value !== null) {
                if (value.value !== "Tous") {
                    items = items.filter(item => {
                        return (item.user.cp === value.value);
                    });
                }
            }
        }
        if (key === "alpha") {
            if (value !== null) {
                if (value.value === "A-Z") {
                    items.sort(az);
                }
                if (value.value === "Z-A") {
                    items.sort(za);
                }
            }
        }
        /*  if (key === "day") {
             if (value !== null) {
                 if (value !== "Tous") {
                     items = items.filter(item => {
                         return (item.author === value);
                     });
                 }
             }
         }
         if (key === "mouth") {
             if (value !== null) {
                 if (value !== "Tous") {
                     items = items.filter(item => {
                         return (item.author === value);
                     });
                 }
             }
         }
         if (key === "year") {
             if (value !== null) {
                 if (value !== "Tous") {
                     items = items.filter(item => {
                         return (item.author === value);
                     });
                 }
             }
         } */
    });

    /* if (Day !== null && Month !== null && Year !== null) {

        if (items === null)
            return;

        let date = new Date(Year, Month, Day);

        items = items.filter(item => {
            let itemdate = new Date(item.datetime);
            return (itemdate == date);
        });

    } */
    display(items);
}

function display(items) {
    for (let i = 0; i < items.length; i++) {
        CreateItem(main, items[i]);
    }
}

let alpha_prop = "name";

const az = (a, b) => {
    if (a[alpha_prop].toLowerCase() > b[alpha_prop].toLowerCase()) {
        return 1;
    }
    if (a[alpha_prop].toLowerCase() < b[alpha_prop].toLowerCase()) {
        return -1;
    }
    return 0;
}

const za = (a, b) => {
    if (a[alpha_prop].toLowerCase() > b[alpha_prop].toLowerCase()) {
        return -1;
    }
    if (a[alpha_prop].toLowerCase() < b[alpha_prop].toLowerCase()) {
        return 1;
    }
    return 0;
}

function showAll() {
    clearAll();
    items = [...buffer];
    for (let i = 0; i < items.length; i++) {
        CreateItem(main, items[i]);
    }
}



