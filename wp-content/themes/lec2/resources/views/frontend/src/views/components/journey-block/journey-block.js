import { eliComponent, AbstractComponent } from '@/@core/web/eli-component';

/**
 *
 *
 * @class Journey
 */
@eliComponent({
  selector: '.js-journey-block',
})
class Journey extends AbstractComponent {
  init() {
    this.initTrainingType();
  }

  initTrainingType() {
    const $typeItem = $('.journey-list .journey-item');
    $.each($typeItem, (i) => {
      const $typeIndex = $typeItem[i].dataset.index;
      const $typeHref = $typeItem[i].href;
      const $targetLink = $typeHref + $typeIndex;

      $typeItem[i].href = $targetLink;
    });
  }
}

export default Journey;
