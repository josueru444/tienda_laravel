const form = document.getElementById("form");
const total = document.getElementById("total-input2");
const paymentMethod = document.getElementById("cb1");
const btnAddress = document.getElementById("save-address");
const userNameInput = document.getElementById("user_name");
const addressInput = document.getElementById("address");
const zipInput = document.getElementById("zip");
const toast = document.getElementById("toast");
const msgToast = document.getElementById("msg");
const selectAddress = document.getElementById("address-select");

function addOrder() {
    fetch("/add-order/unpaid", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            address: selectAddress.textContent,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            
            if (data.status==='success') {
                window.location.href = "/my-orders/"+data.red;
            }else{
                window.location.href = "/";
            }
            
        })

        .catch((error) => {
            console.log("Error: ", error);
        });
}

form.addEventListener("submit", (e) => {
    e.preventDefault();
    console.log(paymentMethod.checked);
    if (paymentMethod.checked === true) {

        const address=document.getElementById('addres-paypal-input');
        address.value=(selectAddress.textContent).trim();
        modal_paypal.showModal();

    } else {
        console.log(paymentMethod.isChecked);
        modal_pago.showModal();
        const pAddress = document.getElementById("p-address");
        pAddress.textContent = selectAddress.textContent;
    }
});

btnAddress.addEventListener("click", (e) => {
    e.preventDefault();

    let userName = userNameInput.value;
    let address = addressInput.value;
    let zip = zipInput.value;
    console.log(zip);
    if (userName === "" || address === "" || zip === "") {
        alert("rellena todos los campos");
    } else {
        fetch("/add-address/", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                user_name: userName,
                address: address,
                zip_code: zip,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "ok") {
                    toast.classList.remove("hidden");
                    msgToast.textContent = "Dirección agregada";
                    setTimeout(() => {
                        toast.classList.add("hidden");
                        msgToast.textContent = "";
                    }, 2000);
                }
                location.reload();
            })

            .catch((error) => {
                console.log("Error: ", error);
            });
    }
});

function addAddressBTN(e) {
    modal_direccion.showModal();
}

function paypal() {
    fetch("/paypal/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            total: total.value,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
        })

        .catch((error) => {
            console.log("Error: ", error);
        });
}
