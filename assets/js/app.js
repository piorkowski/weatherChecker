import '../css/app.scss';

import $ from 'jquery';
import 'bootstrap';

$('.dropdown-toggle').dropdown();

const faviconPath = require('../../public/favicon.ico');

const html = `<link rel="shortcut icon" href="${faviconPath}"/>`;
