console.log("carrito");
const buttons = document.querySelectorAll("#plus");
const buttonsMinus = document.querySelectorAll("#minus");
const total_input = document.getElementById("total-input");
const total_input2 = document.getElementById("total-input2");

function currencyFormat(num) {
    return "$" + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

buttons.forEach((button) => {
    button.addEventListener("click", (e) => {
        let total = total_input.value;
        let parent = e.target.parentNode;
        let input = parent.querySelector("#quantity");
        let price = parent.querySelector("#price").textContent.substring(1);
        const idProduct = parent.querySelector("#id-product").value;
        const idProdReal = parent.querySelector("#id-product-real").value;
        let quantity = input.value;
        let max = input.max;
        input.value = parseInt(input.value) + 1;

        if (parseInt(input.value) <= parseInt(max)) {
            let new_total = (parseFloat(total) + parseFloat(price)).toFixed(2);
            total_input.value = new_total;
            total_input2.value = new_total;
        }

        if (parseInt(quantity) >= parseInt(max)) {
            input.value = max;
            button.disabled=true;
            updateCart(idProduct, max,idProdReal);
        }

        updateCart(idProduct, parseInt(quantity) + 1,idProdReal);
        button.disabled=true;
    });
});

buttonsMinus.forEach((button) => {
    button.addEventListener("click", (e) => {
        let total = total_input.value;
        let parent = e.target.parentNode;
        let input = parent.querySelector("#quantity");
        let price = parent.querySelector("#price").textContent.substring(1);
        const idProduct = parent.querySelector("#id-product").value;
        const idProdReal = parent.querySelector("#id-product-real").value;
        let quantity = input.value;
        let max = input.max;

        let new_total = (parseFloat(total) - parseFloat(price)).toFixed(2);

        total_input.value = new_total;
        total_input2.value = new_total;
        input.value = parseInt(input.value) - 1;
        if (parseInt(quantity) <= 1) {
            input.value = 1;
            total_input.value = parseFloat(new_total) + parseFloat(price);
            total_input2.value = parseFloat(new_total) + parseFloat(price);
            
            updateCart(idProduct, 1,idProdReal);
            
        }
        updateCart(idProduct, parseInt(quantity) - 1,idProdReal);
       
    });
});

function updateCart(idproduct, quantityprod,prod) {
    fetch("/update-cart-quantity/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            id: idproduct,
            quantity: quantityprod,
            idProd:prod
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if(data.msg==='success'){
                window.location.reload();
            }
            console.log(data);
        })

        .catch((error) => {
            console.log("Error: ", error);
        });
}
