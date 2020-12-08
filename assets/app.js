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
