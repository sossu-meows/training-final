import AbstractController from '@/@core/web/controllers/abstract';

class ContactController extends AbstractController {
  main() {
    this.enableButtonGGcaptcha();
  }
  enableButtonGGcaptcha() {
    const stateCheck = setInterval(() => {
      if (document.readyState === 'complete') {
        clearInterval(stateCheck);
        $('.gglcptch_recaptcha').closest('form').find('button[type="button"]').prop('disabled', false);
      }
    }, 100);
  }
}

export default ContactController;
