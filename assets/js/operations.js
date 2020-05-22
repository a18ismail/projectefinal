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
var $ = require('jquery');

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
        console.log(id);
    });
} );

$(function () {
    /*$('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });*/
});
