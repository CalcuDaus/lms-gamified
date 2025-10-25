import axios from 'axios';

import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";
import "tippy.js/animations/shift-toward.css";
import "tippy.js/themes/material.css";

window.tippy = tippy;
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
