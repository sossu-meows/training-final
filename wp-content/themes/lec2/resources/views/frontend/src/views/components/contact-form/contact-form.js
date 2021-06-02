import { eliComponent, AbstractComponent } from '@/@core/web/eli-component';
import AjaxService from '@/js/services/AjaxService';

/**
 *
 *
 * @class ContactForm
 */
@eliComponent({
  selector: '.js-contact-form',
})
class ContactForm extends AbstractComponent {
  selfClass = '.contact-form';

  /**
   * Main init contact map
   */
  init() {
    this.$contactForm = this.find('form');
    this.initValidationRule();
  }

  /**
   * Check if current form is in modal
   */
  isInModal() {
    return this.$contactForm.closest('.modal').length;
  }


  /**
   * Init contact form validation rule
   */
  initValidationRule() {
    const { $contactForm } = this;
    $contactForm.formValidator({
      schema: (yup) => {
        return {
          salutation: yup.string().required(),
          firstname: yup.string().required(),
          lastname: yup.string().required(),
          street: yup.string().required(),
          postcode: yup.string().required(),
          city: yup.string().required(),
          country: yup.string().required(),
          email: yup.string().email().required(),
          message: yup.string().required(),
          privacy: yup.common.requiredCheck(),
        };
      },
      onSuccess: async ({ data, form }) => {
        $contactForm.loading(true);
        try {
          let res = null;
          res = await AjaxService.getInstance().sendContact(data, {
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
}

export default ContactForm;
