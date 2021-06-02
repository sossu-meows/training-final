import loadController from '@/@core/web/controllers/load-controller';
import './start';


// window.eli.controller returned from server
loadController(window.eli && window.eli.controller);
