import { setupPlugin } from './../jquery-extends/helpers';
import FormValidator from './classes/FormValidator';

export default FormValidator;

// expose to jquery-extends
setupPlugin('formValidator', FormValidator);
