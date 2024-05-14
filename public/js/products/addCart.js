document.getElementById("form").addEventListener("submit", (e) => {
    e.preventDefault();
    const quantity = document.getElementById("cantidad").value;
    const toast = document.getElementById("toast");
    const msgToast = document.getElementById("msg");
    const id_prod = window.location.href;

    var url = new URL(id_prod);
    var pathname = url.pathname;
    var segments = pathname.split("/");
    var productId = segments[segments.length - 1];

    fetch("/add-cart/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            id_prod: productId,
            quantity: quantity,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
                if(data.msg){
                console.log(data);
                toast.classList.remove("hidden");
                msgToast.textContent = "Producto Agregado al carrito";
                setTimeout(() => {
                    toast.classList.add("hidden");
                    msgToast.textContent = "";
                }, 2000);
            }else if(data.error){
                alert('Asegurate de iniciar Sesión para agregar al carrito')
            }
            
        })
        .catch((error) => {
            console.log("Error: ", error);
        });
});

console.log("asa");
