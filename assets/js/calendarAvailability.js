//ASSETS CSS

//IMPORTACIONS CSS PLUGINS
import 'admin-lte/plugins/fontawesome-free/css/all.css';
import '@fullcalendar/core/main.css';
import '@fullcalendar/list/main.css';
import '@fullcalendar/daygrid/main.css';
import '@fullcalendar/bootstrap/main.css';
import '@fullcalendar/timegrid/main.css';

//IMPORTACIONS CSS PLANTILLA
import '../css/adminlte.css';

//CSS PERSONALITZAT D'AQUESTA PAGINA
import '../css/calendarAvailability.css'

// ASSETS JS

//IMPORTACIONS DE LLIBRERIES I PLUGINS JS
import 'admin-lte/plugins/jquery/jquery.js';
import 'admin-lte/plugins/jquery-ui/jquery-ui.js';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'moment/moment.js';

//IMPORTS JS PLANTILLA
import './adminlte.js';

//JS PERSONALITZAT D'AQUESTA PAGINA

import { Calendar } from '@fullcalendar/core';
import interactionPlugin, { Draggable } from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import bootstrapPlugin from '@fullcalendar/bootstrap';
import caLocale from '@fullcalendar/core/locales/ca';
import axios from 'axios/dist/axios';

document.addEventListener('DOMContentLoaded', function() {

    //Crear calendari de tipus FullCalendar
    var containerEl = document.getElementById('external-events');
    var calendarEl = document.getElementById('calendar');
    let draggableEl = document.getElementById('draggable-el');

    new Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function(eventEl) {
            return {
                title: eventEl.innerText
            };
        }
    });

    var calendar = new Calendar(calendarEl, {
        plugins: [ interactionPlugin, dayGridPlugin, bootstrapPlugin ],
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        themeSystem: 'bootstrap',
        locale: caLocale,
        navLinks: true,
        editable: true,
        eventLimit: true,
        events: [ /* event data */ ],
        eventOverlap: function(stillEvent, movingEvent) {
            return stillEvent.allDay && movingEvent.allDay;
        },
        businessHours: {
            daysOfWeek: [ 1, 2, 3, 4, 5 ],
            startTime: '06:00',
            endTime: '21:00'
        },
        droppable: true,
        drop: function(info) {
            console.log(info);
        }
    });

    //Mostrar calendari
    calendar.render();

    //Activar funció de drag/arrastrar

});