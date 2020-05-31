//ASSETS CSS

//IMPORTACIONS CSS PLUGINS
import 'admin-lte/plugins/fontawesome-free/css/all.css';
import 'admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css';
import 'toastr/build/toastr.css';

//IMPORTACIONS CSS PLANTILLA
import '../css/adminlte.css';

//CSS PERSONALITZAT D'AQUESTA PAGINA

// ASSETS JS

//IMPORTACIONS DE LLIBRERIES I PLUGINS JS
import 'admin-lte/plugins/jquery/jquery';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min';

//IMPORTS JS PLANTILLA
import './adminlte.js';

//JS PERSONALITZAT D'AQUESTA PAGINA
import 'admin-lte/plugins/jquery/jquery';
import 'admin-lte/plugins/jquery-ui/jquery-ui.min';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min';
import axios from 'axios/dist/axios.js';
import toastr from 'toastr/toastr.js';


document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btnRegister').addEventListener('click', function () {
        let email = document.getElementById('registerEmail').value;
        let password = document.getElementById('registerPassword').value;
        let name = document.getElementById('registerName').value;
        let surnames = document.getElementById('registerSurnames').value;
        var formData = {
            registerEmail: email,
            registerPassword: password,
            registerName: name,
            registerSurnames: surnames
        };
        if( email == "" || password === "" || name === "" || surnames === "" ){
            toastr.error('Has d\'omplir tots els camps.', 'Error de registre!');
        }else{
            axios.post('register', {
                data: JSON.stringify(formData)
            })
                .then(function (response) {
                    console.log(response.data);
                    if(response.data == true){
                        toastr.success('Ja pots usar el teu compte!', 'Registre completat!');
                    }else{
                        toastr.error('Hi ha hagut un error al servidor! Torna-ho a intentar.', 'Error de registre!');
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    })
})

