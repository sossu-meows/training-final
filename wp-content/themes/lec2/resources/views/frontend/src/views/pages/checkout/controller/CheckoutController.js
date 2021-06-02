import AbstractController from '@/@core/web/controllers/abstract';

class CheckoutController extends AbstractController {
  main() {
  }

  init() {
    const today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#arrivalDatepicker').datepicker({
      uiLibrary: 'bootstrap4',
      minDate: today,
    });

    $('.validate-required').not(':has(.woocommerce-terms-and-conditions-checkbox-text, .woocommerce-privacy-policy-checkbox-text)').append('<span class="required-hint"></span>');

    $('#departureDatepicker').datepicker({
      uiLibrary: 'bootstrap4',
      minDate: today,
    });
  }
}

export default CheckoutController;
