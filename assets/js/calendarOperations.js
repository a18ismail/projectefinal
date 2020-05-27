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
import '../css/calendarOperations.css'

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
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import bootstrapPlugin from '@fullcalendar/bootstrap';
import caLocale from '@fullcalendar/core/locales/ca';
import axios from 'axios/dist/axios';

document.addEventListener('DOMContentLoaded', function() {

    //Funció per obtenir operatives utilitzant promises
    function getOperations(){
        return axios.get('getEvents')
            .then( response => {
                var receivedOperations = response.data;
                var events = createEvents(receivedOperations);
                return events;
            })
            .catch( error => {
                console.log(error);
            });
    }

    //Funció per formatejar i netejar les operacions en objectes Event
    function createEvents(receivedOperations){
        var arrayOfEvents = [];
        receivedOperations.forEach( function(operation) {
            var newEvent = {
                title: operation.title,
                start: operation.dateStart.date,
                end: operation.dateEnd.date
            }
            arrayOfEvents.push(newEvent);
        }, arrayOfEvents);
        return arrayOfEvents;
    }

    //Crear calendari de tipus FullCalendar
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin, bootstrapPlugin ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        themeSystem: 'bootstrap',
        locale: caLocale,
        navLinks: true,
        editable: false, //Editar posició events
        eventLimit: true,
        views: {
            timeGrid: {
                eventLimit: 2
            }
        },
        events: [
            {
                id: 'test',
                title: 'Operativa de prova',
                start: '2020-05-26'
            }
        ]
    });

    //Conseguir Events ja preparats, utilitzant promises
    getOperations().then( events => {
        var calendarEvents = events;
        calendarEvents.forEach(function(event) {
            //Afegir events creats al calendari creat
            calendar.addEvent(event);
        }, calendar);
    })

    //Mostrar calendari
    calendar.render();
});