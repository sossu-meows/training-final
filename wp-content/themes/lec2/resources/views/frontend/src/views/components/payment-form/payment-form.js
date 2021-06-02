import { eliComponent, AbstractComponent } from '@/@core/web/eli-component';
import AjaxService from '@/js/services/AjaxService';

/**
 *
 *
 * @class PaymentForm
 */
@eliComponent({
  selector: '.js-payment-form',
})
class PaymentForm extends AbstractComponent {
  selfClass = '.payment-form';

  /**
   * Main init payment map
   */
  init() {
    this.$paymentForm = this.find('form');
    const $checkBilling = $('#billing');
    this.initValidationRule();
    if ($checkBilling.is(':checked')) {
      this.initValidationRuleForBilling();
    }
    this.checkBillingForm();
  }

  /**
   * Check if current form is in modal
   */
  isInModal() {
    return this.$paymentForm.closest('.modal').length;
  }

  /**
   * Init payment form validation rule
   */
  initValidationRule() {
    const { $paymentForm } = this;
    $paymentForm.formValidator({
      schema: (yup, formValidator) => {
        const formData = formValidator.getData();
        const isDifferentBilling = formData.billing;
        const isRoomReservation = formData.roomReservation;

        const billingAddressRules = {
          billing_salutation: yup.string().required(),
          billing_firstname: yup.string().required(),
          billing_lastname: yup.string().required(),
          billing_street: yup.string().required(),
          billing_postcode: yup.string().required(),
          billing_city: yup.string().required(),
          billing_country: yup.string().required(),
          billing_email: yup.string().email().required(),
        };

        const roomReservationrules = {
          arrivalDatepicker: yup.string().required(),
          departureDatepicker: yup.string().required(),
        };

        return {
          shipping_salutation: yup.string().required(),
          shipping_firstname: yup.string().required(),
          shipping_lastname: yup.string().required(),
          shipping_street: yup.string().required(),
          shipping_postcode: yup.string().required(),
          shipping_city: yup.string().required(),
          shipping_country: yup.string().required(),
          shipping_email: yup.string().email().required(),
          terms_and_conditions: yup.common.requiredCheck(),
          agreement: yup.common.requiredCheck(),
          billing: yup.common.checkbox(),
          ...(isDifferentBilling ? billingAddressRules : {}),
          ...(isRoomReservation ? roomReservationrules : {}),
        };
      },
      onSuccess: async ({ data, form }) => {
        $paymentForm.loading(true);
        try {
          const title = global.eli.thank;
          const message = global.eli.thankDescription;
          let res = null;
          res = await AjaxService.getInstance().sendPayment(data, {
            noMessage: true,
          });
          global.swal.fire({
            title,
            html: message,
            width: 670,
            confirmButtonColor: '#7BE1D1',
            showConfirmButton: true,
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
        $paymentForm.loading(false);
      },
    });
  }

  checkBillingForm() {
    const $checkBilling = $('#billing');
    const $showBilling = $('.billing');

    const $checkRoom = $('#roomReservation');
    const $showRoom = $('.room-reservation');

    const today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

    $('#arrivalDatepicker').datepicker({
      uiLibrary: 'bootstrap4',
      minDate: today,
    });

    $('#departureDatepicker').datepicker({
      uiLibrary: 'bootstrap4',
      minDate: today,
    });

    $checkBilling.click(() => {
      $showBilling.slideToggle('slow');
    });

    $checkRoom.click(() => {
      $showRoom.slideToggle('slow');
    });
  }
}

export default PaymentForm;
