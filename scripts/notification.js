const container = document.getElementById("notifications");
const toggle = document.getElementById("notifications-toggle");
const unreadBadge = document.getElementById("unread-badge");
const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
let response;

function loadNotifications(send) {
    const request = new XMLHttpRequest();
    request.open("POST", "./app/Controllers/NotificationController.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.onreadystatechange = function() {
        if (this.readyState == 4) {
            response = JSON.parse(this.responseText);

            const placeholder = document.createElement("div");
            placeholder.innerHTML = response.notifications;
            Array.from(placeholder.children).forEach((notification, index) => {
                let button;
                if (button = notification.querySelector("#confirm"))
                    button.addEventListener("click", (event) => {
                        event.stopPropagation();
                        event.target.parentNode.innerHTML = "Confirmado";
                        notifAction("confirm", response.notif_requests[index]);
                    });
                if (button = notification.querySelector("#refuse"))
                    button.addEventListener("click", (event) => {
                        event.stopPropagation();
                        event.target.parentNode.innerHTML = "Recusado";
                        notifAction("refuse", response.notif_requests[index]);
                    });
                if (button = notification.querySelector("#conclude"))
                    button.addEventListener("click", (event) => {
                        event.stopPropagation();
                        event.target.parentNode.innerHTML = "Concluído";
                        notifAction("conclude", response.notif_requests[index]);
                    });
                if (button = notification.querySelector("#rate")) {
                    let rate;
                    notification.querySelectorAll(".stars-rating svg").forEach(star => {
                        let clicked = false;

                        star.addEventListener("mouseenter", () => {
                            star.setAttribute("star", "full");
                            let sibling = star.nextElementSibling;
                            if (sibling) {
                                sibling.setAttribute("star", "empty");
                                while (sibling = sibling.nextElementSibling) {
                                    sibling.setAttribute("star", "empty");
                                }
                            }
                            sibling = star.previousElementSibling;
                            if (sibling) {
                                sibling.setAttribute("star", "full");
                                while (sibling = sibling.previousElementSibling) {
                                    sibling.setAttribute("star", "full");
                                }
                            }
                            rate = null;
                            clicked = false;
                            button.setAttribute("disabled", "");
                        });
                        
                        star.addEventListener("click", () => {
                            rate = star.getAttribute("value");
                            clicked = true;
                            button.removeAttribute("disabled");
                        });
                
                        star.addEventListener("mouseleave", () => {
                            if (clicked == false)
                                Array.from(star.parentNode.children).forEach((child) => child.setAttribute("star", "empty"));
                        });
                    });
                    button.addEventListener("click", (event) => {
                        event.stopPropagation();
                        event.target.parentNode.innerHTML = "Avaliado";
                        notifAction("rate", response.notif_requests[index], rate);
                    });
                }
                container.prepend(notification);
            });

            if (container.children.length > 1 && container.lastChild.innerHTML == "Suas notificações aparecerão aqui.")
                container.lastChild.remove();

            unreadBadge.innerHTML = (Number(unreadBadge.innerHTML) + response.unread_count) || null;

            loadNotifications(`notif_method=show&latest&timezone=${ timezone }`);
        }
    }
    request.send(send);
}
loadNotifications(`notif_method=show&timezone=${ timezone }`);

toggle.addEventListener("click", () => {
    if (response.unread_count && unreadBadge.innerHTML) {
        const request = new XMLHttpRequest();
        request.open("POST", "./app/Controllers/NotificationController.php");
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");   
        request.setRequestHeader("X-Requested-With", "XMLHttpRequest"); 
        request.onreadystatechange = function() {
            if (this.readyState == 4) {
                unreadBadge.innerHTML = null;
                setTimeout(() => {
                    document.querySelectorAll("#notifications > div").forEach((notification) => {
                        if (!notification.classList.contains("text-black-50"))
                            notification.classList.add("text-black-50");
                    });
                }, 5000);
            }
        }
        request.send("notif_method=read_all");    
    }
});

function notifAction(action, notifRequest, rate = 0) {
    const request = new XMLHttpRequest();
    request.open("POST", "./app/Controllers/NotificationController.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");   
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    if (rate)
        request.send(`notif_method=${ action }&notif_request=${ notifRequest }&rate=${ rate }`);
    else
        request.send(`notif_method=${ action }&notif_request=${ notifRequest }`);
}
