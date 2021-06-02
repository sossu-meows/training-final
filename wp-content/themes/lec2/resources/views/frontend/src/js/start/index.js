import './js-setup';
import APP_CONFIG from './config';
import { checkViewport } from '../common/viewport/functions';
import toast from '../common/helpers/toast';
import Swal from '../common/helpers/sweetalert';
import datepicker from '../common/helpers/datepicker';

// Make global variables
global.viewport = checkViewport();
global.APP_CONFIG = APP_CONFIG;
global.toast = toast;
global.swal = Swal;
global.datepicker = datepicker;
