//ASSETS CSS

//IMPORTACIONS CSS PLUGINS
import 'admin-lte/plugins/fontawesome-free/css/all.css';
import 'admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css';

//IMPORTACIONS CSS PLANTILLA
import '../css/adminlte.css';

//CSS PERSONALITZAT D'AQUESTA PAGINA
import '../css/mail.css'

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

//Funció per demanar contacte amb els seus missatges, utilitzant promises
function getContactInfo(contact_id){
    return axios.post('getMessages', {
        contactId: contact_id
    }).then( response => {
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

document.addEventListener('DOMContentLoaded', function() {

    //Afegir un EventListener a tots els contacts
    var contacts = document.getElementsByClassName('messageContact');

    //Carregar contacte clickat
    var loadContact = function() {
        var contactId = this.getAttribute("id");
        console.log(contactId);

        //Petició per conseguir Contacte i els seus missatges
        getContactInfo(contactId).then( contactObject => {
            console.log(contactObject);
        })

    };

    //Afegir un EventListener a tots els contacts
    Array.from(contacts).forEach(function(contact) {
        contact.addEventListener('click', loadContact);
    });


    //Button per carregar missatges nous
    var updateChat = document.getElementById("updateChat");

})

