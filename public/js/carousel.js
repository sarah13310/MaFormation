
//let x = window.matchMedia("(min-width: 768px)")

//x.addListener(responsive_Min_768()); // Attach listener function on state changes

    let items = document.querySelectorAll('.carousel .carousel-item')

    items.forEach((el) => {
        const minPerSlide = 3
        let next = el.nextElementSibling
        for (var i = 1; i < minPerSlide; i++) {
            if (!next) {
                // qd il n'y a plus d'image on revient sur la premiere
                next = items[0]
            }
            let cloneChild = next.cloneNode(true)
            el.appendChild(cloneChild.children[0])
            next = next.nextElementSibling
        }
    })

