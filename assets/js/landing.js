//ASSETS CSS

//IMPORTACIONS CSS PLUGINS
import 'admin-lte/plugins/fontawesome-free/css/all.css';
import 'toastr/build/toastr.css';

//IMPORTACIONS CSS PLANTILLA
import '../css/adminlte.css';

//CSS PERSONALITZAT D'AQUESTA PAGINA
import '../css/landing.css';

// ASSETS JS

//IMPORTACIONS DE LLIBRERIES I PLUGINS JS
import 'admin-lte/plugins/jquery/jquery';
import 'admin-lte/plugins/jquery-ui/jquery-ui.min';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min';
import axios from 'axios/dist/axios.js';
import toastr from 'toastr/toastr.js';

//JS PERSONALITZAT D'AQUESTA PAGINA


document.getElementById('btnRegister').addEventListener('click', function () {
    var formData = {
        registerEmail: document.getElementById('registerEmail').value,
        registerPassword: document.getElementById('registerPassword').value,
        registerName: document.getElementById('registerName').value,
        registerSurnames: document.getElementById('registerSurnames').value
    };
    axios.post('/register', {
        data: JSON.stringify(formData)
    })
        .then(function (response) {
            console.log(response.data);
            if(response.data == true){
                toastr.success('Ja pots usar el teu compte!', 'Registre completat!');
                toastr.options.closeButton = true;
                toastr.options.closeHtml = '<button><i class="fas fa-times"></i></button>';
                document.getElementById("closeRegisterModal").click();
            }else{
                toastr.error('Hi ha hagut un error al servidor! Torna-ho a intentar.', 'Error de registre!');
                toastr.options.closeButton = true;
                toastr.options.closeHtml = '<button><i class="fas fa-times"></i></button>';
            }
        })
        .catch(function (error) {
            console.log(error);
        });
})
