require("./bootstrap");

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import toastr from "toastr";

window.toastr = toastr;

import jquery from "jquery";

window.jquery = jquery;

window.Chart = require('chart.js');

import './myjs/calendar';
import './myjs/show_chart';