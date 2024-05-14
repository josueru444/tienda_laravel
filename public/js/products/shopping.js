const formAddres = document.getElementById("form-address");
const toast = document.getElementById("toast");
const msgToast = document.getElementById("msg");

const formPaymentSelect = document.getElementById("form-select-payment");

formAddres.addEventListener("submit", (e) => {
    e.preventDefault();
    const userName = document.getElementById("user_name").value;
    const address = document.getElementById("address").value;
    const zip = document.getElementById("zip").value;

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
            console.log(data);
            if (data.status === "ok") {
                toast.classList.remove("hidden");
                msgToast.textContent = "Dirección agregada";
                setTimeout(() => {
                    toast.classList.add("hidden");
                    msgToast.textContent = "Dirección agregada";
                }, 2000);
            }
            location.reload();
        })

        .catch((error) => {
            console.log("Error: ", error);
        });
});

function showModalPayment() {
    const totalInput1 = document.getElementById("total-input");
    const inputQuantity = document.getElementById("cantidad").value;
    const totalOrder = parseFloat(inputQuantity) * parseFloat(priceProduct);

    totalInput1.value = totalOrder;

    modal_payment.showModal();
}

function selectPayment(event) {
    event.preventDefault();
    const paymentSelected = document.getElementById("cb1");
    const pTotal = document.getElementById("total-oxxo");
    const inputQuantity = document.getElementById("cantidad").value;

    const addressSelect=document.getElementById('address-select');
    const pAddress=document.getElementById('p-address');

    const totalOrder = parseFloat(inputQuantity) * parseFloat(priceProduct);

    pTotal.textContent = "$" + totalOrder;
    pAddress.textContent=addressSelect.textContent;

    if (paymentSelected.checked === true) {
        const addresInput=document.getElementById('addres-paypal-input');
        const disabledTotal=document.getElementById('disabled-total');
        const hiddenTotal=document.getElementById('total-paypal');
        const hiddenQuantity=document.getElementById('quantity-paypal');

        hiddenQuantity.value=inputQuantity;

        addresInput.value=(addressSelect.textContent).trim();
        disabledTotal.disabled=false;
        disabledTotal.value='$ '+totalOrder+'MNX';
        disabledTotal.disabled=true;
        hiddenTotal.value=totalOrder;
        modal_paypal.showModal();
    } else {
        modal_pago_efectivo.showModal();
    }
}
