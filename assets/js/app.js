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
import axios from 'axios/dist/axios';
import toastr from 'toastr/toastr.js';


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

function getRemainingTimeOperation(){
    return axios.get('getRemainingTimeOperation')
        .then( response => {
            if( response!='false' ){
                var receivedData = response.data;
                return receivedData;
            }else{
                toastr.error('Hi ha hagut un error al servidor! Torna-ho a intentar.', 'Error de connexió!');
            }
        })
        .catch( error => {
            toastr.error('Hi ha hagut un error al servidor! Torna-ho a intentar.', 'Error de connexió!');
            console.log(error);
        });
}

function displayCountdownClock(date){

    //Definir la data on acaba el contador
    var countDownDate = new Date(date).getTime();

    //Definir l'interval per actualitzar el rellotge
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (distance < 0) {
            clearInterval(x);
            document.getElementById('clockLeft').innerText = "Contador expirat";
        }else{
            if( days > 0 ){
                document.getElementById('clockLeft').innerText = days + " dies " + hours + " hores " + minutes + " minuts " + seconds + " segons ";
            }else{
                document.getElementById('clockLeft').innerText = hours + " hores " + minutes + " minuts " + seconds + " segons ";
            }
        }

    }, 1000);
}1

document.addEventListener('DOMContentLoaded', function() {

    //Carregar contador per la proxima operativa
    getRemainingTimeOperation().then( data => {
        console.log(data);
        displayCountdownClock(data);
    })

    //Carregar hora actual
    currentTime();
})



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