import { eliComponent, AbstractComponent } from '@/@core/web/eli-component';
import AjaxService from '@/js/services/AjaxService';

/**
 *
 *
 * @class ContactForm
 */
@eliComponent({
  selector: '.js-modal-form',
})
class ContactForm extends AbstractComponent {
  selfClass = '.modal-form';

  /**
   * Main init contact map
   */
  init() {
    this.$ContactBlock = $('#contactForm');
    this.$contactForm = this.$ContactBlock.find('form');

    this.$RequestBlock = $('#requestForm');
    this.$requestForm = this.$RequestBlock.find('form');


    this.initValidationRule();
    this.initValidationRuleRequestForm();
  }

  /**
   * Check if current form is in modal
   */
  isInModal() {
    return this.$contactForm.closest('.modal').length;
  }

  isInModalRequest() {
    return this.$requestForm.closest('.modal').length;
  }

  /**
   * Init contact form validation rule
   */
  initValidationRule() {
    const { $contactForm } = this;

    $contactForm.formValidator({
      schema: (yup) => {
        return {
          firstname: yup.string().required(),
          lastname: yup.string().required(),
          email: yup.string().email().required(),
          message: yup.string().required(),
          data_protection: yup.common.requiredCheck(),
        };
      },
      onSuccess: async ({ data, form }) => {
        $contactForm.loading(true);
        try {
          let res = null;
          res = await AjaxService.getInstance().sendRequestACall(data, {
            noMessage: true,
          });
          global.swal.fire({
            icon: 'success',
            text: res.message,
            showConfirmButton: false,
            timer: 3000,
          });
          // RESET UI
          form.reset();
          if (this.isInModal()) {
            this.$contactForm.closest('.modal').modal('toggle');
          }
        } catch (error) {
          global.swal.fire({
            icon: 'error',
            text: error.message,
            showConfirmButton: false,
            timer: 3000,
          });
          console.error(error);
        }
        $contactForm.loading(false);
      },
    });
  }

  initValidationRuleRequestForm() {
    const { $requestForm } = this;

    $requestForm.formValidator({
      schema: (yup) => {
        return {
          firstname: yup.string().required(),
          lastname: yup.string().required(),
          email: yup.string().email().required(),
          message: yup.string().required(),
          data_protection: yup.common.requiredCheck(),
        };
      },
      onSuccess: async ({ data, form }) => {
        $requestForm.loading(true);
        try {
          let res = null;
          res = await AjaxService.getInstance().sendRequestEmail(data, {
            noMessage: true,
          });
          global.swal.fire({
            icon: 'success',
            text: res.message,
            showConfirmButton: false,
            timer: 6000,
          });
          // RESET UI
          form.reset();
          if (this.isInModalRequest()) {
            this.$requestForm.closest('.modal').modal('toggle');
          }
        } catch (error) {
          global.swal.fire({
            icon: 'error',
            text: error.message,
            showConfirmButton: false,
            timer: 6000,
          });
          console.error(error);
        }
        $requestForm.loading(false);
      },
    });
  }
}

export default ContactForm;
