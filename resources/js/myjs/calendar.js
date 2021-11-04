import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import itLocale from "@fullcalendar/core/locales/es";

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");
    var datos = JSON.parse(calendarEl.getAttribute("data"));
    console.log(datos);  
    if (calendarEl != null) {
        let calendar = new Calendar(calendarEl, {
            locale: itLocale,
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
            initialView: "dayGridMonth",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek",
            },
            events: datos
        });

        calendar.render();
    }
});
