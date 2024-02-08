import { slider } from "./slider.js";
//SLIDER
//document.addEventListener("DOMContentLoaded", slider);

document.addEventListener("DOMContentLoaded", function () {
    slider();

    function basketContent() {
        const full = document.getElementById("full-basket");
        const empty = document.getElementById("empty-basket");
        if (itemsTotal() < 1) {
            full.classList.add("hide");
            empty.classList.remove("hide");
        } else {
            full.classList.remove("hide");
            empty.classList.add("hide");
        }
    }

    function addOrder(id, nombre, precio, peso) {
        //const total = document.getElementById("total");
        const totalText = document.getElementById("total-text");
        totalText.classList.remove("hide");
        const listItem = document.createElement("li");
        //añadimos el id del producto al elemento li
        listItem.setAttribute("id", id);
        listItem.classList.add("product");
        listItem.innerHTML = `
            <p>${nombre}</p>
            <p>${peso} kg</p>
            <p class="precio">${precio}€</p>
            <button class="btn btn-danger">x</button>
        `;
        listItem.querySelector("button").addEventListener("click", function () {
            eliminarElementoPorId(id);
            precioTotal();
            document.getElementById("counter").innerHTML = itemsTotal();
            if (itemsTotal() < 1) {
                document.getElementById("order").classList.add("hide");
            }
            basketContent();
        });

        document.getElementById("list-order").appendChild(listItem);
        precioTotal();
        document.getElementById("counter").innerHTML = itemsTotal();
        basketContent();
    }

    function precioTotal() {
        let precioTotal = 0;
        const precios = document.querySelectorAll(".precio");
        precios.forEach((precio) => {
            precioTotal += parseFloat(precio.innerHTML);
        });
        document.getElementById("total").innerHTML = precioTotal.toFixed(2);
    }

    function itemsTotal() {
        //calculamos el numero de elementos con clase producto
        const items = document.querySelectorAll(".product");
        return items.length;
    }

    //Fetch data from JSON file
    // fetch("/js/producto.json")
    //     .then(function (response) {
    //         return response.json();
    //     })
    //     .then(function (data) {
    //         appendData(data);
    //     })
    //     .catch(function (err) {
    //         console.log("error: " + err);
    //     });

    // Append the data to the DOM
    // function appendData(data) {
    const mainContainer = document.getElementById("display");
    for (let i = 0; i < productos.length; i++) {
        const div = document.createElement("div");
        div.classList.add("card");
        div.innerHTML = `
        <img src="${productos[i].imagen}" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">${productos[i].nombre}</h5>
          <p class="card-text">Ración: ${productos[i].peso} kg</p>
          <p class="card-text">${productos[i].precio}€ IVA incl.</p>
          <button class="btn btn-primary">Comprar</button>
        </div>`;
        div.querySelector("button").addEventListener("click", function () {
            addOrder(
                productos[i].id,
                productos[i].nombre,
                parseFloat(productos[i].precio),
                parseFloat(productos[i].peso)
            );
        });
        mainContainer.appendChild(div);
    }
    // }

    document.getElementById("inicio").addEventListener("click", function () {
        if (itemsTotal() > 0) {
            // Mostrar un cuadro de diálogo de confirmación
            const confirmacion = window.confirm(
                "Si cambia de página perderá su pedido. ¿Desea continuar?"
            );

            // Verificar la respuesta del usuario
            if (confirmacion) {
                // El usuario hizo clic en "Aceptar"
                window.location.href = "/index.html";
                // Aquí puedes agregar la lógica para realizar la acción
            } else {
                // El usuario hizo clic en "Cancelar" o cerró la ventana
                console.log("El usuario canceló la navegación");
                // Aquí puedes agregar la lógica para manejar la cancelación
            }
        } else {
            window.location.href = "/index.html";
        }
    });
    document.getElementById("acerca").addEventListener("click", function () {
        if (itemsTotal() > 0) {
            // Mostrar un cuadro de diálogo de confirmación
            const confirmacion = window.confirm(
                "Si cambia de página perderá su pedido. ¿Desea continuar?"
            );

            // Verificar la respuesta del usuario
            if (confirmacion) {
                // El usuario hizo clic en "Aceptar"
                window.location.href = "../templates/acercaDe.html";
                // Aquí puedes agregar la lógica para realizar la acción
            } else {
                // El usuario hizo clic en "Cancelar" o cerró la ventana
                console.log("El usuario canceló la navegación");
                // Aquí puedes agregar la lógica para manejar la cancelación
            }
        } else {
            window.location.href = "../templates/acercaDe.html";
        }
    });
    document.getElementById("contacto").addEventListener("click", function () {
        if (itemsTotal() > 0) {
            const confirmacion = window.confirm(
                "Si cambia de página perderá su pedido. ¿Desea continuar?"
            );

            // Verificar la respuesta del usuario
            if (confirmacion) {
                // El usuario hizo clic en "Aceptar"
                window.location.href = "../templates/contacto.html";
                // Aquí puedes agregar la lógica para realizar la acción
            } else {
                // El usuario hizo clic en "Cancelar" o cerró la ventana
                console.log("El usuario canceló la navegación");
                // Aquí puedes agregar la lógica para manejar la cancelación
            }
        } else {
            window.location.href = "../templates/contacto.html";
        }
    });
});

function eliminarElementoPorId(id) {
    const elemento = document.getElementById(id);

    if (elemento) {
        // Si el elemento existe, lo eliminamos
        elemento.parentNode.removeChild(elemento);
    } else {
        console.log(`No se encontró un elemento con el id ${id}`);
    }
}

document.getElementById("basket").addEventListener("click", function () {
    document.getElementById("order").classList.toggle("hide");
});

document.getElementById("pagar").addEventListener("click", function () {
    window.location.href = "/templates/gracias.html";
});

const productos = [
    {
        id: 1,
        nombre: "Chorizo",
        precio: 10.9,
        peso: 0.5,
        imagen: "../assets/img/chorizo.jpg",
    },
    {
        id: 2,
        nombre: "Chuleta",
        precio: 12.9,
        peso: 0.5,
        imagen: "../assets/img/chuleta.jpg",
    },
    {
        id: 3,
        nombre: "Costilla",
        precio: 11.9,
        peso: 0.5,
        imagen: "../assets/img/costilla.jpg",
    },
    {
        id: 4,
        nombre: "Lomo",
        precio: 13.9,
        peso: 0.5,
        imagen: "../assets/img/lomo.jpg",
    },
    {
        id: 5,
        nombre: "Pechuga",
        precio: 9.9,
        peso: 0.5,
        imagen: "../assets/img/pechuga.jpg",
    },
    {
        id: 6,
        nombre: "Pierna",
        precio: 10.9,
        peso: 0.5,
        imagen: "../assets/img/pierna.jpg",
    },
    {
        id: 7,
        nombre: "Tocino",
        precio: 8.9,
        peso: 0.5,
        imagen: "../assets/img/tocino.jpg",
    },
    {
        id: 8,
        nombre: "Tira",
        precio: 11.9,
        peso: 0.5,
        imagen: "../assets/img/tira.jpg",
    },
];
