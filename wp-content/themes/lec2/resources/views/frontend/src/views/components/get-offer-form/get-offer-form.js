import { eliComponent, AbstractComponent } from '@/@core/web/eli-component';
/**
 *
 *
 * @class OfferForm
 */
@eliComponent({
  selector: '.js-offer-form',
})
class OfferForm extends AbstractComponent {
  selfClass = '.offer-form';

  /**
   * Main init offer map
   */
  init() {
    this.$OfferForm = this.find('form');
  }
}

export default OfferForm;
