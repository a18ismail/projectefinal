//ASSETS CSS

//IMPORTACIONS CSS PLUGINS
import 'admin-lte/plugins/fontawesome-free/css/all.min.css';
import 'admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css';
import 'admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'

//IMPORTACIONS CSS PLANTILLA
import '../css/adminlte.css';

//CSS PERSONALITZAT D'AQUESTA PAGINA
import '../css/operations.css';

// ASSETS JS

//IMPORTACIONS DE LLIBRERIES I PLUGINS JS

import 'admin-lte/plugins/jquery/jquery';
import 'admin-lte/plugins/jquery-ui/jquery-ui.min';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min';
import 'admin-lte/plugins/datatables/jquery.dataTables.min.js';
import 'admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js';
import 'admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js';
import 'admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js';

//IMPORTS JS PLANTILLA
import './adminlte.js';

//JS PERSONALITZAT D'AQUESTA PAGINA
import axios from 'axios/dist/axios';
import toastr from 'toastr/toastr.js';
var $ = require('jquery');

//Mostrar taula utilitzant el plugin DataTables amb Jquery
$(document).ready(function() {
    $("#operationsList").DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "searching": true,
        "info": false,
        "lengthChange": true,
    });

    $('#operationsList > tbody  > tr > td > button').each(function(index, tr) {
        var id = $(this).attr('data');
        $(this).click(function() {
            $('#'+id).modal('show');
        });

    });

} );

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

})

