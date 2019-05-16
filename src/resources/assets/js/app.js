/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('select2');
require('select2/dist/js/i18n/ru');
window.Sortable = require('sortablejs');
window.Maphilight = require('maphilight');
window.Promise = require('promise-polyfill').default;
window.Summernote = require('summernote/dist/summernote-bs4');
require('summernote/lang/summernote-ru-RU');
window.moment = require('moment');
window.datetimepicker = require('tempusdominus-bootstrap-4');
window.IMask = require('imask/dist/imask.min');

window.mask_phones = function () {
    let phones = document.querySelectorAll('.phone-mask');
    for (let i = 0; i < phones.length; i++) {
        new IMask(phones[i], {mask: phones[i].getAttribute('data-mask')});
    }
};
import Parser from './parser';
window.Parser = Parser;
import route from './router';
window.route = route;
require('./site');