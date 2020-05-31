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
var $ = require('jquery');

import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import bootstrapPlugin from '@fullcalendar/bootstrap';
import caLocale from '@fullcalendar/core/locales/ca';
import axios from 'axios/dist/axios';
import toastr from 'toastr/toastr.js';

//Funció generalitzada per enviar una petició per assignar, eliminar i confirmar operatives operatives
function setOperation(url, code){
    axios.post(url, {
        operationCode: code
    })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            toastr.error('Hi ha hagut un error al servidor! Torna-ho a intentar.', 'Error de connexió!');
            console.log(error);
        });
}

document.addEventListener('DOMContentLoaded', function() {

    //Funció per obtenir operatives utilitzant promises
    function getOperations(){
        let urlProd = window.location.host + '/getEvents';
        return axios.get('getEvents')
            .then( response => {
                var receivedOperations = response.data;
                var events = createEvents(receivedOperations);
                return events;
            })
            .catch( error => {
                toastr.error('Hi ha hagut un error al servidor! Torna-ho a intentar.', 'Error de connexió!');
                console.log(error);
            });
    }

    //Funció per formatejar i netejar les operacions en objectes Event
    function createEvents(receivedOperations){
        var arrayOfEvents = [];
        receivedOperations.forEach( function(operation) {
            var newEvent = {
                id: operation.code,
                title: operation.title,
                start: operation.dateStart.date,
                end: operation.dateEnd.date,
                status: operation.status
            }
            arrayOfEvents.push(newEvent);
        }, arrayOfEvents);
        return arrayOfEvents;
    }

    //Crear calendari de tipus FullCalendar
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin, bootstrapPlugin ],
        customButtons: {
            updateButton: {
                text: 'Actualitzar',
                click: function() {
                    calendar.removeAllEvents();
                    load();
                    toastr.success('Calendari actualitzat correctament!');
                }
            }
        },
        header: {
            left: 'prev,next today, updateButton',
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
        events: [],
        eventClick:  function(info) {
            $('#'+info.event.id).modal('show');
        }
    });

    //Conseguir Events ja preparats, utilitzant promises
    function load(){
        getOperations().then( events => {
            var calendarEvents = events;
            calendarEvents.forEach(function(event) {
                //Afegir events creats al calendari creat
                if(event.status == 'confirmed'){
                    event.backgroundColor = '#28a745';
                }else if(event.status == 'reserved'){
                    event.backgroundColor = '#ffc107';
                }else{
                    event.backgroundColor = '#007bff';
                }
                calendar.addEvent(event);
            }, calendar);
        })
    }
    load();

    //Mostrar calendari
    calendar.render();

    //Carregar funcionalitats dels modals de cada operativa
    //Per assignar una operativa disponible
    var assignOperationButtons = document.getElementsByClassName('assignOperation');

    Array.from(assignOperationButtons).forEach(function(button) {
        let operationCode = button.getAttribute('data-id');
        button.addEventListener('click', function () {
            setOperation('assignOperation', operationCode);
        }, operationCode);
    });

    //Per eliminar una operativa assignada
    var deleteOperationButtons = document.getElementsByClassName('deleteOperation');

    Array.from(deleteOperationButtons).forEach(function(button) {
        let operationCode = button.getAttribute('data-id');
        button.addEventListener('click', function () {
            setOperation('deleteOperation', operationCode);
        }, operationCode);
    });

    //Per confirmar una operativa assignada
    var confirmOperationButtons = document.getElementsByClassName('confirmOperation');

    Array.from(confirmOperationButtons).forEach(function(button) {
        let operationCode = button.getAttribute('data-id');
        button.addEventListener('click', function () {
            setOperation('confirmOperation', operationCode);
        }, operationCode);
    });

});