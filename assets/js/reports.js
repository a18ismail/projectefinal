//ASSETS CSS

//IMPORTACIONS CSS PLUGINS
import 'admin-lte/plugins/fontawesome-free/css/all.css';
import 'admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css';

//IMPORTACIONS CSS PLANTILLA
import '../css/adminlte.css';

//CSS PERSONALITZAT D'AQUESTA PAGINA
import '../css/reports.css'

// ASSETS JS

//IMPORTACIONS DE LLIBRERIES I PLUGINS JS
import 'admin-lte/plugins/jquery/jquery';
import 'admin-lte/plugins/jquery-ui/jquery-ui.min';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min';
import 'admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min';

//IMPORTS JS PLANTILLA
import './adminlte.js';

//JS PERSONALITZAT D'AQUESTA PAGINA
import axios from 'axios/dist/axios';
import toastr from 'toastr/toastr.js';

function getCompletedHours(){
    return axios.get('getCompletedHours')
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

function loadWorkedHours(){
    getCompletedHours().then( data => {
        document.getElementById('hoursCompleted').innerHTML = data;
        if( data == 0 ){
            document.getElementById('hoursCompletedProgress').setAttribute('style', 'width: 0%');
        }else if( data >=1 && data <=10 ){
            document.getElementById('hoursCompletedProgress').setAttribute('style', 'width: 10%');
        }else if( data >=50 && data <=70 ){
            document.getElementById('hoursCompletedProgress').setAttribute('style', 'width: 50%');
        }else if( data >=80 && data <=100 ){
            document.getElementById('hoursCompletedProgress').setAttribute('style', 'width: 70%');
        }else if( data >=90 && data <=110 ){
            document.getElementById('hoursCompletedProgress').setAttribute('style', 'width: 88%');
        }else if( data >=111 && data <=119 ){
            document.getElementById('hoursCompletedProgress').setAttribute('style', 'width: 90%');
        }else if( data >=120 ){
            document.getElementById('hoursCompletedProgress').setAttribute('style', 'width: 100%');
        }
    })
}

function getSalaryData(){
    return axios.get('getSalaryData')
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

function loadSalaryData(){
    getSalaryData().then( salaryObject => {
        console.log(salaryObject);
        document.getElementById('totalIncomeMonth').innerText = salaryObject.totalIncomeMonth + " €";
        document.getElementById('totalIncomeYear').innerText = salaryObject.totalIncomeYear + " €";
        document.getElementById('totalIncomeLastMonth').innerText = salaryObject.totalIncomeLastMonth + " €";
    });
}

document.addEventListener('DOMContentLoaded', function() {

    /*getRemainingTimeOperation().then( data => {
        //console.log(data);
        displayCountdownClock(data);
    })*/

    //Carregar gràfica d'hores treballades
    loadWorkedHours();

    //Carregar dades d'estadistiques
    loadSalaryData();
})


