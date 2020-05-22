//ASSETS CSS

//IMPORTACIONS CSS PLUGINS
import 'admin-lte/plugins/fontawesome-free/css/all.css';
import 'admin-lte/plugins/jqvmap/jqvmap.css';
import 'admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css';

//IMPORTACIONS CSS PLANTILLA
import '../css/adminlte.css';

//CSS PERSONALITZAT D'AQUESTA PAGINA
import '../css/app.css'

// ASSETS JS

//IMPORTACIONS DE LLIBRERIES I PLUGINS JS
import 'admin-lte/plugins/jquery/jquery';
import 'admin-lte/plugins/jquery-ui/jquery-ui.min';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min';
import 'admin-lte/plugins/jqvmap/jquery.vmap.js';
import 'admin-lte/plugins/jqvmap/maps/jquery.vmap.europe.js';
import 'admin-lte/plugins/jquery-knob/jquery.knob.min.js';
import 'admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min';


//IMPORTS JS PLANTILLA
import './adminlte.js';
import './pages/dashboard.js';

//JS PERSONALITZAT D'AQUESTA PAGINA

//Càlcul del rellotge
function currentTime() {
    var date = new Date(); /* creating object of Date class */
    var hour = date.getHours();
    var min = date.getMinutes();
    var sec = date.getSeconds();
    hour = updateTime(hour);
    min = updateTime(min);
    sec = updateTime(sec);
    document.getElementById("clock").innerText = "  " + hour + " : " + min + " : " + sec; /* adding time to the div */
    var t = setTimeout(function(){ currentTime() }, 1000); /* setting timer */
}

function updateTime(k) {
    if (k < 10) {
        return "0" + k;
    }
    else {
        return k;
    }
}

currentTime();

///////////////////////////////////////////////////////////////////////////////////

//IMPORTS DISPONIBLES JS (No estan tots aqui)
//import 'admin-lte/plugins/jquery/jquery';
//import 'admin-lte/plugins/jquery-ui/jquery-ui.min';
//import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min';
//import 'moment/dist/moment.js';
//import 'admin-lte/plugins/chart.js/Chart.min';
//import 'admin-lte/plugins/sparklines/sparkline';
//import 'admin-lte/plugins/jquery-knob/jquery.knob.min';
//import 'admin-lte/plugins/daterangepicker/daterangepicker';
//import 'admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min';
//import 'admin-lte/plugins/summernote/summernote-bs4.min';
//import 'admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min';

//IMPORTS DISPONIBLES CSS (No estan tots aqui)
//import 'admin-lte/plugins/fontawesome-free/css/all.min.css';
//import 'admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css';
//import 'admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css';
//import 'admin-lte/plugins/jqvmap/jqvmap.min.css';
//import 'admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css';
//import 'admin-lte/plugins/daterangepicker/daterangepicker.css';
//import 'admin-lte/plugins/summernote/summernote-bs4.css';