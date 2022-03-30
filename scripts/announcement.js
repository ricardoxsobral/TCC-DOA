const requestButton = document.getElementById("request");
const totalRequests = document.getElementById("total_requests");
let announcement = new URLSearchParams(location.search).get("pagina");
announcement = !isNaN(announcement) && !!announcement && Number(announcement);

requestButton.addEventListener("click", () => {
    if (announcement) {
        requestButton.innerHTML = "<span class='spinner-border spinner-border-sm'></span> Solicitar";
        const request = new XMLHttpRequest();
        request.open("POST", "./app/Controllers/AnnouncementController.php");
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                requestButton.innerText = "Solicitado";
                requestButton.setAttribute("disabled", true);
                totalRequests.innerText = Number(totalRequests.innerText) + 1;
            }
        }
        request.send(`announcement_method=store&announcement=${ announcement }`);
    }
});
