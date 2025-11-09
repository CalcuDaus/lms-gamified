import axios from 'axios';

import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";
import "tippy.js/animations/shift-toward.css";
import "tippy.js/themes/material.css";
import DataTable from "datatables.net-dt";

import Swal from "sweetalert2";

window.DataTable = DataTable;
window.Swal = Swal;
window.tippy = tippy;
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
