/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// any CSS you import will output into a single css file (app.css in this case)
import './scss/app.scss';
const $ = require('jquery');
import './bootstrap';
require('bootstrap');



// Method for replacing the name of the input
$('.custom-file-input').on('change', function(e) {
    var inputFile = e.currentTarget;
    $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name);
});

const apiUrl = 'https://geo.api.gouv.fr/communes?codePostal=';
const format = '&format=json';

let zipcode = $('.zipCode'); let city = $('.city'); let errorMessage = $('#error-message'); 

    $(zipcode).on('blur', function(){
        let code = $(this).val();
        //console.log(code);
        let url = apiUrl+code+format;
        //console.log(url);

        fetch(url, {method: 'get'}).then(response => response.json()).then(results => {
            //console.log(results);
            $(city).find('option').remove();
            if(results.length){
                $(errorMessage).text('').hide();
                $.each(results, function(key, value){
                    //console.log(value);
                    console.log(value.nom);
                    $(city).append('<option value="'+value.nom+'">'+value.nom+'</option>');
                });
            }
            else{
                if($(zipcode).val()){
                    console.log('Erreur de code postal.');
                    $(errorMessage).text('Aucune commmune avec ce code postal.').show();
                }
                else{
                    $(errorMessage).text('').hide();
                }
            }
        }).catch(err => {
            console.log(err);
            $(city).find('option').remove();
        });
    });
