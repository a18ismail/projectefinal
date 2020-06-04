//ASSETS CSS

//IMPORTACIONS CSS PLUGINS
import 'admin-lte/plugins/fontawesome-free/css/all.css';
import 'toastr/build/toastr.css';

//IMPORTACIONS CSS PLANTILLA
import '../css/adminlte.css';

//CSS PERSONALITZAT D'AQUESTA PAGINA
import '../css/settings.css'

// ASSETS JS

//IMPORTACIONS DE LLIBRERIES I PLUGINS JS
import 'admin-lte/plugins/jquery/jquery.js';
import 'admin-lte/plugins/jquery-ui/jquery-ui.js';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'moment/moment.js';
import axios from 'axios/dist/axios';
import toastr from 'toastr/toastr.js';

//IMPORTS JS PLANTILLA
import './adminlte.js';

//JS PERSONALITZAT D'AQUESTA PAGINA
var $ = require('jquery');

document.addEventListener('DOMContentLoaded', function() {

    //Canviar la contrasenya
    document.getElementById('btnChangePassword').addEventListener('click', function () {

        var formData = {
            currentPassword: document.getElementById('currentPassword').value,
            newPassword: document.getElementById('newPassword').value,
            newPasswordConfirm: document.getElementById('newPasswordConfirm').value,
            email: document.getElementById('email').value
        };
        axios.post('changePassword', {
            data: JSON.stringify(formData)
        })
            .then(function (response) {
                console.log(response.data);
                if(response.data == true) {
                    toastr.success('La teva contrasenya ha canviat correctament', 'Canvi realitzat correctament!');
                    toastr.options.closeButton = true;
                    toastr.options.closeHtml = '<button><i class="fas fa-times"></i></button>';
                    document.getElementById("closeChangePasswordModal").click();
                }else if(response.data == 'errorConfirmPassword'){
                    toastr.error('Les contrasenyes noves introduides no concorden!', 'Error!');
                    toastr.options.closeButton = true;
                    toastr.options.closeHtml = '<button><i class="fas fa-times"></i></button>';
                }else{
                    toastr.error('La contrasenya actual introduida és incorrecte!', 'Error!');
                    toastr.options.closeButton = true;
                    toastr.options.closeHtml = '<button><i class="fas fa-times"></i></button>';
                }
            })
            .catch(function (error) {
                toastr.error('Hi ha hagut un error al servidor! Torna-ho a intentar.', 'Error de connexió!');
                console.log(error);
            });
    })

    //Descarregar dades de l'empleat registrat
    document.getElementById('downloadData').addEventListener('click', function () {

        toastr.warning('Aquesta funcionalitat és per la versió PRO de la plataforma!');

        //Petició per demanar descarrega de dades
        /*var formData = {
            email: document.getElementById('email').value
        }
        let urlProd = window.location.host + '/downloadEmployeeData';
        axios.post(urlProd, {
            data: JSON.stringify(formData)
        })
            .then(function (response) {
                console.log(response.data);
            })
            .catch(function (error) {
                console.log(error);
            });*/

        //downloadObjectAsJson();
    })

    //Eliminar compte
    document.getElementById('deleteAccount').addEventListener('click', function () {
        toastr.warning('Aquesta funcionalitat és per la versió PRO de la plataforma!');
    })

    //Funció per crear un fitxer .JSON amb les dades rebudes
    function downloadObjectAsJson(exportObj, exportName){
        var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(exportObj));
        var downloadAnchorNode = document.createElement('a');
        downloadAnchorNode.setAttribute("href",     dataStr);
        downloadAnchorNode.setAttribute("download", exportName + ".json");
        document.body.appendChild(downloadAnchorNode); // required for firefox
        downloadAnchorNode.click();
        downloadAnchorNode.remove();
    }

});