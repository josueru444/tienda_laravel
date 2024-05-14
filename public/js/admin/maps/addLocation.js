function addLocation(event) {
    event.preventDefault();


    const toast = document.getElementById("toast");
    const msgToast = document.getElementById("msg");
    const name=document.getElementById('name');
    const latitude=document.getElementById('latitude').value;
    const longitude=document.getElementById('longitude').value;

    fetch("/add-location//", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            name: name.value,
            latitude: latitude,
            longitude:longitude
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "success") {
                name.value='';
                toast.classList.remove("hidden");
                msgToast.textContent = "Ubicación registrada";
                setTimeout(() => {
                    toast.classList.add("hidden");
                    msgToast.textContent = "";
                }, 2000);
            }
        })

        .catch((error) => {
            console.log("Error: ", error);
        });
}