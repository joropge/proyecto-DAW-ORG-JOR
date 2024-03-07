import { slider } from "./slider.js";
//SLIDER
//document.addEventListener("DOMContentLoaded", slider);

document.addEventListener("DOMContentLoaded", function () {
    slider();

    function basketContent() {
        const full = document.getElementById("full-basket");
        const empty = document.getElementById("empty-basket");
        if (itemsTotal() < 1) {
            full.classList.add("hidden");
            empty.classList.remove("hidden");
        } else {
            full.classList.remove("hidden");
            empty.classList.add("hidden");
        }
    }

    function addOrder(id, nombre, precio, peso) {
        //const total = document.getElementById("total");
        const totalText = document.getElementById("total-text");
        totalText.classList.remove("hidden");
        const listItem = document.createElement("li");
        //añadimos el id del producto al elemento li
        listItem.setAttribute("id", id);
        listItem.classList.add(
            "product",
            "flex",
            "justify-between",
            "items-center",
            "border-b",
            "border-gray-200",
            "pb-4"
        );
        listItem.innerHTML = `
            <p>${nombre}</p>
            <p>${peso} kg</p>
            <p class="precio">${precio}€</p>
            <button class="btn-danger flex items-center justify-center w-5 h-5 border-none rounded-full cursor-pointer transition duration-200 ease-in-out">
  <svg viewBox="0 0 24 24">
    <path
      fill="none"
      stroke="red"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke-width="2"
      d="M6 18L18 6M6 6l12 12"
    />
  </svg>
</button>

        `;
        listItem.querySelector("button").addEventListener("click", function () {
            eliminarElementoPorId(id);
            precioTotal();
            document.getElementById("counter").innerHTML = itemsTotal();
            if (itemsTotal() < 1) {
                document.getElementById("order").classList.add("hidden");
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
        // Imprimir por pantalla 
        console.log("primer valor");   
        console.log(document.getElementById("total").innerHTML);    
        document.getElementById('total_input').value = document.getElementById("total").innerHTML;
        console.log("segundo valor");
        console.log(document.getElementById('total_input').value);
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

    // Fetch product data from the server
    fetch("admin/actions/get-products.php")
        .then((response) => response.json())
        .then((productos) => {
            // Loop through the products and create HTML elements
            for (let i = 0; i < productos.length; i++) {
                const div = document.createElement("div");
                div.classList.add(
                    "card",
                    "w-full",
                    "h-[400px]",
                    "border",
                    "border-neutral-800",
                    "hover:border-white",
                    "rounded-lg",
                    "overflow-hidden",
                    "transition",
                    "duration-200",
                    "ease-in-out"
                );
                div.innerHTML = `
                <img src="./imagenes/${productos[i].imagen}" class="card-img-top w-full h-1/2 object-cover" alt="...">
                <div class="card-body h-1/2 flex flex-col justify-between p-5">
                  <h5 class="card-title text-xl font-bold">${productos[i].nombre}</h5>
                  <p class="card-text text-sm text-lighter-gray">Ración: ${productos[i].racion} kg</p>
                  <p class="card-text text-sm text-lighter-gray">${productos[i].precioKg}€ IVA incl.</p>
                  <button class="btn btn-primary py-3 px-5 border-none rounded-md bg-white hover:bg-neutral-300 text-black text-center cursor-pointer transition duration-200 ease-in-out">Comprar</button>
                </div>`;
                div.querySelector("button").addEventListener(
                    "click",
                    function () {
                        addOrder(
                            productos[i].id,
                            productos[i].nombre,
                            parseFloat(productos[i].precioKg),
                            parseFloat(productos[i].racion)
                        );
                    }
                );
                mainContainer.appendChild(div);
            }
        })
        .catch((error) => console.error("Error fetching products:", error));

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
                window.location.href = "/index.php";
                // Aquí puedes agregar la lógica para realizar la acción
            } else {
                // El usuario hizo clic en "Cancelar" o cerró la ventana
                console.log("El usuario canceló la navegación");
                // Aquí puedes agregar la lógica para manejar la cancelación
            }
        } else {
            window.location.href = "/index.php";
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
                window.location.href = "../templates/acercaDe.php";
                // Aquí puedes agregar la lógica para realizar la acción
            } else {
                // El usuario hizo clic en "Cancelar" o cerró la ventana
                console.log("El usuario canceló la navegación");
                // Aquí puedes agregar la lógica para manejar la cancelación
            }
        } else {
            window.location.href = "../templates/acercaDe.php";
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
                window.location.href = "../templates/contacto.php";
                // Aquí puedes agregar la lógica para realizar la acción
            } else {
                // El usuario hizo clic en "Cancelar" o cerró la ventana
                console.log("El usuario canceló la navegación");
                // Aquí puedes agregar la lógica para manejar la cancelación
            }
        } else {
            window.location.href = "../templates/contacto.php";
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
    document.getElementById("order").classList.toggle("hidden");
});

document.getElementById("pagar").addEventListener("click", function () {
    window.location.href = "/templates/gracias.php";
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
