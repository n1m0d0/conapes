require("./bootstrap");

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import jquery from "jquery";

window.jquery = jquery;

import toastr from "toastr";

window.toastr = toastr;

window.Chart = require('chart.js');

import './myjs/show_chart';

import './myjs/calendar';