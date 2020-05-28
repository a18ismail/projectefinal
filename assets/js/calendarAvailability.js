//ASSETS CSS

//IMPORTACIONS CSS PLUGINS
import 'admin-lte/plugins/fontawesome-free/css/all.css';
import '@fullcalendar/core/main.css';
import '@fullcalendar/list/main.css';
import '@fullcalendar/daygrid/main.css';
import '@fullcalendar/bootstrap/main.css';
import '@fullcalendar/timegrid/main.css';
import 'toastr/build/toastr.css';

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
import toastr from 'toastr/toastr.js';


document.addEventListener('DOMContentLoaded', function() {

    //Rebre disponiblitat
    function getAvailability(){
        return axios.get('getAvailability')
            .then( response => {
                var receivedAvailability = response.data;
                return receivedAvailability;
            })
            .catch( error => {
                console.log(error);
            });
    }

    //Carregar disponiblitat de l'empleat registrat
    function loadAvailability(){
        //Netejar calendari abans de carregar
        calendar.removeAllEvents();

        getAvailability().then( calendarEvents => {
            var events = calendarEvents;
            events.forEach(function(event) {
                calendar.addEvent({
                    title: 'Disponible',
                    start: new Date(event.dateStart),
                    end: new Date(event.dateEnd),
                    allday: true
                });
            }, calendar);
        })
    }

    //Guardar elements HTML en variables
    var containerEl = document.getElementById('external-events');
    var calendarEl = document.getElementById('calendar');
    let draggableEl = document.getElementById('draggable-el');

    //Activar funció de drag/arrastrar
    new Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function(eventEl) {
            return {
                title: eventEl.innerText
            };
        }
    });

    //Crear calendari de tipus FullCalendar
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
        dayMaxEvents: 1,
        defaultView: 'dayGridMonth',
        validRange: {
            start: new Date()
        },
        views: {
            month: {
                eventLimit: 1
            }
        },
        events: [ /* event data */ ],
        eventOverlap: function(stillEvent, movingEvent) {
            return stillEvent.allDay && movingEvent.allDay;
        },
        droppable: true,
        drop: function(event) {
            console.log(event);
        },
        businessHours: {
            daysOfWeek: [ 1, 2, 3, 4, 5 ],
            startTime: '06:00',
            endTime: '21:00'
        },
        displayEventTime: false
    });

    //Mostrar calendari
    calendar.render();

    //Carregar disponiblitat de l'empleat registrat
    loadAvailability();

    //Enviar disponibiilitat
    function sendAvailability(availability){
        axios.post('/saveAvailability', {
            events: JSON.stringify(availability)
        })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    //Enviar disponibilitat
    //Conseguir events de disponibilitat i formatejar per enviar
    document.getElementById('saveAvailability').addEventListener('click', function () {
        var eventsCalendar = calendar.getEvents();
        var arrayOfAvailability = [];
        eventsCalendar.forEach(function(event) {
            var rangeOfAvailability = {
                title: event.title,
                dateStart: event._instance.range.start,
                dateEnd: event._instance.range.start
            }

            arrayOfAvailability.push(rangeOfAvailability);
        }, arrayOfAvailability);


        //Enviar disponiblitat
        sendAvailability(arrayOfAvailability);

        //Tornar a carregar la disponibilitat al calendari
        loadAvailability();

        toastr.success('Calendari actualitzat correctament!');
    })

    document.getElementById('eventsTrash').addEventListener('click', function () {
        //Funció per netejar el calendari i eliminar tots els Event
        calendar.removeAllEvents();
    })



});